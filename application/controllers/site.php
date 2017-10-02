<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

    public $system_maintenance = FALSE;
    public $summer_class = TRUE;
    public $timelimit = '19:00';
    public $max_user = 60;
    public $open_hour = '19:00-06:00';
    public $open_hour_max_user = 150;
    public $date_end = "2017-06-15";
    

    function __construct()
    {
        parent::__construct();      
        session_start();

        ENVIRONMENT != 'development' || $this->output->enable_profiler(TRUE);

        $data['site_title'] = 'University of Makati Online Encoding and Assessment Beta Version';
        $data['site_description'] = 'University of Makati Online Enrollment Beta Version - An Online Enrollment Solutions for UMak Students';
        $data['site_author'] = 'University of Makati ITC Department';
        $data['site_icon'] = 'assets/img/favicon.ico';      

        $this->load->model('M_enroll');
        $_SESSION['sy_sem'] = $this->M_enroll->get_current_sy_sem();
        $this->load->vars($data);

        // $this->system_maintenance = FALSE;
        // if (date('H:i') < date('H:i', strtotime($this->timelimit))) 
        //  $this->system_maintenance = TRUE;

        $hour = date('H:i');
        $open_hr = explode('-', $this->open_hour);
        $open_hr_start = date('H:i', strtotime($open_hr[0]));
        $open_hr_end = date('H:i', strtotime($open_hr[1]));
        
        if ($hour >= $open_hr_start || $hour <= $open_hr_end)
        $this->max_user = $this->open_hour_max_user;
    }


    public function index()
    {

        if($this->input->post('btn_submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_id','Student ID','strtoupper|trim|required|callback__limit_reached|callback__summer_class|callback__honorable_dismissal|callback__withdraw_credential|callback__leave_of_absence|callback__plus_to_losbs|callback_verify_account');
            $this->form_validation->set_rules('password','Password','required');
            if($this->form_validation->run() == TRUE)
            {
                $this->form_validation->set_rules('student_id','Student ID','trim|strtoupper|callback_verify_barred');
                if($this->form_validation->run() == TRUE)
                {
                    // $this->form_validation->set_rules('student_id','Student ID','trim|strtoupper');
                    // if($this->form_validation->run() == TRUE)
                    // {

                            $this->load->model('M_assessment');
                            $_SESSION['student_id'] = strtoupper($this->input->post('student_id', TRUE));
                            $_SESSION['student_info'] = $this->M_enroll->get_student_info($_SESSION['student_id']);    
                            $_SESSION['student_curriculum'] = $this->M_enroll->get_student_curriculum($_SESSION['student_id']);           
                            // echo $this->db->last_query();

                            /****** /.start payment./  ******/
                            $_SESSION['payment_mode'] = $this->db->where('StudNo', $_SESSION['student_id'])->where('SyId', $_SESSION['sy_sem']['SyId'])->where('SemId', $_SESSION['sy_sem']['SemId'])->get('tblpaymentmode')->row_array();
                            $_SESSION['token_fee_payment'] = $this->M_assessment->sum_tokenfee_payment($_SESSION['student_id'], $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
                            $_SESSION['token_fee_payment']['receipt'] = $this->M_assessment->get_tokenfee_payment($_SESSION['student_id'], $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
                            $_SESSION['misc_fee_payment'] = $this->M_assessment->sum_miscfee_payment($_SESSION['student_id'], $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
                            /****** /.end payment./  ******/
                                                
                            
                          //  print_r($_SESSION);

                            if(!empty($_SESSION['student_info']) && !empty($_SESSION['student_curriculum']))
                            {
                                $this->M_enroll->update_logged_in($_SESSION['student_id']);
                                $this->M_enroll->set_user_logs('Log In');
                                redirect('student');
                            }    
                            redirect('student');
                    // }
                }
                else
                {
                    $data['no_error'] = FALSE;
                }
            }
            else
            {
                $data['no_error'] = FALSE;
            }
        }   

       
        $date_t = date('Y-m-d');
        $date_h = date('H:i:s');

        $data['closed'] = FALSE;    
        $data['open'] = FALSE;

        // $date_t = '2017-05-02';
        // if($date_t > $_SESSION['sy_sem']['EnrollmentDateEnd'])
        // {
        //     $data['closed'] = TRUE;    
        // }


        if($date_t < $_SESSION['sy_sem']['EnrollmentDateStart'])
        {
            $data['open'] = TRUE;    
        }
        
        $total_login = $this->db->where('IsLoggedIn', 1)->get('tblstudentaccount');
        if($total_login->num_rows() > $this->max_user)
        {
            $data['closed'] = TRUE;
            $data['limit_reached'] = TRUE;
        }
        else
        {
            $data['limit_reached'] = FALSE;
        }

        

        $data['system_maintenance'] = $this->system_maintenance;
        if ($this->system_maintenance) 
        {
            $data['closed'] = TRUE;
            $data['system_message'] = "<strong>UMAK ONLINE ENROLLMENT AND ASSESSMENT</strong>.<br>Will be right back, we are working quickly to resolve the issue. Thank you for your patience.";
        }

        


        $this->load->view('template_home', $data);
    }

    public function _system_maintenance()
    {
        $time = date('h:i a', strtotime($this->timelimit));
        $message = "UMak Online Enrollment and Assessment will be right back, <br>we are working quickly to resolve the issue.
                    Thank you for your patience.";

        // if (strtotime($this->timelimit) > 0) 
        // $message = "We are undergoing system maintenance, this site will resume today " . date('F j, Y') . " at $time Thank you.";

        $this->form_validation->set_message('_system_maintenance', $message);
        return $this->system_maintenance;
    }

    public function _summer_class($studno)
    {
        if ( ! $this->summer_class) return TRUE;

        if (in_array($studno,['K1134747'])) return TRUE;

        $this->db->where('SyId', 6);
        $this->db->where('SemId', 3);
        $this->db->where('StudNo', $studno);
        $summer_class = $this->db->get('tblenrollmenttrans')->row_array();

        if ( ! empty($summer_class)) 
        {
            $date_start = '2017-05-29';
            $date = date('Y-m-d');
            if ($date < $date_start) 
            {
                if ($summer_class['IsEncoded'] == '1' && $summer_class['IsAssessed'] == 1) 
                {
                    // $Section1Theater = $this->db->where_in('cfn', array('A3156143', 'A3151644'))->where('StudNo', $studno)->get('tblstudentschedule')->num_rows();
                    // if (empty($Section1Theater)) 
                    // {
                        $this->form_validation->set_message('_summer_class', 
                        "REGISTRATION SCHEDULE FOR THOSE WHO TOOK THE 2017 SUMMER CLASSES IS ON MAY 29 TO JUNE 2, 2017.");
                        return FALSE;
                    // }
                }
            }
        }

        return TRUE;
    }

    public function _plus_to_losbs($studno)
    {  
        //--------Get College

        $this->db->select('A.StudNo, C.LengthOfStayBySem, B.ProgramLevel, B.CollegeId, CollegeCode, A.CurriculumId, Controlled, IsGraduateProgram, IsTCP');
        $this->db->join('tblcurriculum as B','A.CurriculumId = B.CurriculumId','LEFT');
        $this->db->join('tblstudinfo as C','A.StudNo = C.StudNo','LEFT');
        $this->db->join('tblcollege as D','B.CollegeId = D.CollegeId','LEFT');
        $this->db->where('A.StudNo',$studno);
        $query1 = $this->db->get('tblstudcurriculum as A');

        $extension = $query1->row_array();

        $enrollment_end_date = date('Y-m-d', strtotime($_SESSION['sy_sem']['EncodingDateEnd']));
        $now = date('Y-m-d');

        $enrollment_trans = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId'], $studno);

        if (empty($enrollment_trans))
        {

            if ($extension['CollegeCode'] == 'COAHS')
            {
                $enrollment_end_date = '2017-06-23';
            }

            if ($extension['CollegeCode'] == 'CGPP')
            {
                $enrollment_end_date = '2017-06-16';
            }

            if ($extension['CollegeId'] == 21)
            {
                $enrollment_end_date = '2017-08-04';
            }

            if ($enrollment_end_date < date('Y-m-d') && !(in_array($this->input->post('password', TRUE), ['UMAKREG MASTER KEY IS 317', 'BAMBINO041517', 'CBA 317']) ) ) 
            {
                $this->form_validation->set_message('_plus_to_losbs', "Enrollment is Now Closed");
                return FALSE;
            }
            $this->M_enroll->add_enrollment_trans($_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId'], $studno);
            $this->M_enroll->add_student_losby($studno, $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
            $this->M_enroll->promote_student($studno, $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
            $this->M_enroll->set_student_logs($studno, 'LengthOfStayBySem Promoted');
        }
        else 
        {
            if ($enrollment_trans['IsPromoted'] == 0)
            {
                $student = $this->M_enroll->get_student_info($studno);

                if ($student->LengthOfStayBySem == 0) 
                $this->M_enroll->add_student_losby($studno, $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
            
                $this->M_enroll->promote_student($studno, $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
                $this->M_enroll->set_student_logs($studno, 'LengthOfStayBySem Promoted');
            }
        }


        $email = $this->M_enroll->get_email($studno);
        if (empty($email)) 
        {
            $email = $this->M_enroll->set_email($studno);
        }

        $this->M_enroll->update_logged_in2();

        return TRUE;
    }

    public function _limit_reached()
    {
        $total_login = $this->db->where('IsLoggedIn', 1)->get('tblstudentaccount');
        if($total_login->num_rows() > $this->max_user)
        {
            // $this->form_validation->set_message('_limit_reached', 'The system can only accommodate 1000 users at a time. Please visit this page again later.');
            $this->form_validation->set_message('_limit_reached', 'Maximum user has been reached. Please visit this page again later.');
            return FALSE;
        }

        return TRUE;
    }

    public function _leave_of_absence($studno)
    {
        $SemId = $_SESSION['sy_sem']['SemId'];
        $SyId = $_SESSION['sy_sem']['SyId'];

        $this->form_validation->set_message('_leave_of_absence', 
            "You have applied for leave of absence, proceed to Registrar's Office for clearance.");

        $query = $this->db->query("SELECT * FROM tblstud_loa WHERE StudNo = '{$studno}' AND is_actived = 1 AND (
                        (LoaStartSyId <= '{$SyId}' AND '{$SyId}' <= LoaEndSyId AND IsOneYear = 1) 
                        OR 
                        (LoaStartSemId <= '{$SemId}' AND '{$SemId}' <= LoaEndSemId AND IsOneSem = 1))");
        ;
        // http://stackoverflow.com/questions/13513932/algorithm-to-detect-overlapping-periods
        // dump($this->db->last_query());
        // exit();

        if ($query->num_rows())
        {
            $this->M_enroll->set_student_logs($studno, 'Barred from enrollment due to LOA');
            return FALSE;
        }

        return TRUE;
    }

    public function _honorable_dismissal($studno)
    {
        $stud_hd_wc = $this->M_enroll->get_student_info($studno);

        if ( ! empty($stud_hd_wc)) 
        {
            $Lname = $stud_hd_wc['Lname'];
            $Fname = $stud_hd_wc['Fname'];
            $Mname = $stud_hd_wc['Mname'];
            $this->db->where("(StudNo not like '%LAW%')");
            $this->db->where("(StudNo = '{$studno}' OR (lname = '{$Lname}' AND fname = '{$Fname}' AND mname = '{$Mname}'))");
        }
        else 
        {
            $this->db->where('StudNo', $studno);
        }

        $this->db->where('is_actived', 1);
        $query = $this->db->get('tblstud_hd');

        $this->form_validation->set_message('_honorable_dismissal', "You have applied for honorable dismissal.");
        if ($query->num_rows())
        {
            $this->M_enroll->set_student_logs($studno, 'Barred from enrollment due to HD');
            return FALSE;
        }

        return TRUE;
    }

    public function _withdraw_credential($studno)
    {
        $stud_hd_wc = $this->M_enroll->get_student_info($studno);
        if ( ! empty($stud_hd_wc)) 
        {
            $Lname = $stud_hd_wc['Lname'];
            $Fname = $stud_hd_wc['Fname'];
            $Mname = $stud_hd_wc['Mname'];
            $this->db->where("(StudNo not like '%LAW%')");
            $this->db->where("(StudNo = '{$studno}' OR (lname = '{$Lname}' AND fname = '{$Fname}' AND mname = '{$Mname}'))");
        }
        else 
        {
            $this->db->where('StudNo', $studno);
        }
        
        $this->db->where('is_actived', 1);
        $query = $this->db->get('tblstud_wc');
        $this->form_validation->set_message('_withdraw_credential', "You have applied for withdrawal of credential.");
        if ($query->num_rows())
        {
            $this->M_enroll->set_student_logs($studno, 'Barred from enrollment due to WC');
            return FALSE;
        }

        return TRUE;
    }

    function verify_barred($studno)
    {
        $query = $this->db->get_where('tblbarredstudent', array('StudNo'=>$studno, 'olea'=>1, 'is_actived'=>1));
        if($query->num_rows())
        {
            $barred = $query->row_array();
            $this->form_validation->set_message('verify_barred', $barred['Remarks']);
            return FALSE;
        }

        $student = $this->db->get_where('tblstudinfo', array('StudNo'=>$studno));
        if ( ! $student->num_rows()) 
        {
            $this->form_validation->set_message('verify_barred', "Student record not found. Please try again.");
            return FALSE;
        }

        return TRUE;
    }

    function verify_account()
    {
        // initialize variables
        $sy_id = $_SESSION['sy_sem']['SyId'];
        $sem_id = $_SESSION['sy_sem']['SemId'];
        
        // id number
        $new_id_no = array(
            // 'A1'. substr($_SESSION['sy_sem']['SyCode'], 0, 2),         // 1st sem new student
            'B6'. substr($_SESSION['sy_sem']['SyCode'], 0, 2),            // 2nd sem new student
            'A' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // new student
            'B' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // 2nd sem new student
            'M' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // masteral
            );

        $new_m116_ids = array(
            'M11611482', 
            'M11611483', 
            'M11611484', 
            'M11611485', 
            'M11611486', 
            'M11611487', 
            'M11611488', 
            'M11611489', 
            'M11611490', 
            'M11611491', 
            'M11611492', 
            'M11612516', 
            'M11612517', 
            'M11612581', 
            'M11612582', 
            'M11612583', 
            'M11612584', 
            'M11612585', 
            'M11612586', 
            'M11612587', 
            'M11612588', 
            'M11612589', 
            'M11612590', 
            'M11612591', 
            'M11612592', 
            'M11612593', 
            'M11612594', 
            'M11612595', 
            'M11612596', 
            'M11612597', 
            'M11612598', 
            'M11612599', 
        );

        $_SESSION['skey'] = $this->input->post('password', TRUE);
        $studno = strtoupper($this->input->post('student_id', TRUE));
        
        $date = date('Y-m-d');
        $IsMasterKey = False;
        $MasterKeyLogin = FALSE;
        $FirstYearLogin = FALSE;

        if ( ! in_array($this->input->post('password', TRUE), ['BAMBINO041517', 'UMAKREG MASTER KEY IS 317'])) 
        $this->db->where('Password',md5($this->input->post('password')));
        $this->db->where('StudNo',$this->input->post('student_id'));
        $query = $this->db->get('tblstudentaccount');

        if($query->num_rows() > 0)
        {
            $active = $query->row_array();
            if($active['Status'] == 'I')
            {
                $this->form_validation->set_message('verify_account',
                "Sorry we can't give you access to Online Encoding and Assessment due to student record verification. 
                 Please go to the Registrar's Office for your On-site Registration.");
                
                return FALSE; 
            }
            
            if($active['Status'] == 'G')
            {
                $this->form_validation->set_message('verify_account', 
                "You have already accomplished the requirements in your previous program. 
                 To enroll in another program, please go to the Registrar's Office for <strong>re-tagging</strong>.");
                
                return FALSE;
            }
        }
        else 
        {
            $this->form_validation->set_message('verify_account', "Student Id Field  and Password Field did not match. Please try again");
            return FALSE;
        }

    
        if (in_array($this->input->post('password', TRUE), ['UMAKREG MASTER KEY IS 317', 'BAMBINO041517', 'CBA 317']))
        {
            $codelog = "";
            if ($this->input->post('password', TRUE) == "UMAKREG MASTER KEY IS 317") 
                $codelog = ".";
            elseif ($this->input->post('password', TRUE) == "CBA 317") 
                $codelog = ".";

            $this->M_enroll->set_student_logs($studno, "Login using MASTER KEY{$codelog}");
            $IsMasterKey = TRUE;
            // $this->M_enroll->set_student_logs($studno, "Pre-Enrolled");
            // return TRUE;
        }
    
        $date_t = date('Y-m-d');   
        $date_h = date('H:i:s');
        $enrollment_end_date = date('Y-m-d', strtotime($_SESSION['sy_sem']['EncodingDateEnd']));

        $is_freshmen = substr($studno, 0, 1) == 'K';

        $this->db->where('SyId', $sy_id);
        $this->db->where('SemId', $sem_id);
        $this->db->where('StudNo', $studno);
        $query0 = $this->db->get('tblenrollmenttrans');
        $enrollment_trans = $query0->row_array();

        $this->db->select('A.StudNo, C.LengthOfStayBySem, B.ProgramLevel, B.CollegeId, CollegeCode, A.CurriculumId, Controlled, IsGraduateProgram, IsTCP');
        $this->db->join('tblcurriculum as B','A.CurriculumId = B.CurriculumId','LEFT');
        $this->db->join('tblstudinfo as C','A.StudNo = C.StudNo','LEFT');
        $this->db->join('tblcollege as D','B.CollegeId = D.CollegeId','LEFT');
        $this->db->where('A.StudNo',$this->input->post('student_id'));
        $query1 = $this->db->get('tblstudcurriculum as A');

        $transferee = substr($studno, 1, 1) . substr($_SESSION['sy_sem']['SyCode'], 0, 2) == '6'. substr($_SESSION['sy_sem']['SyCode'], 0, 2);
        // $new_stud_id = 'A' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2) == substr($studno, 0, 4);
        $new_stud_id = in_array(substr($studno, 0, 4), $new_id_no);

        // test if student has enrollmenttrans record  
        if ($query0->num_rows() > 0) 
        {
            $student = $query0->row_array();

            if ($student['IsCancelled'] == '1') 
            {
                $this->form_validation->set_message('verify_account', 
                    'Your enrollment has been cancelled, proceed to Registrar\'s Office for details.');
                return FALSE;
            }
            
            // test if student is encoded and assessed 
            if ($student['IsEncoded'] == 1 && $student['IsAssessed'] == 1) 
            {
                // test if student is paid or scholar or promissory
                if ($student['IsPaid'] == '1' || $student['IsScholar'] == '1' || $student['IsPromissory'] == '1') 
                {

                    $nstp_subject = $this->M_enroll->get_nstp_subject($studno, $sy_id, $sem_id); 
                    // test student has nstp subject
                    if ( ! empty($nstp_subject)) 
                    {
                        $this->db->where(array('studno' => $studno, 'SyId' => $sy_id, 'SemId' => $sem_id, 'FeeId' => 51, 'is_actived' => 1));
                        $nstp_payment = $this->db->get('tblpayment');
                        // test nstp payment
                        if ($nstp_payment->num_rows() == 0) 
                        {
                            $this->form_validation->set_message('verify_account', 
                                'NSTP Payment is required. You have a NSTP subject, proceed to cash office for your NSTP payment.');
                            return FALSE;
                        }
                    }

                    // check if student has no copy of notice of admission
                    if (ENVIRONMENT == 'production') 
                    {
                        $this->db->where('StudNo', $studno);
                        $this->db->where('is_actived', 1);
                        $this->db->where('created_at >', '2017-01-01');
                        $tasc = $this->db->get(DBTASC . 'exam_results')->row();
                        // test college notice of admission
                        if ( ! empty($tasc)) 
                        {
                            if ($tasc->IsPrinted == '1') 
                            {
                                $this->form_validation->set_message('verify_account', 
                                    'Please proceed to the Registrar\'s office for instruction on how to claim your Certificate of Registration(COR)');
                            }
                            else
                            {
                                $this->form_validation->set_message('verify_account', 
                                    'Notice of admission is required. 
                                    Proceed to Testing Admission and Scholarship Center and get your Notice of Admission.');
                            }
                                return FALSE;
                        }
                    }

                    // test if newstudid or new master with M116 ids
                    if ($new_stud_id == TRUE || in_array($studno, $new_m116_ids)) 
                    {
                        // if ($IsMasterKey) 
                        // return TRUE;

                        $this->form_validation->set_message('verify_account', 
                             "Please proceed to the Registrar's office for instruction on how to claim your Certificate of Registration(COR)..");
                        return FALSE;
                    }

                    if ($transferee == TRUE) 
                    {
                        // if (in_array(substr($studno, 0, 4), array('B617', 'A617'))) 
                        // {
                            $this->form_validation->set_message('verify_account', "Please proceed to the Registrar's office for instruction on how to claim your Certificate of Registration(COR).");
                            return FALSE;
                        // }

                        //     // if ($new_stud_id = '6' . substr($_SESSION['sy_sem']['SyCode'], 0, 2) == substr($studno, 1, 3))
                        //     // {
                        //     //     $this->form_validation->set_message('verify_account', 
                        //     //          "Claim your Certificate of Registration(COR) at the Registrar's Office.");
                        //     //     return FALSE;
                        //     // }

                        // }

                    }

                }
            }


            // test printed/emailed cor
            if ($student['IsPrinted'] == '1')
            {
                $this->form_validation->set_message('verify_account', 
                    'Your Certificate of Registration (COR) has already been sent to your UMAK Email Account');
                return FALSE;
            }

            // test if student is NOT assessed and enrollment date END and NOT using master key
            if ($student['IsAssessed'] == 0 && ($date > $_SESSION['sy_sem']['EnrollmentDateEnd']) && $IsMasterKey == FALSE)
            {
                // student info 
                $FY = $query1->row_array();
                $lengthOfStay = $FY['LengthOfStayBySem'];
                $yr_lvl = trim($this->M_enroll->get_year_level($FY['CurriculumId'], $FY['CollegeId'], $lengthOfStay));

                // test if first student
                if (in_array($yr_lvl, array('First Year', '')) || $new_stud_id == TRUE || in_array(substr($studno, 0, 4), array('A117', 'A617', 'A217')) )
                return TRUE;

                // if you reached here stop access
                $this->form_validation->set_message('verify_account', 'Access denied. Online enrollment is now closed. '.$yr_lvl.' '. $_SESSION['sy_sem']['EnrollmentDateEnd']);
                return FALSE;
            }

        }

        // test master key         
        if ($IsMasterKey) 
        return TRUE;

        // test student info and curriculum 
        if ($query1->num_rows() == 0) 
        {
            $this->form_validation->set_message('verify_account','No Student Curriculum found. Please proceed to ITC Office.');
            return FALSE;
        }

        // test extension
        $extension = $query1->row_array();
        // if ($extension['CollegeCode'] == 'COAHS')
        // {
        //     $enrollment_end_date = '2016-11-11';
        // } 

        // if (in_array($extension['CollegeCode'], array('CHK', 'COE')))
        // {
        //     $enrollment_end_date = '2016-06-17';
        // }

        // if ($extension['CollegeCode'] == 'CGPP' && $extension['Controlled'] == '1')
        // {
        //     $enrollment_end_date = '2016-11-23';
        // }

        // if (in_array($extension['CollegeCode'], array('CGPP', 'COE')) && $extension['Controlled'] == '1')
        // {
        //     $enrollment_end_date = '2016-11-18';
        // }

        // student info 
        $FY = $query1->row_array();
        $lengthOfStay = $FY['LengthOfStayBySem'];
        $yr_lvl = trim($this->M_enroll->get_year_level($FY['CurriculumId'], $FY['CollegeId'], $lengthOfStay));

        // test if first student
        if (in_array($yr_lvl, array('First Year', '')) || $new_stud_id == TRUE || in_array(substr($studno, 0, 4), array('A117', 'A617', 'A217')) )
        $enrollment_end_date = $_SESSION['sy_sem']['EnrollmentDateEnd'];


        if ($extension['CollegeCode'] == 'COE')
        {
            $enrollment_end_date = '2017-06-09';
        }

        // test date if enrollment date end
        if($date > $enrollment_end_date)
        {
            // if ( ! (in_array($extension['CollegeCode'], array('CGPP', 'COE')) && $extension['Controlled'] != '1') )
            {
                // $this->form_validation->set_message('verify_account', 
                // 'You have failed to complete the online enrollment process before the deadline (<strong>' . date('F j, Y', strtotime($enrollment_end_date)) . '</strong>).');
                // return FALSE;
            }
            
        }

        $row = $query1->row_array();
        $length = $row['LengthOfStayBySem'];
        $yr_level = trim($this->M_enroll->get_year_level($row['CurriculumId'], $row['CollegeId'], $length));

        $EnrollmentDateStart = '2017-05-19';
        // if (ENVIRONMENT == 'development')
        // $EnrollmentDateStart = '2016-05-01';
        // else 
        // {
            if (in_array($yr_level, array('Fifth Year', 'Fourth Year')) || $row['IsGraduateProgram'] == '1' || $row['IsTCP'] == 1) 
                $EnrollmentDateStart = '2017-05-02';
            elseif (in_array($yr_level, array('Third Year', 'Second Year')))
                $EnrollmentDateStart = '2017-05-08';
            elseif (in_array($yr_level, array('First Year', '')) || $new_stud_id == TRUE || in_array(substr($studno, 0, 4), array('A117', 'A617', 'A217')))
            {
                // CAS, COE & COAHS
                if (in_array($row['CollegeId'], ['16', '11', '6', '17']))  
                $EnrollmentDateStart = '2017-05-11';

                // CCSCE, CTM, CCS, CHK, CMLI
                if (in_array($row['CollegeId'], ['15', '7', '3', '8', '13']))  
                $EnrollmentDateStart = '2017-05-15';

                // CGPP, CBDA
                if (in_array($row['CollegeId'], ['5']))  
                $EnrollmentDateStart = '2017-05-17';
                
                if (in_array($row['CollegeId'], ['18','19']) && $query0->num_rows() == 0)
                {
                    $EnrollmentDateStart = '2017-05-19';
                }

                $this->date_end = '2017-06-15';

            } 
        // }

        if ($row['CollegeId'] == 6 && $yr_level != 'First Year')
        {
            $EnrollmentDateStart = '2017-05-29';
        }

        if ($row['CollegeId'] == 11 || ($row['CollegeId'] == 5  && $row['Controlled']))
        {
            $EnrollmentDateStart = '2017-05-22';
            $this->date_end = '2017-06-15';
        }

        if ($row['CollegeId'] == 21 )
        {
            $EnrollmentDateStart = '2017-05-22';
            $this->date_end = '2017-08-04';
        }

        /*if (in_array($row['CollegeId'], [16, 17, 18, 19])) 
        {
            $this->form_validation->set_message('verify_account','Your Online Encoding and Assessment is temporarily closed due to on-going system update of the following colleges CBFS, CTHM, CAL and COS. Thank you. ' . $row['CollegeId']);
            return FALSE; 
        }*/

        // test if date beyond 
        if($date_t >= $EnrollmentDateStart)
        {
            if($date_t >= $this->date_end)
            {
                // student that is NOT assessed and encoded is not allowed to 
                if ($student['IsAssessed'] == 0 && $IsMasterKey == FALSE) 
                {
                    // $this->form_validation->set_message('verify_account','Online Encoding and Assessment is now closed.');
                    // return FALSE; 
                }
            }
            else
            {
                if ($student['IsAssessed'] == 0 && $IsMasterKey == FALSE) 
                {
                    // $this->form_validation->set_message('verify_account','Your Online Encoding and Assessment is still closed. Please check your registration schedule. ' . $yr_level . ' ' . $EnrollmentDateStart);
                    // return FALSE; 
                }
            }
        }   
        else
        {
            $this->form_validation->set_message('verify_account','Your Online Encoding and Assessment is still closed. Please check your registration schedule. ' . $yr_level);
            return FALSE; 
        }

        // dump($date_t);
        // dump($EnrollmentDateStart);
        // dump($EnrollmentDateStart);
        // exit();     
      
    }

    public function admin()
    {
        if($this->input->post('btn_login'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name','Username','callback_verify_admin_account');
            if($this->form_validation->run() == TRUE)
            {
                $_SESSION['username'] = $this->input->post('user_name');
                $this->load->model('M_admin');
                $this->M_admin->update_logged_in($_SESSION['username']);
                $_SESSION['user_info'] = $this->M_admin->get_user_info($_SESSION['username']);
                if($_SESSION['user_info']['UserType'] == 'A' || $_SESSION['user_info']['UserType'] == 'S')
                    redirect('assessment/changeOfResidency');
                if($_SESSION['user_info']['UserType'] == 'M')
                    redirect('assessment/MacesScholar');
                if($_SESSION['user_info']['UserType'] == 'E')
                    redirect('registration');                
            }
            else
            {
                $data['no_error'] = FALSE;
            }
        }
        $data['main_content'] = 'admin_login';
        $this->load->view('admin_template',$data);
    }

    function verify_admin_account()
    {
        $this->db->where('Username',$this->input->post('user_name'));
        $this->db->where('Password',md5($this->input->post('admin_password')));
        $query = $this->db->get('tbladminaccount');
        if($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('verify_admin_account','Username Field  and Password Field did not match. Please try again');
            return FALSE;
        }
    }

    public function manual()
    {
        $this->load->view('template_manual');
    }


 
// 24-hour time to 12-hour time 
// $time_in_12_hour_format  = DATE("g:i a", STRTOTIME("13:30"));
 
// 12-hour time to 24-hour time 
// $time_in_24_hour_format  = DATE("H:i", STRTOTIME("1:30 pm"));

}

/* End of file site.php */
/* Location: ./application/controllers/site.php */
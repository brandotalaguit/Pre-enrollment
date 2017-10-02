<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Brando
 * Date: 8/30/11
 * Time: 1:17 PM
 * To change this template use File | Settings | File Templates.
 */

class M_assessment extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function _is_coahs_assessed($StudNo, $SyId, $SemId)
    {
        
        $condition = array(
            'SyId' => $SyId, 
            'SemId' => $SemId,
            'StudNo' => $StudNo, 
            'is_actived' => 1, 
            );

        $this->db->where($condition);
        $assessment = $this->db->get('tblstudtuitions')->row_array();

        return count($assessment) ? $assessment : FALSE;
    }

    public function _is_tuition_exists($StudNo, $SyId, $SemId)
    {
        $condition = array();

        // check if student is already assessed 
        $assessment = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);
        if ($assessment) 
        {
            $condition['tuition_id'] =  $assessment['tuition_id'];
        }
        else
        {
            $curriculum_id = $_SESSION['student_curriculum']['CurriculumId'];
            
            if ($_SESSION['student_curriculum']['CollegeId'] == 6) 
                $condition['LengthOfStayBySem'] = $_SESSION['student_info']['LengthOfStayBySem'];
            
            $condition = array(
                'curriculum_id' => $curriculum_id, 
                'adjusted' => 0, 
                'is_actived' => 1,
            );
            
        }

        
        $this->db->where($condition);
        $tuition = $this->db->get('tbltuitions')->row_array();

        if (count($tuition)) 
        {
            // TUITION FEE DETAILS
            return $tuition;
        }

        return FALSE;
    }

    public function get_payment_scheme($total_units, $total_rle_hrs, $total_lab_units, $misc_fee, $payment_scheme, $tuition)
    {
        $tuition_fee = floatval($tuition['rate_per_unit']) * floatval($total_units);
        $rle_fee = floatval($tuition['rle_rate_per_hour']) * floatval($total_rle_hrs);
        $lab_fee = floatval($tuition['lab_rate_per_unit']) * floatval($total_lab_units);
        $misc_fee = floatval($tuition['misc_fee']);
        
        $total_fees = $tuition_fee + $rle_fee + $lab_fee + $misc_fee;

        if ($payment_scheme == 1) 
            $grand_total = $total_fees - ($tuition_fee * 0.10);
        elseif ($payment_scheme == 2) 
            $grand_total = $total_fees;
        elseif ($payment_scheme == 3) 
            $grand_total = $total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05);
        else
            $grand_total = $total_fees;


        return array(
                    'tuition_fee' => $tuition_fee, 
                    'rle_fee' => $rle_fee, 
                    'lab_fee' => $lab_fee, 
                    'misc_fee' => $misc_fee, 
                    'total_fees' => $total_fees, 
                    'grand_total' => $grand_total, 
                );
    }


    public function coahs_student_assess($StudNo, $SyId, $SemId, $tuition_id = NULL)
    {
        $tuition = $this->_is_tuition_exists($StudNo, $SyId, $SemId);

        if ( ! empty($tuition))
        {

            if ($tuition_id == NULL) 
            $tuition_id = $tuition['tuition_id'];

            $student = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);
            $payment_scheme = $this->input->post('payment_scheme');

            $t_units_sql = "SELECT SUM(IF(CourseCode NOT LIKE 'NSTP%', c.Units, 0)) as total_units FROM tblstudentschedule as a
                            LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                            LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                            WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
            $t_units = $this->db->query($t_units_sql)->row();

            $t_rle_sql = "SELECT SUM(RleHrs) as total_rle_hrs FROM tblstudentschedule as a
                            LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                            LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                            WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
            $t_rle = $this->db->query($t_rle_sql)->row();

            $t_lab_sql = "SELECT SUM(LabUnits) as total_lab_units FROM tblstudentschedule as a
                            LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                            LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                            WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
            $t_lab = $this->db->query($t_lab_sql)->row();

            $assessment = $this->get_payment_scheme($t_units->total_units, $t_rle->total_rle_hrs, $t_lab->total_lab_units, $tuition['misc_fee'], $payment_scheme, $tuition);

            $data = array(
                'SyId' => $SyId,
                'SemId' => $SemId,
                'StudNo' => $StudNo,
                'payment_scheme' => $payment_scheme,
                'tuition_id' => $tuition_id,
                'no_units' => $t_units->total_units,
                'tuition_fee' => $assessment['tuition_fee'],
                'no_rle_hours' => $t_rle ? $t_rle->total_rle_hrs : 0.00,
                'rle_fee' => $assessment['rle_fee'],
                'no_lab_units' => $t_lab ? $t_lab->total_lab_units : 0.00,
                'lab_fee' => $assessment['lab_fee'],
                'misc_fee' =>  $assessment['misc_fee'],
                'grand_total' => $assessment['grand_total'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if ($student == FALSE)
            {
                // save
                $this->db->insert('tblstudtuitions', $data);
                $id = $this->db->insert_id();
            }
            else
            {
                // update
                $id = $student['stud_tuition_id'];
                $data['updated_at'] = date('Y-m-d H:i:s');
                
                $this->db->where('stud_tuition_id', $id);
                $this->db->update('tblstudtuitions', $data);
            }

            $data['stud_tuition_id'] = $id;
            return $data;
        }

        return FALSE;
    }


    public function get_coahs_assessment($StudNo, $SyId, $SemId)
    {
        $assessment = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);
        if (count($assessment))
        {
            return $assessment;
        }

        return FALSE;
    }

    public function get_tuition_detail($StudNo, $SyId, $SemId)
    {
        $tuition = $this->_is_tuition_exists($StudNo, $SyId, $SemId);
        if ( count($tuition)) 
        {
            return $tuition;
        }

        return FALSE;
    }

    function has_scholarship($StudNo)
    {
        $scholar = $this->getScholarship($StudNo);
        if( ! empty($scholar))
            return TRUE;

        return FALSE;

    }

    // db where dept club fee 
    function get_fees($college_id = NULL, $program_id = NULL, $major_id = NULL)
    {
        $this->db->select('A.*,B.*');
        $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
        $this->db->from('tblassessmentinfo as A');

        if ($college_id !== NULL) 
        $this->db->where('A.CollegeId', $college_id);

        if ($program_id !== NULL) 
        $this->db->where('A.ProgramId', $program_id);
    
        if ($major_id !== NULL) 
        $this->db->where('A.MajorId', $major_id);

        // Do Not INCLUDE Ingles Club
        if ($_SESSION['sy_sem']['SemId'] != '1')
        {
            // ENG
            if ($college_id == 11 && in_array($program_id, array(15)) && in_array($major_id, array(9)))
            $this->db->where('A.FeeId !=', 33); 

            // MATH
            if ($college_id == 11 && in_array($program_id, array(15)) && in_array($major_id, array(14)))
            $this->db->where('A.FeeId !=', 10);    
        }

    }


    function getStudentOrg($StudNo, $CollegeId, $ProgramId, $MajorId)
    {
        // University Wide Fees
        // $fees = array(24, 25, 26, 31); // ssg, sgp, pia, group life insurance
        // $fees = array(24, 26, 31, 48);  // ssg, pia, group life insurance, CAF 
        $fees = array(26, 48, 25, 53);  // includes USMG formely known as sgp, USC & removed ssg
        if ($_SESSION['sy_sem']['SemId'] == '1')
        $fees[] = 31;

        // check if student has scholarship then include umak scholar feeid 22
        $scholar = $this->has_scholarship($StudNo);
        if ($scholar)
            $fees[] = 22;

        $this->get_fees($CollegeId, $ProgramId, $MajorId);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            if ($CollegeId == 11) 
            {
                // $fees = array(24, 26, 31, 44); // ssg, pia, group life insurance, Young Educator's Society(YES) - COE
                $fees[] = 44; // Young Educator's Society(YES) - COE
            }

            if ($CollegeId == 6) 
            {
                $fees[] = 49; // COAHS Research Society
            }

            $this->get_fees($CollegeId, $ProgramId, $MajorId);
            $this->db->or_where_in('B.FeeId', $fees);
            $query = $this->db->get();
        }
        else 
        {

            if ($CollegeId == 11) 
            {
                // $fees = array(24, 26, 31, 44); // ssg, pia, group life insurance, Young Educator's Society(YES) - COE
                $fees[] = 44; // Young Educator's Society(YES) - COE
            }
            
            if ($CollegeId == 6) 
            {
                $fees[] = 49; // COAHS Research Society
            }
            


            $this->get_fees($CollegeId, $ProgramId, 0);
            $query = $this->db->get();


            if($query->num_rows() > 0) 
            {
                $this->get_fees($CollegeId, $ProgramId, 0);
                $this->db->or_where_in('B.FeeId', $fees);
                $query = $this->db->get();
            } 
            else 
            {
                $this->get_fees($CollegeId, 0, 0);
                $this->db->or_where_in('B.FeeId', $fees);
                $query = $this->db->get();
            }


        }
        
        $row = array();


        if($query->num_rows() > 0) 
        $row = $query->result_array();

        $this->db->close();
        return $row;

    }


    /**
     * Assess per subject NSTP included here
     */

    function getAssPerSubject($StudNo)
    {
        $this->db->query('SET SQL_BIG_SELECTS = 1');
        $this->db->select('D.AssId, A.*, H.CourseCode, E.*, COUNT(*) as cntr');
        $this->db->from('tblstudentschedule as A ');

        // $this->db->join('tblcoursesched as B','A.Cfn = B.Cfn','inner');
        $this->db->join('tblsched as B', 'A.Cfn = B.Cfn', 'inner');
        $this->db->join('tblcourse as H', 'H.CourseId = B.subject_id', 'inner');
        $this->db->join('tblassessmentinfo as D ', 'H.CourseCode =  D.CourseCode', 'inner');
        $this->db->join('tblfees as E ','D.FeeId = E.FeeId', 'inner');

        $this->db->where('A.StudNo', $StudNo);
        $this->db->where('A.SyId', $_SESSION['sy_sem']['SyId']);
        $this->db->where('A.SemId', $_SESSION['sy_sem']['SemId']);
        // $this->db->not_like('H.CourseCode', 'NSTP', 'after');
        // $this->db->where('H.CourseCode !=', 'NSTP 1');
        // $this->db->where('H.CourseCode !=', 'NSTP 2');
        $this->db->group_by('E.FeeId');
        $query = $this->db->get();
        
        $row = array();
        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }

        $fil_subject = $this->getAssFilSubject($StudNo);
        if (is_array($fil_subject))
        $row[] = $fil_subject;

        $this->db->close();
        return $row;
    }


    function getAssFilSubject($StudNo)
    {
        // prevent function execution
        return FALSE;
        
        $sy_id = $_SESSION['sy_sem']['SyId'];
        $sem_id = $_SESSION['sy_sem']['SemId'];
        $fil_curriculum = array('12', '111', '181');

        $this->db->where('StudNo', $StudNo);
        $curriculum = $this->db->get('tblstudcurriculum as A')->row_array();
        if ( ! in_array($curriculum['CurriculumId'], $fil_curriculum)) 
        {
            $filipino_schedule = array();
            $this->db->where('IsActive', 1);
            $this->db->like('CourseCode', 'FIL', 'after');
            $filipino_schedule = $this->db->where('StudNo', $StudNo)->where('A.SyId', $sy_id)->where('A.SemId',$sem_id)->join('tblsched as B','A.Cfn = B.cfn','left')->join('tblcourse as C','B.subject_id = C.CourseId','left')->order_by('A.Cfn')->get('tblstudentschedule as A')->result_array();  
            
            if ( ! empty($filipino_schedule)) 
            {
                // KAFIL = 20.00
                $this->db->where('FeeId', 52);
                return $this->db->get('tblassessmentinfo')->row_array();
            }
        }

    }


     function getNSTPFEE($StudNo)
    {
        // $this->db->select('D.AssId, A.*, H.CourseCode, E.*, COUNT(*) as cntr');
        $this->db->from('tblstudentschedule as A ');

        $this->db->join('tblsched as B','A.Cfn = B.Cfn','left');
        $this->db->join('tblcourse as H','H.CourseId = B.subject_id','left');
        // $this->db->join('tblassessmentinfo as D ','H.CourseCode =  D.CourseCode','inner');
        // $this->db->join('tblfees as E ','D.FeeId = E.FeeId','inner');

        $this->db->where('A.StudNo',$StudNo);
        $this->db->where('A.SyId',$_SESSION['sy_sem']['SyId']);
        $this->db->where('A.SemId',$_SESSION['sy_sem']['SemId']);

        $this->db->like('H.CourseCode', 'NSTP', 'after');
        // $this->db->where('(H.CourseCode = "NSTP 2" OR H.CourseCode ="NSTP 1")');

        // $this->db->group_by('E.FeeId');

        $nstp = $this->db->get();

        $row = array();
        if ($nstp->num_rows() > 0)
        {
            $this->db->from('tblassessmentinfo as D');
            $this->db->join('tblfees as E ','D.FeeId = E.FeeId','inner');
            $this->db->where('D.CourseCode', 'NSTP');
            $query = $this->db->get();
            $row = $query->result_array();
        }


        $this->db->close();
        return $row;
    }

    public function get_nstp_payment($studno, $sy_id, $sem_id)
    {
        $this->db->where(array('StudNo' => $studno, 'SyId' => $sy_id, 'SemId' => $sem_id, 'FeeId' => 51, 'is_actived' => 1));
        $payment = $this->db->get('tblpayment')->row_array();

        return $payment;
    }



     function getLabFee($StudNo)
    {
/*        $this->db->where('CollegeId',4);
        $this->db->where('ProgramId',11);
        $this->db->where('MajorId',1);
        $this->db->where('StudNo',$StudNo);
        $query = $this->db->get('tblstudcoursesched');*/

        $row = array();
        // if($query->num_rows() > 0) {
        if($_SESSION['student_curriculum']['CollegeId']==4 && $_SESSION['student_curriculum']['ProgramId'] == 11 && $_SESSION['student_curriculum']['MajorId'] == 1) {
            $this->db->select('A.*,B.*');
            $this->db->from('tblassessmentinfo as A');
            $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
            $this->db->where('A.AssId',49);
            $query = $this->db->get();
        } else {
            $sql = "SELECT  COUNT( * ), IF( COUNT(*)>=2, 49, 7) as AssId,  B.FeeId, B.FeeDesc, IF( COUNT(*)>=2, 100.00, 50.00) as Amount 
                    FROM tblassessmentinfo AS  A 
                        INNER JOIN  tblfees AS B ON  A.FeeId = B.FeeId 
                        INNER JOIN  tblstudentschedule AS C 
                        INNER JOIN  tblsched AS E ON E.cfn = C.cfn
                        INNER JOIN  tblcourse AS D ON D.courseid = E.subject_id
                    WHERE  C.StudNo = '" . $StudNo 
                     ."' AND C.SyId = " . $_SESSION['sy_sem']['SyId'] 
                     ." AND C.SemId = " . $_SESSION['sy_sem']['SemId']
                     ." AND D.WithComputerSubject = 1 AND 
                        B.FeeId = 19
                    GROUP BY  B.FeeId";
            $query = $this->db->query($sql);
        }

        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        
        $this->db->close();
        return $row;
    }

    function getScholarship($StudNo)
    {
        $this->db->select('A.*,B.*');
        $this->db->from('tblstudentscholar as A ');
        $this->db->join('tblscholarship as B','A.ScholarshipId = B.ScholarshipId','inner');
        $this->db->where('A.StudNo', $StudNo);
        $this->db->where('A.SyId', $_SESSION['sy_sem']['SyId']);
        $this->db->where('A.SemId', $_SESSION['sy_sem']['SemId']);
        $query = $this->db->get()->row_array();
        
        return $query;

    }


    function getIDFee($StudNo)
    {
        $row = array();
        // remove ID Fee from misc fee collection
        return $row;

        $transferee = substr($StudNo, 1, 1) . substr($_SESSION['sy_sem']['SyCode'], 0, 2) == '6'. substr($_SESSION['sy_sem']['SyCode'], 0, 2);
        $new_stud_id = 'A' . $_SESSION['sy_sem']['SemId'] . substr($_SESSION['sy_sem']['SyCode'], 0, 2) == substr($StudNo, 0, 4);

        // check if student has no copy of notice of admission
        $this->db->where('StudNo', $StudNo);
        $this->db->where('is_actived', 1);
        $this->db->where('created_at >', '2017-01-01');
        $tasc = $this->db->get(DBTASC . 'exam_results')->row();
        if ( ! empty($tasc)) 
        {
            if ($tasc->IsPrinted == '1') 
            {
                $new_stud_id = TRUE;
            }
        }

        if ($new_stud_id == TRUE || $transferee == TRUE) 
        {
            $fee_id = 37;
            $this->db->where(['FeeId' => $fee_id, 'StudNo' => $StudNo]);
            $umak_id = $this->db->get('tblpaymentmisc');
            $this->db->close();

            if ($umak_id->num_rows()>0) 
            return $row;

            $this->db->select('A.*,B.*');
            $this->db->from('tblassessmentinfo as A');
            $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
            $this->db->where('A.AssId', 76);

            $row = $this->db->get()->result_array();
        }

        $this->db->close();
        return $row;
    }


    function assessmentISO($StudNo, $SemId, $SyId, $time_start)
    {
       $condition = array(
           'StudNo' => $StudNo,
           'SyId' => $SyId,
           'SemId' => $SemId
       );

       $data = $this->db->where($condition)->get('tblassessmentiso');
       if ($data->num_rows() == 0) 
       {
           $new_data = array(
               'SyId' => $SyId,
               'SemId' => $SemId,
               'StudNo' => $StudNo,
               'time_start' => $time_start,
               'time_end' => date('Y-m-d H:i:s'),
               'User' => $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Mname'] . ' ' . $_SESSION['user_info']['Lname']
           );
           $this->db->insert('tblassessmentiso', $new_data);
       }
       else
       {
           $new_data = array(
               'time_end' => date('Y-m-d H:i:s'),
               'User' => $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Mname'] . ' ' . $_SESSION['user_info']['Lname']
           );
           
           $this->db->where($condition)->limit(1)->update('tblassessmentiso', $new_data);
       }

       $assess_data = array(
           'IsAssessed' => 1, 
           'AssessedDateTime' => date('Y-m-d H:i:s') 
       );
       $this->db->where($condition)->limit(1)->update('tblenrollmenttrans', $assess_data);

    }

    

    function getTuitionFee($StudNo)
    {
        $residency = $this->getResidency($StudNo);  # adjustment only owned voters are allowed for online assessment
        // $ownedvoter = $this->getVotersCertificate($StudNo);

        # Fetch student assessment
        $this->db->select('A.*, B.*');
        $this->db->from('tblassessmentinfo as A');
        $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');

        # only students who owned voters allowed to be assessed
            
           
        $AssId = 5;                         # Non-Makati Tuition Fee
        if ($residency == '1') $AssId = 2;  # Makati Tuition Fee


        # Get Hsu Graduates
        //------------------------------------------------------------------------------------------------------------------
        $HsuGradSql = "Select count(stud_id) as cnt from  ". DBHSU ."student_enrollments 
                       where sy_id = 6  and sem_id =2 and is_actived = 1  and yr_level = 'GRADE 12' and stud_id = '{$StudNo}' ";

        $HsuGrad = $this->db->query($HsuGradSql)->row();
        // ------------------------------------------------------------------------------------------------------------------
        if ($HsuGrad->cnt > 0)  $AssId = 2;

        $this->db->where('A.AssId', $AssId);
        /*
        if ( $ownedvoter == TRUE ) 
        {
            $this->db->where('A.AssId',2);
        }
        */

        $query = $this->db->get();

        $row = array();
        if($query->num_rows() > 0)
        $row = $query->result_array();

        $this->db->close();
        return $row;
    }

    function getVotersCertificate($StudNo)
    {
        $this->db->from('tblstudinfo');
        $this->db->where('StudNo',$StudNo);
        $voters = $this->db->get();

        return $voters->row()->VotersCertificate == 1 ? TRUE : FALSE;
    }

    function getStudentAssessment($StudNo, $single = FALSE, $SySem = NULL, $SyId = NULL)
    {
        // Fetch assessment 
        $this->db->select('C.*');
        $this->db->from('tblassessmenttrans as A');
        $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
        $this->db->join('tblfees as C','C.FeeId = B.FeeId');
        $this->db->order_by('FeeDesc');
        
        $SySem !== NULL ? $this->db->where('A.SemId', $SySem) : $this->db->where('A.SemId', $_SESSION['sy_sem']['SemId']);
        $SyId  !== NULL ? $this->db->where('A.SyId', $SyId) : $this->db->where('A.SyId', $_SESSION['sy_sem']['SyId']);
                

        $this->db->where('A.StudNo', $StudNo);
        
        $method = $single ? 'row_array' : 'result_array';

        return $this->db->get()->$method();
    }

    function getStudentPayment($StudNo, $single = FALSE, $SySem = NULL, $SyId = NULL)
    {
        // Fetch assessment 
        $this->db->select('FeeDesc, A.*');
        // $this->db->from('tblassessmenttrans as A');
        // $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
        $this->db->from('tblpaymentmisc as A');
        $this->db->join('tblfees as C','C.FeeId = A.FeeId', 'LEFT');

        $SySem !== NULL ? $this->db->where('A.SemId', $SySem) : $this->db->where('A.SemId', $_SESSION['sy_sem']['SemId']);
        $SyId  !== NULL ? $this->db->where('A.SyId', $SyId) : $this->db->where('A.SyId', $_SESSION['sy_sem']['SyId']);
                

        $this->db->where('A.StudNo', $StudNo);
        
        $method = $single ? 'row_array' : 'result_array';

        return $this->db->get()->$method();
    }



    function get_landbank_referrence($StudNo, $SemId, $SyId)
    {
        $conditions = array(
            'SemId' => $SemId,
            'SyId' => $SyId,
            'StudNo' => $StudNo,
            'actived' => 1
        );

        return $this->db->where($conditions)->get('tbllandbank')->row();
    }

    function landbank_referrence($StudNo, $SemId, $SyId)
    {

        # set timestamps
        $now = date('Y-m-d H:i:s');
        $ref_num = $this->get_landbank_referrence($StudNo, $SemId, $SyId);
        $conditions = array('SemId' => $SemId, 'SyId' => $SyId, 'StudNo' => $StudNo);

        $data = array(
            'StudNo' => $StudNo, 
            'SemId' => $SemId, 
            'SyId' => $SyId,
            'landbank_acct' => $this->input->post('methodpayment'),
            'created_at' => $now
        );

        if (count($ref_num) > 0) 
        {
            # set actived to 0
            $this->db->where($conditions)->update('tbllandbank', array('actived' => 0));
            $data['created_at'] = $ref_num->created_at;
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->db->flush_cache();
        }

        # save
        $this->db->set($data);
        $this->db->insert('tbllandbank');
        $id = $this->db->insert_id();

        $this->db->flush_cache();

        # update assessmenttrans
        $this->db->where($conditions)->update('tblassessmenttrans', array('landbank_id' => $id));
        $this->db->flush_cache();

        return $id;
    }

     function AssessStudent($StudNo, $SemId, $SyId, $CollegeId, $ProgramId, $MajorId, $data1 = NULL, $data2 = NULL, $data3 = NULL, $data4 = NULL, $data5 = NULL)
    {
        $this->db->select('A.*');
        $this->db->from('tblassessmenttrans as A');
        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $this->db->where('StudNo',$StudNo);

        $query = $this->db->get();

        if($query->num_rows() > 0) 
        {
            $this->db->where('SyId', $SyId);
            $this->db->where('SemId', $SemId);
            $this->db->where('StudNo', $StudNo);
            $this->db->delete('tblassessmenttrans');
        }

        //$data3 = $this->getScholarship($StudNo);

        /**
         * Fetch assessment per categories
         * @param: $StudNo, $CollegeId,$ProgramId,$MajorId
         **/

        if ($data1 === NULL)
        $data1 = $this->getStudentOrg($StudNo, $CollegeId, $ProgramId, $MajorId);

        if ($data2 === NULL)
        $data2 = $this->getAssPerSubject($StudNo); 

        // if ($data3 === NULL)
        // $data3 = $this->getNSTPFEE($StudNo);
        $data3 = array();

        if ($data5 === NULL)
        $data5 = $this->getLabFee($StudNo);

        if ($data4 === NULL)
        $data4 = $this->getTuitionFee($StudNo);
    
        // Fetch University ID Fee
        $dataID = array();
        if ($_SESSION['sy_sem']['SemId'] == '1') 
        {
            $dataID = $this->getIDFee($StudNo);
        }

        // Process assessment
        $data = array();
        foreach($data1 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'],
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
        }

        $data = array();
        foreach($data2 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
        }

        $data = array();
        foreach($data3 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
            
        }
        // echo $this->db->last_query();
        
        $data = array();
        foreach($data5 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
            
        }

        // DO NOT assess coahs students -- 06-04-2015 02:02 PM
        if ($CollegeId != 6)
        {
            $data = array();
            foreach($data4 as $assess) {
                $data = array(
                    'AssId' => $assess['AssId'] ,
                    'SyId' => $SyId ,
                    'SemId' => $SemId ,
                    'StudNo' => $StudNo
                );
                $this->db->insert('tblassessmenttrans', $data);
            }
        }

        // remove University ID Fee from Misc Fee Collection
        // $data = array();
        // foreach($dataID as $assess) {
        //     $data = array(
        //         'AssId' => $assess['AssId'] ,
        //         'SyId' => $SyId ,
        //         'SemId' => $SemId ,
        //         'StudNo' => $StudNo
        //     );
        //     $this->db->insert('tblassessmenttrans', $data);
        // }
        $this->db->close();

    }

     function isAssessIdExist($StudNo,$SyId,$SemId,$AssessId)
    {
        $this->db->select('A.FeeId');
        $this->db->where('StudNo', $StudNo);
        $this->db->where('SyId', $SyId);
        $this->db->where('SemId', $SemId);
        $this->db->where('A.AssId', $AssessId);
        $this->db->join('tblassessmentinfo as A','A.AssId = B.AssId', 'left');

        return FALSE;
    }

    function isStudentAssessed($StudNo,$SyId,$SemId)
    {
        $this->db->where(array('StudNo' => $StudNo, 'SyId' => $SyId, 'SemId' => $SemId));
        $enrollment_trans = $this->db->get('tblenrollmenttrans')->row_array();
        
        if ( ! empty($enrollment_trans))
            if ($enrollment_trans['IsAssessed'] == '1')
                return TRUE;

        return FALSE;
    }
    
    /**
     * Identify weather the student is a makati / non-makati
     * by using student birthday and voters certification
     * @param: StudNo
     * @return: int 
     **/

    function getResidency($StudNo)
    {
        // if($this->ageCalculator($StudNo) == 18 AND $this->isAccountingVerified($StudNo) == FALSE) 
        // {
        //     return FALSE;
        // } 

        // if it get here then student is a makati residence 
        // return TRUE


        $this->db->select('IsMakatiResident, VotersCertificate, LengthOfStayBySem');
        $student = $this->db->where('StudNo',$StudNo)->get('tblstudinfo')->row();
        $this->db->close();
        if ( ! empty($student)) 
        {
            $yr_level = $this->M_enroll->get_year_level($_SESSION['student_curriculum']['CurriculumId'], 
                $_SESSION['student_curriculum']['CollegeId'], 
                $student->LengthOfStayBySem);

            // if ($_SESSION['sy_sem']['SemId'] == 2 && in_array($student->LengthOfStayBySem, array(1, 2)))    # 1st Year 1st Sem, 1st Year 2nd Sem. 
            if ($_SESSION['sy_sem']['SemId'] == 2 && $yr_level == 'First Year')    # 1st Year 1st Sem, 1st Year 2nd Sem. 
            {
                // update RESIDENCY & VOTERS to 0
                $this->db->limit(1);
                $this->db->where('StudNo', $StudNo);
                $this->db->update('tblstudinfo', array('IsMakatiResident' => 0, 'VotersCertificate' => 0));
                $this->db->close();

                $this->M_enroll->set_user_logs('First Year Student Set Residency to Non-Makati');

                return 0;
            }

            return $student->IsMakatiResident;
            
        }
        
        return 0;
    }

    function isAccountingVerified($StudNo)
    {
        $where = array(
            'StudNo' => $StudNo, 
            'SemId' => $_SESSION['sy_sem']['SemId'],
            'SyId' => $_SESSION['sy_sem']['SyId']
        );
            
		return $this->db->limit(1)->where($where)->get('tblverifiedmakati')->num_rows() > 0 ? TRUE : FALSE;
    }

     function ageCalculator($StudNo)
    {
        $AgeToday = $this->db->query('SELECT (YEAR(CURDATE())-YEAR(BirthDay)) - (RIGHT(CURDATE(),5) < RIGHT(BirthDay,5)) as AgeToday FROM tblstudinfo WHERE StudNo = "'.$StudNo.'" LIMIT 1')->row()->AgeToday;
        // echo $this->db->last_query();
        $this->db->close();
        return $AgeToday;
    }

     function get_paymentMode($StudNo)
     {
        $this->db->where('StudNo',$StudNo);
        $this->db->where('SemId',$_SESSION['sy_sem']['SemId']);
        $this->db->where('SyId',$_SESSION['sy_sem']['SyId']);
        $paymode = $this->db->get('tblpaymentmode')->row_array();

        return $paymode;
     }

     function getAssessment($StudNo,$SyId,$SemId,$UserType)
    {
        $this->db->select('A.StudNo, A.AssId');
        $this->db->from('tblassessmentTrans as A');
        $this->db->where('SyId', $SyId);
        $this->db->where('SemId', $SemId);
        $this->db->where('A.StudNo',$StudNo);

        $query = $this->db->get();
        $this->db->close();

        if($query->num_rows() > 0) {
                    $this->db->select('C.*');
                    $this->db->from('tblassessmenttrans as A');
                    $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
                    $this->db->join('tblfees as C','C.FeeId = B.FeeId');
                    $this->db->where('A.SyId', $SyId);
                    $this->db->where('A.SemId', $SemId);
                    $this->db->where('A.StudNo',$StudNo);
            switch(true){
                case $UserType == 'C':  // cash

                    $where = '(C.FeeId = 20 OR C.FeeId = 21 OR C.FeeId = 16)';
                    $this->db->where($where);
                    $data = $this->db->get();
                    $row = $data->result_array();
                    return $row;
                    break;
                case $UserType == 'O':  // student organization

                    $where = 'NOT(C.FeeId = 20 OR C.FeeId = 21 OR C.FeeId = 16)';
                    $this->db->where($where);
                    $data = $this->db->get();
                    $row = $data->result_array();
                    return $row;
                    break;
                default :
                    return "Unauthorize Access!";
                    break;
            }

        }
    }

     function getTable2($TableName,$Field,$KeyCode,$Where='')
    {
        $this->db->select('A.*');
        $this->db->from( $TableName . ' as A');
        $this->db->where('A.'.$Field ,$KeyCode);

        if($Where)
        $this->db->where($Where);

        $query = $this->db->get();
        $row = array();
        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        $this->db->close();
        return $row;
    }


     function getTable($TableName,$Field,$KeyCode,$Where='')
    {
        $this->db->select('A.*');
        $this->db->from( $TableName . ' as A');
        $this->db->where('A.'.$Field ,$KeyCode);
        if($Where)
        $this->db->where($Where);

        $query = $this->db->get();
        $data = $query->row();
        $this->db->close();

        return $data;
    }

     function CountTfPayment($StudNo)
    {
        $sql = 'SELECT A.* FROM  `tblpaymenttrans` as A
                    WHERE StudNo =  "'.$StudNo.'" AND
                            SyId = "'.$_SESSION['SyId'].'" AND
                            SemId = "'.$_SESSION['SemId'].'" AND
                            ( FeeId = 20 OR FeeId = 21)';
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

     function totalTFPayment($StudNo)
    {
        $sql = 'SELECT SUM( AmountPaid ) AS AmountPaid, StudNo FROM  `tblpaymenttrans`
                    WHERE StudNo =  "'.$StudNo.'" AND
                        SyId = "'.$_SESSION['SyId'].'" AND
                        SemId = "'.$_SESSION['SemId'].'" AND 
                        ( FeeId = 20 OR FeeId = 21 )
                    GROUP BY StudNo, SyId, SemId';
        $query = $this->db->query($sql);
        $data = $query->row();
        $this->db->close();
        return $data;
    }

     function getSem($SemId)
    {
        $this->db->select('A.*');
        $this->db->from('tblsem as A');
        $this->db->where('A.SemId',$SemId);

        $query = $this->db->get();
        $data = $query->row();
        $this->db->close();

        return $data;
    }

     function getSy($SyId)
    {
        $this->db->select('A.*');
        $this->db->from('tblsy as A');
        $this->db->where('A.SyId',$SyId);

        $query = $this->db->get();
        $data = $query->row();
        $this->db->close();

        return $data;
    }

     function getOR($OrNum)
    {
        $this->db->select('A.*');
        $this->db->from('tblpaymenttrans as A');
        $this->db->where('A.OrNo',$OrNum);

        $query = $this->db->get();
        $this->db->close();

        if($query->num_rows() > 0) {
            return true;
        }

    }

      function getAllScholarship()
    {
        $query = $this->db->order_by('DiscountPercentage, ScholarshipDesc')->get('tblscholarship');
        return $query->result_array();
    }

     function getFee($FeeId)
    {
        $this->db->select('A.*');
        $this->db->from('tblfees as A');
        $this->db->where('A.FeeId',$FeeId);

        $query = $this->db->get();
        $data = $query->row();
        $this->db->close();

        return $data;
    }

     function getPayment($OrNum,$table)
    {
        $this->db->select('A.*');
        $this->db->from($table . ' as A');
        $this->db->where('A.OrNo',$OrNum);

        $query = $this->db->get();
        $data = $query->result_array();
        $this->db->close();

        return $data;
    }

    function sum_tokenfee_payment($StudNo, $SyId, $SemId)
    {
        $data = array();
        $this->db->select_sum('Amount');
        $this->db->where_in('feeid', array('20', '21', '47'));
        $this->db->where('is_actived', 1);
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);
        $data = $this->db->get('tblpayment')->row_array();
        $this->db->close();

        return $data;
    }

    function sum_miscfee_payment($StudNo, $SyId, $SemId)
    {
        $data = array();
        $this->db->select_sum('Amount');
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);        
        $data = $this->db->get('tblpaymentmisc')->row_array();
        $this->db->close();

        return $data;
    }


    function get_tokenfee_payment($StudNo, $SyId, $SemId)
    {
        $data = array();
        $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId)->where_in('A.FeeId', array('20', '21', '47'));
        $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
        $data = $this->db->get('tblpayment as A')->result_array();
        $this->db->close();

        return $data;
    }

    function get_miscfee_payment($StudNo, $SyId, $SemId )
    {
        $data = array();

        $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);
        $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
        $data = $this->db->get('tblpaymentmisc as A')->result_array();
        $this->db->close();
        
        return $data;
    }

     function payment1($StudNo,$SemId,$SyId,$UserName)
    {
        $Nstp = $this->getFee(16);
        $NstpFee = $Nstp->Amount;
        $this->db->close();

        $User = $this->getTable('tbladminaccount','Username',$UserName);
        $CashUser = $User ? $User->AdminId : ' ';

        $date_now = date('Y-m-d H:i:s',time());

        $Scholarship = $this->getScholarship($StudNo);
        $discount = $Scholarship ? $Scholarship->DiscountPercentage : '0.00' ;
        $data = $this->input->post('fee');

            foreach($data as $field => $value) {
                $this->db->select('A.*');
                $this->db->from('tblfees as A');
                $this->db->where('A.FeeId',$value);
                $row = $this->db->get();
                $tblFees = $row->row();

                if($value == 16) {
                    $amount = $tblFees->Amount;
                } else {
                    if($this->input->post('txtPayable') >= $this->input->post('txtAmount') ) {
                        $amount = ($this->input->post('txtAmount') - ( count($data) > 1 ? $NstpFee : 0.00 ) );
                    } else {
                        if($value == 20 || $value == 21) {
                            if($this->input->post('txtAmount') >= $tblFees->Amount)
                                $amount = $tblFees->Amount - ($tblFees->Amount * $discount);
                            else
                                $amount = ($this->input->post('txtPayable') - ( count($data) > 1 ? $NstpFee : 0.00 ) );
                        } else {
                            $amount = $tblFees->Amount;
                        }
                    }
                }

                $data2 = array(
                    'StudNo' => $StudNo,
                    'AmountPaid' => $amount ,
                    'Officer' => $CashUser ,
                    'FeeId' => $tblFees->FeeId,
                    'BookletNo' => $this->input->post('txtBooklet'),
                    'OrNo' => $this->input->post('txtOrNum'),
                    'SyId' => $SyId,
                    'SemId' => $SemId
                );
                $this->db->insert('tblpaymenttrans', $data2);
                $this->db->where('StudNo',$StudNo);
                $this->db->where('SyId',$SyId);
                $this->db->where('SemId',$SemId);
                $data2 = array(
                    $value == 16 ? 'PaidNSTPDateTimeStart' : 'PaidTokenDateTimeStart' => $date_now
                );
                $this->db->update('tblenrollmenttrans',$data2);
                $this->db->close();
            }
    }

     function payment2($StudNo,$SemId,$SyId,$UserName)
    {
        $data = $this->input->post('fee');
        $User = $this->getTable('tbladminaccount','Username',$UserName);
        $CashUser = $User ? $User->AdminId : ' ';
        $date_now = date('Y-m-d H:i:s',time());
            foreach($data as $field => $value) {
                $this->db->select('A.*');
                $this->db->from('tblFees as A');
                $this->db->where('A.FeeId',$value);
                $row = $this->db->get();
                $tblFees = $row->row();

                $data2 = array(
                    'StudNo' => $StudNo,
                    'AmountPaid' => $tblFees->Amount,
                    'Officer' => $CashUser ,
                    'FeeId' => $tblFees->FeeId,
                    'BookletNo' => $this->input->post('txtBooklet'),
                    'OrNo' => $this->input->post('txtOrNum'),
                    'SyId' => $SyId,
                    'SemId' => $SemId
                );
                $this->db->insert('tblpaymenttrans2', $data2);
                $this->db->close();
            }
        $this->db->where('StudNo',$StudNo);
        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $data2 = array(
                'PaidMiscDateTimeStart' => $date_now
        );
        $this->db->update('tblenrollmenttrans',$data2);
        $this->db->close();
    }
    
}
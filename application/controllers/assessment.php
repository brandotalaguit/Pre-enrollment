<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assessment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        
        $inactive = 5500;
        if(isset($_SESSION['start']) )
        {
            $session_life = time() - $_SESSION['start'];
            if($session_life > $inactive)
            {
                $this->M_admin->updateLoggedOut($_SESSION['username']);
                unset($_SESSION);
                session_destroy();
                redirect('site/admin');
            }
        }
        $_SESSION['start'] = time();

        if(!isset($_SESSION['username']) || empty($_SESSION['username']))
        {
            redirect('site/admin');
        }        
        $this->load->library('session');
        $this->load->model('M_enroll');
        $this->load->model('M_assessment');
        $this->load->library('form_validation');

        // $_SESSION['sy_sem'] = $this->M_enroll->get_current_sy_sem();
        // $_SESSION['student_info'] = $this->M_enroll->get_student_info($_SESSION['student_id']);
        // $_SESSION['student_curriculum'] = $this->M_enroll->get_student_curriculum($_SESSION['student_id']);

        $data['site_title'] = 'University of Makati Online Enrollment';
        $data['site_description'] = 'University of Makati Online Enrollment - An Online Enrollment Solutions for UMak students';
        $data['site_author'] = 'University of Makati ITC Department';
        $data['site_icon'] = 'favicon.ico';
        $data['user_type'] = 'Assessment Officer';
        $this->load->vars($data);
    }
    
    public function index()
    {
        redirect('site/admin');
    }

    public function MacesScholar()
    {
        if(!($_SESSION['user_info']['UserType'] == 'M' || $_SESSION['user_info']['UserType'] == 'S'))
            redirect('site/admin');
        // redirect('http://wwww.umak.edu.ph/olenroll/site/admin');

        $this->load->helper('date');
        $_SESSION['sy_sem'] = $this->M_enroll->get_current_sy_sem();
        $data['status'] = '';

        $this->form_validation->set_rules('student_id','Student No.','required|strtoupper|alpha_numeric|exact_length[8]|callback_checkStudNo');
        $this->form_validation->set_rules('scholarship_grant','Type of Scholarship Grant.','strtoupper|trim|numeric');

        if($this->form_validation->run() == TRUE) :
            if($this->input->post('student_id')) {
                $StudNo = strtoupper($this->input->post('student_id'));
                $data['scholar'] = $this->M_assessment->getScholarship($StudNo);

                if($this->input->post('btn_update'))
                {
                    $timestamp = now();
                    $timezone = 'UP8';
                    $date_t = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));
                    $account = $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Mname'] . ' ' . $_SESSION['user_info']['Lname'];

                    if( empty($data['scholar']) == FALSE ) {
                        $data = array('ScholarshipId' => $this->input->post('scholarship_grant'));
                        $this->db->where('StudNo',$this->input->post('student_id'));
                        $this->db->where('SyId',$_SESSION['sy_sem']['SyId']);
                        $this->db->where('SemId',$_SESSION['sy_sem']['SemId']);
                        $this->db->limit(1)->update('tblstudentscholar',$data);

                        $data['status'] = $this->db->affected_rows() > 0 ? 'Updated' : '';

                        $logs = array('StudNo' => $StudNo,
                            'SemId' => $_SESSION['sy_sem']['SemId'],
                            'SyId' => $_SESSION['sy_sem']['SyId'],
                            'User' => $account,
                            'Date' => $date_t,
                            'Actions' => 'Update Scholarship'
                         );
                        $this->db->insert('tblassessmentlogs',$logs);

                    } else {
                        if($this->input->post('scholarship_grant') > 0) {                            
                            $data = array(
                                'StudNo' => $this->input->post('student_id'), 
                                'ScholarshipId' => $this->input->post('scholarship_grant'), 
                                'SyId'=>$_SESSION['sy_sem']['SyId'],
                                'SemId'=>$_SESSION['sy_sem']['SemId']
                                );
                            $this->db->insert('tblstudentscholar', $data);

                            $data['status'] = $this->db->affected_rows() > 0 ? 'Updated' : '';

                            $logs = array('StudNo' => $StudNo,
                                'SemId' => $_SESSION['sy_sem']['SemId'],
                                'SyId' => $_SESSION['sy_sem']['SyId'],
                                'User' => $account,
                                'Date' => $date_t,
                                'Actions' => 'Add Scholarship'
                             );
                            $this->db->insert('tblassessmentlogs',$logs);
                            // $data['status'] = 'Updated';
                        }
                    }
                }

                if($this->input->post('btn_remove')) {
                        $this->db->where('StudNo',$StudNo);
                        $this->db->where('SyId',$_SESSION['sy_sem']['SyId']);
                        $this->db->where('SemId',$_SESSION['sy_sem']['SemId']);
                        $this->db->limit(1)->delete('tblstudentscholar');
                        $data['status'] = 'Deleted';
                }

                $data['student_info'] = $this->M_enroll->get_student_info($StudNo);
                $data['student_curriculum'] = $this->M_enroll->get_student_curriculum($StudNo);
                $data['scholar'] = $this->M_assessment->getScholarship($StudNo);
            }        
        endif;

        $data['scholarship'] = $this->M_assessment->getAllScholarship();
        $data['main_content'] = 'scholarship';
        $this->load->view('template_admin',$data);
    }

    function checkStudNo($StudNo)
    {
        $this->form_validation->set_message('checkStudNo','No match found for Student No. '.$StudNo);
        $query = $this->db->where('StudNo',$StudNo)->get('tblstudinfo')->row_array();

        return $query ? TRUE : FALSE;
    }
    
    public function changeOfResidency()
    {
        if(!($_SESSION['user_info']['UserType'] == 'A' || $_SESSION['user_info']['UserType'] == 'S'))
            redirect('site/admin');

        $this->load->helper('date');
        $_SESSION['sy_sem'] = $this->M_enroll->get_current_sy_sem();
        $StudNo = strtoupper($this->input->post('student_id'));
        $data['status'] = '';
        
        $timestamp = now();
        $timezone = 'UP8';
        $date_t = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));
        $account = $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Mname'] . ' ' . $_SESSION['user_info']['Lname'];

        $logs = array(
            'StudNo' => $StudNo,
            'SemId' => $_SESSION['sy_sem']['SemId'],
            'SyId' => $_SESSION['sy_sem']['SyId'],
            'User' => $account,
            'Date' => $date_t,
         );

        $where = array(
            'StudNo' => $StudNo,
            'SemId' => $_SESSION['sy_sem']['SemId'],
            'SyId' => $_SESSION['sy_sem']['SyId']
        );
        
        $this->form_validation->set_rules('student_id','Student No.','required|strtoupper|alpha_numeric|exact_length[8]|callback_checkStudNo');
        $this->form_validation->set_rules('residency','Type of Residency.','numeric');

        if($this->form_validation->run() == TRUE) :
            if($this->input->post('student_id')) {

                $data['PayMode'] = $this->M_assessment->get_paymentMode($StudNo);

                if($this->input->post('btn_update') && $this->input->post('hId') == $this->input->post('student_id')) {
                    
                    //update residency
                    $resident = array('IsMakatiResident' => $this->input->post('residency'));
                    $this->db->where('StudNo',$StudNo);
                    $this->db->limit(1)->update('tblstudinfo',$resident);

                    
                    $affected = $this->db->affected_rows();
                    // $data['status'] = $affected > 0 ? 'Updated' : '';
                    $data['status'] = 'Updated';

                    if ($this->input->post('residency') == 1) {
                        if($this->M_assessment->isAccountingVerified($StudNo) == FALSE) {
                            $this->db->insert('tblverifiedmakati',$logs);
                            $affected = $this->db->affected_rows();
                            $data['status'] = 'Updated';
                        }
                    }

                    if ($this->input->post('residency') == 0) {
                        $this->db->where($where)->delete('tblverifiedmakati');
                    }

                    $newlogs = array_merge($logs, array('Actions' => 'IsMakatiResidence = '.$this->input->post('residency')));

                    if ($affected > 0) {
                        $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs
                    }

                    $data['add'] = array_merge($logs, array('PayMode' => $this->input->post('paymode')));
                        
                    if ( $this->input->post('paymode') ) {

                        $query = $this->db->where($where)->get('tblpaymentmode');

                        if ( $query->num_rows() == 0 ) {

                            $this->db->insert('tblpaymentmode',$data['add']);

                            $newlogs = array_merge($logs, array('Actions' => $this->input->post('paymode')));
                            $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs

                            $data['status'] = $this->db->affected_rows() > 0 ? 'Updated' : $data['status'];

                        } else {

                            if( $query->row()->PayMode != $this->input->post('paymode') ) {

                                $this->db->limit(1)->where($where)->update('tblpaymentmode',$data['add']);
                                $affected = $this->db->affected_rows();

                                if($affected > 0) {
                                    $data['status'] = 'Updated';
                                    $newlogs = array_merge($logs, array('Actions' => $this->input->post('paymode')));
                                    $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs
                                }

                            }
                        }
                    }

                    if ( $this->input->post('scholarship_grant') ) {
                        
                        $scholar = $this->M_assessment->getScholarship($StudNo);
                        
                        if ( empty($scholar) == TRUE) {
                            
                            $scholar = array_merge($where, array('ScholarshipId' => $this->input->post('scholarship_grant')));
                            $this->db->insert('tblstudentscholar',$scholar);
                            $affected = $this->db->affected_rows();

                                if($affected > 0) {
                                    $data['status'] = 'Updated';
                                    $newlogs = array_merge($logs, array('Actions' => 'ScholarshipId = ' . $this->input->post('scholarship_grant')));
                                    $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs
                                }

                        } else {
                            
                            $scholar = array_merge($where, array('ScholarshipId' => $this->input->post('scholarship_grant')));
                            $this->db->where($where)->update('tblstudentscholar',$scholar);
                            $affected = $this->db->affected_rows();

                                if($affected > 0) {
                                    $data['status'] = 'Updated';
                                    $newlogs = array_merge($logs, array('Actions' => 'Update ScholarshipId = ' . $this->input->post('scholarship_grant')));
                                    $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs
                                }
                        }
                    }
                }

                if($this->input->post('btn_remove') && $this->input->post('hId') == $this->input->post('student_id')) {
                        // echo "been here!";
                        $this->db->limit(1)->where($where)->delete('tblstudentscholar');
                        // echo $this->db->last_query();
                        $affected = $this->db->affected_rows();

                            if($affected > 0) {

                                $data['status'] = 'Updated';
                                $newlogs = array_merge($logs, array('Actions' => 'Remove ScholarshipId = ' . $this->input->post('scholarship_grant')));
                                $this->db->insert('tblassessmentlogs',$newlogs);   // insert to logs

                            }

                }
                $data['oldResidency'] = $this->M_assessment->getResidency($StudNo);
                $data['scholarship'] = $this->M_assessment->getAllScholarship();
                $data['PayMode'] = $this->M_assessment->get_paymentMode($StudNo);
                $data['student_info'] = $this->M_enroll->get_student_info($StudNo);
                $data['student_scholarship'] = $this->M_assessment->getScholarship($StudNo);
                $data['student_curriculum'] = $this->M_enroll->get_student_curriculum($StudNo);
            }
        endif;

        $data['main_content'] = 'changeResidency';
        $this->load->view('template_admin',$data);
    }

    public function logout()
    {
        $this->load->model('M_admin');
        $this->M_admin->update_logged_out($_SESSION['username']);
        unset($_SESSION);
        session_destroy();
        redirect('site/admin');
    }
}
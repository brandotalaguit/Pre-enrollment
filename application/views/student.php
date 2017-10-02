<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		session_start();
		$data['site_title'] = 'University of Makati Online Enrollment Beta Version';
        $data['site_description'] = 'University of Makati Online Enrollment Beta Version - An Online Enrollment Solutions for UMak Students';
        $data['site_author'] = 'University of Makati ITC Department';
        $data['site_icon'] = 'favicon.ico';		
        $this->load->library('session');
        $this->load->model('M_enroll');
        $this->load->model('M_assessment');
        $this->load->library('form_validation');	
        $inactive = 5500;
        if(isset($_SESSION['start']) )
        {
            $session_life = time() - $_SESSION['start'];
            if($session_life > $inactive)
            {
                $this->M_enroll->update_logged_out($_SESSION['student_id']);
                unset($_SESSION);
                session_destroy();
                redirect('/');
            }
        }
        $_SESSION['start'] = time();

        if(!isset($_SESSION['student_id']) || empty($_SESSION['student_id']))
        {
            redirect('/');
        }	
        
        $this->load->vars($data);
	}


	public function index()
	{	
		

		$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
				        
        if(empty($_SESSION['enrollment_trans']))
        {
            $this->M_enroll->add_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);            
            $_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
        }

        if($_SESSION['student_info']['PreEnrolled'])
		{
			$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],1,0,0);	
			redirect('student/encoded_subjects_assessment');    		
		}			
		
		if($_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/encoded_subjects_assessment');    		


							
		$data['max_units'] = $this->M_enroll->get_max_units($_SESSION['student_curriculum']['CurriculumId'],$_SESSION['student_info']['LengthOfStayBySem']);
		$_SESSION['curriculum_template'] = $this->M_enroll->get_curriculum_template($_SESSION['student_curriculum']['CurriculumId'],$_SESSION['student_id'],$_SESSION['student_info']['LengthOfStayBySem'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);		
		$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
		$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
				        
         $this->M_enroll->set_user_logs('View Curriculum and Class Schedule');	
        $data['main_content'] = 'curriculum';
		$this->load->view('template_student',$data);
	}


	public function get_schedule()
	{		
		if($this->uri->segment(3) && $this->uri->segment(4) && $this->uri->segment(5))
		{
			$data['equivalent_course'] = $this->db->select('EquivalentCourse')->where('CourseId',$this->uri->segment(3))->where('EquivalentCourse !=',$this->uri->segment(3))->get('tblcourse')->row_array();
			
						
			
			if(!empty($data['equivalent_course']['EquivalentCourse']))
			{
				$equiv_course = explode(',',$data['equivalent_course']['EquivalentCourse']);					
			}
			


				$this->db->select('A.*,B.*,(SELECT COUNT(*) FROM tblstudentschedule as C WHERE C.Cfn = A.cfn  ) AS ClassSize')->where('subject_id',$this->uri->segment(3))->where('college_id',$this->uri->segment(4))->where('program_id',$this->uri->segment(5))->where('major_id',$this->uri->segment(6))->where('A.sy_id',$_SESSION['sy_sem']['SyId'])->where('A.sem_id',$_SESSION['sy_sem']['SemId'])->join('tblcourse as B','A.subject_id = B.CourseId','left');				

				$data['priority_subjects'] = $this->db->get('tblsched as A')->result_array();

				$cfn = array();
				foreach($data['priority_subjects'] as $row)
				{
					$cfn[] = $row['cfn'];
				}
				
			 	$this->db->select('A.*,B.*,(SELECT COUNT(*) FROM tblstudentschedule as C WHERE C.Cfn = A.cfn  ) AS ClassSize')->where('subject_id',$this->uri->segment(3))->where('A.sy_id',$_SESSION['sy_sem']['SyId'])->where('A.sem_id',$_SESSION['sy_sem']['SemId'])->join('tblcourse as B','A.subject_id = B.CourseId','left');
			 	if(!empty($cfn))
			 	$this->db->where_not_in('cfn',$cfn);
				
				if(!empty($equiv_course))
				{
					foreach ($equiv_course as  $row) 
					{
						$this->db->or_where('subject_id',$row);	
					}
				}
				$data['subjects'] = $this->db->get('tblsched as A')->result_array();									
				//echo $this->db->last_query();

		}
		$this->load->view('template_schedule',$data);

	}


	public function delete_schedule()
	{		
		if($this->uri->segment(3))
        {           
           $this->db->where('Cfn',$this->uri->segment(3));           
           $this->db->where('StudNo',$_SESSION['student_info']['StudNo']);
           $this->db->where('SyId',$_SESSION['sy_sem']['SyId']);
           $this->db->where('SemId',$_SESSION['sy_sem']['SemId']);
           $this->db->delete('tblstudentschedule');
           if($this->db->affected_rows() > 0)
           {
               $this->M_enroll->set_user_logs('Delete Subject - CFN ' . $this->uri->segment(3));	
              $this->session->set_flashdata('success','You have successfully deleted the selected subject.');
              
              redirect('student');
              
           }
           else
           {
              $this->session->set_flashdata('error','Unable to delete the selected subject.');
              redirect('student');
           }

        }
        else
        {
            $this->session->set_flashdata('error','Unable to delete the selected subject.');
              redirect('student');
        }
	}


	public function save_schedule()
	{
		if($this->input->post('subject'))
		{
			$query = $this->db->where('B.Cfn',$this->input->post('subject'))
			->get('tblsched as B');           	           	           	
           	foreach($query->result_array() as $row)
           	{
           		$sql2 = "SELECT A.*,D.*,E.* FROM tblsched as A  LEFT JOIN tblcourse as D ON D.CourseId = A.subject_id LEFT JOIN tblstudentschedule as E ON E.Cfn = A.cfn WHERE E.StudNo = '". $_SESSION['student_info']['StudNo'] ."' AND 
           		(((time_start_mon >= '". $row['time_start_mon'] ."' 
            	AND time_start_mon < '". $row['time_end_mon'] . "'  OR '". $row['time_start_mon'] . "' >= time_start_mon AND '". $row['time_start_mon'] ."' < time_end_mon)) || ((time_start_tue >= '". $row['time_start_tue'] ."' 
            	AND time_start_tue < '". $row['time_end_tue'] . "'  OR '". $row['time_start_tue'] . "' >= time_start_tue AND '". $row['time_start_tue'] ."' < time_end_tue)) || ((time_start_wed >= '". $row['time_start_wed'] ."' 
            	AND time_start_wed < '". $row['time_end_wed'] . "'  OR '". $row['time_start_wed'] . "' >= time_start_wed AND '". $row['time_start_wed'] ."' < time_end_wed)) || ((time_start_thu >= '". $row['time_start_thu'] ."' 
            	AND time_start_thu < '". $row['time_end_thu'] . "'  OR '". $row['time_start_thu'] . "' >= time_start_thu AND '". $row['time_start_thu'] ."' < time_end_thu)) || ((time_start_fri >= '". $row['time_start_fri'] ."' 
            	AND time_start_fri < '". $row['time_end_fri'] . "'  OR '". $row['time_start_fri'] . "' >= time_start_fri AND '". $row['time_start_fri'] ."' < time_end_fri)) || ((time_start_sat >= '". $row['time_start_sat'] ."' 
            	AND time_start_sat < '". $row['time_end_sat'] . "'  OR '". $row['time_start_sat'] . "' >= time_start_sat AND '". $row['time_start_sat'] ."' < time_end_sat)) || ((time_start_sun >= '". $row['time_start_sun'] ."' 
            	AND time_start_sun < '". $row['time_end_sun'] . "'  OR '". $row['time_start_sun'] . "' >= time_start_sun AND '". $row['time_start_sun'] ."' < time_end_sun)))"; 	
				
				$query1 = $this->db->query($sql2);				
           	}
           	
           	
			if($query1->num_rows() < 1)
			{
				$affected_rows = $this->M_enroll->enroll_student($_SESSION['student_info']['StudNo'],$this->input->post('subject'));
				if($affected_rows > 0)
				{
				  $this->M_enroll->set_user_logs('Add Subject - CFN ' . $this->input->post('subject'));	
				  $this->session->set_flashdata('success','You have successfully added the selected subject.');
				  
	              redirect('student/');
				}
				else
				{
					$this->session->set_flashdata('error','Unable to add the selected subject.');
	              	redirect('student/');
				}
			}
			else
			{
				$this->session->set_flashdata('error','There is a time conflict on your selected subject.');
	              	redirect('student/');	
			}
			
			
		}
		else
		{
			$this->session->set_flashdata('error','Unable to add the selected subject.');
			redirect('student/');
		}

	}

	public function save_block_schedule()
	{
		if($this->input->post('subject'))
		{
			$this->db->where('StudNo', $_SESSION['student_info']['StudNo']);
			$this->db->where('SyId',$_SESSION['sy_sem']['SyId']);
           	$this->db->where('SemId',$_SESSION['sy_sem']['SemId']);
           	$this->db->delete('tblstudentschedule');
			

			$cfns = explode(',',$this->input->post('subject'));
			$affected_rows = 0;
			foreach($cfns as $cfn)
			{
				if(!empty($cfn))
				{
					$affected_rows += $this->M_enroll->enroll_student($_SESSION['student_info']['StudNo'],$cfn);
				    $this->M_enroll->set_user_logs('Add Subject - CFN ' . $cfn);
				}				
			}
						
			if($affected_rows > 0)
			{
				$this->session->set_flashdata('success','You have successfully added the selected block schedule.');
              redirect('student/');
			}
			else
			{
				$this->session->set_flashdata('error','Unable to add the selected block schedule.');
              	redirect('student/');
			}		
		}
		else
		{
			$this->session->set_flashdata('error','Unable to add the selected block schedule.');
			redirect('student/');
		}

	}

	public function show_block_schedule()
	{
		$data['block_section_schedule'] = $this->M_enroll->get_block_section_schedule($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_curriculum']['CurriculumId'],$_SESSION['student_info']['LengthOfStayBySem'],$_SESSION['student_id'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['MajorId']);
		$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
		 $this->M_enroll->set_user_logs('View Block Schedule');				
		$this->load->view('template_block_schedule',$data);
	}

	public function confirm_schedule()	
	{		
		$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],1,0,0);	
		$this->M_enroll->set_user_logs('Confirm Selected Class Schedule');
		redirect('student/residency_scholarship');
	}

    public function residency_scholarship()
    {            
    	$this->M_enroll->set_user_logs('View Chage of Residency and Scholarship Process');	
        $data['main_content'] = 'residencyProcess';
        $this->load->view('template_student',$data);
    }
               
    public function encoded_subjects_assessment()
    {    	
    	if(!$_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/');

    	$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],0,1);		
/*    	$data['AssDetails1'] = $this->M_assessment->getStudentOrg($_SESSION['student_id'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);
        $data['AssDetails2'] = $this->M_assessment->getAssPerSubject($_SESSION['student_info']['StudNo']);
        $data['AssDetails3'] = $this->M_assessment->getScholarship($_SESSION['student_info']['StudNo'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
        $data['AssDetails4'] = $this->M_assessment->getTuitionFee($_SESSION['student_info']['StudNo']);
        $data['AssDetailsNstp'] = $this->M_assessment->getNSTPFEE($_SESSION['student_info']['StudNo']);
        $data['AssDetailsLabFee'] = $this->M_assessment->getLabFee($_SESSION['student_info']['StudNo']);
        $this->M_assessment->AssessStudent($_SESSION['student_info']['StudNo'],$_SESSION['sy_sem']['SemId'],$_SESSION['sy_sem']['SyId'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);*/
        $data['AssDetails1'] = $this->M_assessment->getStudentOrg($_SESSION['student_id'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);
        $data['AssDetails2'] = $this->M_assessment->getAssPerSubject($_SESSION['student_info']['StudNo']);
        $data['AssDetails3'] = $this->M_assessment->getScholarship($_SESSION['student_info']['StudNo']);
        $data['AssDetails4'] = $this->M_assessment->getTuitionFee($_SESSION['student_info']['StudNo']);
        $data['AssDetailsNstp'] = $this->M_assessment->getNSTPFEE($_SESSION['student_info']['StudNo']);
        $data['AssDetailsLabFee'] = $this->M_assessment->getLabFee($_SESSION['student_info']['StudNo']);
        $this->M_assessment->AssessStudent($_SESSION['student_info']['StudNo'],$_SESSION['sy_sem']['SemId'],$_SESSION['sy_sem']['SyId'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);        

    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
    	$data['main_content'] = 'encoded_subjects_assessment';        
        $this->M_enroll->set_user_logs('View Encoded Subjects and Assessment');
        $this->load->view('template_student',$data);
    }

    public function print_encoded_subjects_assessment()
    {
    	if(!$_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/');
    	
    	$data['AssDetails1'] = $this->M_assessment->getStudentOrg($_SESSION['student_id'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);
        $data['AssDetails2'] = $this->M_assessment->getAssPerSubject($_SESSION['student_info']['StudNo']);
        $data['AssDetails3'] = $this->M_assessment->getScholarship($_SESSION['student_info']['StudNo'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
        $data['AssDetails4'] = $this->M_assessment->getTuitionFee($_SESSION['student_info']['StudNo']);
        $data['AssDetailsNstp'] = $this->M_assessment->getNSTPFEE($_SESSION['student_info']['StudNo']);
        $data['AssDetailsLabFee'] = $this->M_assessment->getLabFee($_SESSION['student_info']['StudNo']);
        $this->M_assessment->AssessStudent($_SESSION['student_info']['StudNo'],$_SESSION['sy_sem']['SemId'],$_SESSION['sy_sem']['SyId'],$_SESSION['student_curriculum']['CollegeId'],$_SESSION['student_curriculum']['ProgramId'],$_SESSION['student_curriculum']['MajorId']);
    		
    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();    	
        $this->M_enroll->set_user_logs('Print Encoded Sujects and Assessment');
        $this->load->view('template_print',$data);
    }

	public function logout()
    {
    	$this->M_enroll->set_user_logs('Log Out');
        $this->M_enroll->update_logged_out($_SESSION['student_id']);
        unset($_SESSION);
        session_destroy();
        redirect('/');
    }







}

/* End of file site.php */
/* Location: ./application/controllers/site.php */

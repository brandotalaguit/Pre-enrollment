<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	protected $block_sched = TRUE;
	protected $system_maintenance = FALSE;

	function __construct()
	{
		parent::__construct();		
		session_start();
		$data['site_title'] = 'University of Makati Online Enrollment Beta Version';
        $data['site_description'] = 'University of Makati Online Enrollment Beta Version - An Online Enrollment Solutions for UMak Students';
        $data['site_author'] = 'University of Makati ITC Department';
        $data['site_icon'] = base_url('assets/img/favicon.ico');

        $this->load->library('session');
        $this->load->model('M_enroll');
        $this->load->model('M_assessment');
        $this->load->model('M_addsched');
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
                redirect(base_url());
            }
        }

        $_SESSION['start'] = time();


        if ($this->system_maintenance == TRUE) 
        {
        	$this->M_enroll->update_logged_out($_SESSION['student_id']);
        	unset($_SESSION);
        	session_destroy();
        	redirect(base_url());
        }

        if(!isset($_SESSION['student_id']) || empty($_SESSION['student_id']))
        {
            redirect(base_url());
        }	

        if (date('Y-m-d') == '2016-11-01') 
        {
        	$this->block_sched = TRUE;
        }
        
    	$data['block_sched'] = $this->block_sched;
    	$this->feval = ENVIRONMENT == 'production' ? 'umakunil_feval.' : 'umaktest_feval.';
        
        $this->load->vars($data);
	}


	public function index()
	{	
		$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);


        /*if(empty($_SESSION['enrollment_trans']))
        {
            $this->M_enroll->add_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
            $_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);

            $this->M_enroll->add_student_losby($_SESSION['student_id'], $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
            $this->M_enroll->promote_student($_SESSION['student_id'], $_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId']);
            $this->M_enroll->set_student_logs($_SESSION['student_id'], 'LengthOfStayBySem Promoted');
        }*/

        /****** # added code for deactivation of selected subject   *****/

		// if($_SESSION['enrollment_trans']['IsDeactivated'] == '1')
		// {
		// 	$this->M_enroll->reset_enrollment_trans($_SESSION['enrollment_trans']['Id']);
		// 	$_SESSION['enrollment_trans'] = array();
		// 	$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
		// 	$_SESSION['error'] = '<span class="label label-info">NOTE</span> You have neglected your payment schedule; the system has now REMOVED the subjects you enrolled for this semester. 
		// 				Please RE-ENROLL online to get another schedule. Thank you';
		// }

        /****** /.end./  ******/


        if($_SESSION['student_info']['PreEnrolled'] == '1')
		{
			$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],1,0,0);
	        // Process payment schedule
        	if ((date('Y-m-d') > $_SESSION['enrollment_trans']['PaymentDate']) && $_SESSION['enrollment_trans']['IsPaid'] == 0)
        	{
        		$payment_date = $this->M_enroll->set_payment_schedule($_SESSION['enrollment_trans']['Id']);
        		$_SESSION['enrollment_trans']['PaymentDate'] = $payment_date;
        	}
			redirect('student/encoded_subjects_assessment');    		
		}			
		
		if($_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/encoded_subjects_assessment');    		
    	
		if($_SESSION['enrollment_trans']['IsControlled'] == 1)
		{
			$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],1,0,0);	
			redirect('student/confirm_schedule');
		}
		
		
		$data['max_units'] = $this->M_enroll->get_max_units($_SESSION['student_curriculum']['CurriculumId'],$_SESSION['student_info']['LengthOfStayBySem']);
		if($_SESSION['student_info']['LengthOfStayBySem'] == 11 && $_SESSION['student_curriculum']['CollegeId'] == 11)	# COE
		{
			$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
    		if (!empty($allowed_overload_units))
    		{
	        	if ($allowed_overload_units['NotToExceed'] > 0)
        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
	        	else
        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
    		}	    	
		}
		elseif ($_SESSION['student_info']['LengthOfStayBySem'] == 8) 
		{
			$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
    		if (!empty($allowed_overload_units))
    		{
	        	if ($allowed_overload_units['NotToExceed'] > 0)
        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
	        	else
        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
    		}
		}
		elseif ($_SESSION['student_info']['LengthOfStayBySem'] == 11) 
		{
			$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
    		if (!empty($allowed_overload_units))
    		{
	        	if ($allowed_overload_units['NotToExceed'] > 0)
        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
	        	else
        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
    		}
		}
		elseif ($_SESSION['student_info']['LengthOfStayBySem'] == 6) 
		{
			$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
    		if (!empty($allowed_overload_units))
    		{
	        	if ($allowed_overload_units['NotToExceed'] > 0)
        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
	        	else
        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
    		}
		}
		elseif ($_SESSION['student_info']['LengthOfStayBySem'] == 10 && $_SESSION['student_curriculum']['CollegeId'] == 11) #COE
		{
			$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
			if(count($allowed_overload_units))
			{
			if ($allowed_overload_units['NotToExceed'] > 0)
        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
	        	else
        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
        		}
		}
		else
		{
						$allowed_overload_units = $this->M_enroll->get_allowed_overload_units($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_info']['LengthOfStayBySem']);
						

						if(count($allowed_overload_units))
						{
							if ($allowed_overload_units['NotToExceed'] > 0)
			        		$data['max_units'] = $allowed_overload_units['NotToExceed'];
				        	else
			        		$data['max_units'] += $allowed_overload_units['AdditionalUnits'];
		        		}
		}
		
		
		$_SESSION['curriculum_template'] = $this->M_enroll->get_curriculum_template($_SESSION['student_curriculum']['CurriculumId'],$_SESSION['student_id'],$_SESSION['student_info']['LengthOfStayBySem'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);		
		$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId']);
		$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
				        
        $this->M_enroll->set_user_logs('View Curriculum and Class Schedule');	
        $data['main_content'] = 'curriculum';
		$this->load->view('template_student',$data);
		// var_dump($_SESSION['student_curriculum']);
	}

	public function edit_student_info()
	{
		$this->load->model('m_studentinfo');
		$rules = $this->m_studentinfo->rules;

    	$this->form_validation->set_rules($rules);

    	if ($this->form_validation->run() == TRUE)
		{
			$id = $this->input->post('StudNo');
			$data = $this->m_studentinfo->array_from_post(
											array(
											'Lname',
											'Fname',
											'Mname',
											'AddressCity',
											'AddressStreet',
											'AddressBarangay',
											'Gender',
											'BirthDay',
											'Guardian'
											)
										);

			$this->m_studentinfo->save($data,$id);
			$this->M_enroll->set_user_logs('Edit Information '.print_r($data));	
			redirect('student');
		}
		// else
		// {
		// 	dump(validation_errors());
		// }
	}



	public function _is_valid_amount($str)
	{
		// Do NOT validate if amount is not in CONSTANTS list
		$array_constant = array(FIVE_HUNDRED, SEVEN_HUNDRED, ONE_THOUSAND, TWO_THOUSAND, THREE_THOUSAND, ONE_THOUSAND_FIVE, TWO_THOUSAND_FIVE);
		$amount = $this->input->post('partialpayment');

		if (in_array($amount, $array_constant)) 
		{
			return TRUE;
		}

		$this->form_validation->set_message('_is_valid_amount', "%s is INVALID, Please select a value from the choices provided.");
		return FALSE;
	}

	public function _is_valid_payment_method($str)
	{
		// Do NOT validate if methodpayment is not in CONSTANTS list
		$array_constant = array(LANDBANK_MSC, LANDBANK_TKN);
		$method = $this->input->post('methodpayment');

		if (in_array($method, $array_constant)) 
		{
			return TRUE;
		}

		$this->form_validation->set_message('_is_valid_payment_method', "%s is INVALID, Please select a value from the choices provided.");
		return FALSE;
	}

	public function _is_valid_payment_scheme($str)
	{
		// Do NOT validate if payment_scheme is not in CONSTANTS list
		$array_constant = array(1, 2, 3);
		$method = $this->input->post('payment_scheme');

		if (in_array($method, $array_constant)) 
		{
			return TRUE;
		}

		$this->form_validation->set_message('_is_valid_payment_scheme', "%s is INVALID, Please select a value from the choices provided.");
		return FALSE;
	}

	public function coahs_payment_method()
	{
		$rules = array(
			'payment_scheme' => array('field' => 'payment_scheme', 'label' => 'Payment Scheme', 'rules' => 'required|intval|is_natural_no_zero|callback__is_valid_payment_scheme|xss_clean'),
			// 'stud_tuition_id' => array('field' => 'stud_tuition_id', 'label' => 'stud_tuition_id', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'),
		);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) 
		{

	        // Process COAHS assessment
	        $assessment = $this->M_assessment->coahs_student_assess(
	        	$_SESSION['student_info']['StudNo'],
	        	$_SESSION['sy_sem']['SyId'],
	        	$_SESSION['sy_sem']['SemId']
        	);
        	if (count($assessment))
        	{
        		$_SESSION['enrollment_trans']['IsAssessed'] = 1;
				$_SESSION['success'] = "Success: Payment scheme has been successfully saved.";
	        	$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'], 0, 1);
        	}
        	else
        	{
				$_SESSION['error'] = "Error: Tuition Id does not exist.";
        		unset($_SESSION['success']);
        	}
			redirect('student/encoded_subjects_assessment');
		}
		else
		{
			# Error message
			$_SESSION['error'] = validation_errors('<li>', '</li>');
			redirect('student/encoded_subjects_assessment');
		}

	}

	public function landbank_payment_method()
	{
		$rules = array(
				'methodpayment' => array('field' => 'methodpayment', 'label' => 'Payment Method', 'rules' => 'required|intval|is_natural_no_zero|callback__is_valid_payment_method|xss_clean'),
				'partialpayment' => array('field' => 'partialpayment', 'label' => 'Token Fee Payment Amount', 'rules' => 'intval|is_natural_no_zero|callback__is_valid_amount|xss_clean')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) 
		{
			$this->load->model('M_assessment');

			# TODO: Initialize variables 
			$student_id = $_SESSION['student_info']['StudNo'];
	    	$misc_amount = 0.00;

			# Fetch misc data
	    	$this->db->where_not_in('C.FeeId', array(20, 21)); // mkt/non_mkt
	    	$student_misc = $this->M_assessment->getStudentAssessment($_SESSION['student_info']['StudNo']);

	    	
			foreach ($student_misc as $misc) 
			{
				$misc_amount += $misc['Amount'];
			}

			// Save and generate reference_no
			$debit_amount_token = $this->input->post('partialpayment');
			$debit_amount_misc = $misc_amount;
			$reference_no = $this->M_assessment->landbank_referrence($_SESSION['student_info']['StudNo'], 
				$_SESSION['sy_sem']['SyId'], 
				$_SESSION['sy_sem']['SemId']
			);

			// Set user logs
			$this->M_enroll->set_user_logs('Saved Token Fee and Misc Fee Payment Method');

			# Passed data to Landbank atm 
			if ($this->input->post('methodpayment') == LANDBANK_ATM)
			{
				# Redirect to landbank e-PAYMENT
				// redirect('redirect.to.landbank.e-payment');

				# Confirmation Receipt
				redirect('student/confirmation_receipt');
			}
			elseif ($this->input->post('methodpayment') == LANDBANK_OTC) 
			{
				redirect('student/print_encoded_subjects_assessment');
			}
			else
			{
				$_SESSION['error'] = '<li>Invalid credentials for Landbank payment, please try gain later.</li>';
				redirect('student/encoded_subjects_assessment');
			}
		}
		else
		{
			# Error message
			$_SESSION['error'] = validation_errors('<li>', '</li>');
			redirect('student/encoded_subjects_assessment');
		}

	}

	public function confirmation_receipt()
	{
		if ($_SESSION['student_curriculum']['CollegeId'] != "6") # COAHS
		{
			$this->load->model('M_assessment');
			// Fetch student scholarship
	        $data['AssDetails3'] = $this->M_assessment->getScholarship($_SESSION['student_info']['StudNo']);			

			// Fetch assessment
			$this->db->where_not_in('C.FeeId', array(20,21));
			$data['student_assessment'] = $this->M_assessment->getStudentAssessment($_SESSION['student_info']['StudNo']);
			
			$this->db->where_in('C.FeeId', array(20,21));
			$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($_SESSION['student_info']['StudNo'], TRUE);

	    }
	    else
	    {
	    	$_SESSION['error'] = "Unauthorized access, COAHS Student";
	    	redirect('student/encoded_subjects_assessment');
		}

		$this->M_enroll->set_user_logs('View Confirmation Receipt');
		$this->load->view('template_confirmation_receipt', $data);
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

				/*
				* Filter First Year Schedule
				* ONLY Student with "K" on their student id
				* are ALLOWED to access First Year Subjects.
				*/
				if (in_array($_SESSION['student_info']['LengthOfStayBySem'], array(1, 2))) // (substr($_SESSION['student_id'],0,1) == "K") 
				{
					// do Nothing
				}
				else
				{
					if($_SESSION['sy_sem']['SemId'] != 3)
					{
						if ($_SESSION['student_info']['AllowAccessTo1stYrSched'] != 1) 
						{
							if ($_SESSION['student_curriculum']['CollegeId'] != "11") 
							$this->db->where('LEFT(year_section,2) != "I-"', NULL, FALSE);
						}
					}
				}

				$sql = 'A.*, B.*, 
				        (SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as studsched WHERE studsched.Cfn = A.cfn AND IsActive = 1 AND Status = "") +
		                 (SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as studcl LEFT JOIN tblstudcmat as studc ON studcl.cmat_id = studc.cmat_id
		                    WHERE cfn_to = A.cfn AND studc.is_actived = 1 AND disapproved_note = "") 
		                 - 
		                 (
		                     ( SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as studcl2 
		                       LEFT JOIN tblstudcmat as studc2 ON studcl2.cmat_id = studc2.cmat_id
		                       WHERE cfn_from = A.cfn AND studc2.is_actived = 1 AND studcl2.is_actived = 1 AND disapproved_note = "" AND (studc2.printed_at = "0000-00-00 00:00:00" AND is_regis_print = 0)
		                     )
		                    +
		                     ( SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as H 
		                       INNER JOIN tblstudcmatloads as I ON H.StudNo=I.StudNo AND H.cfn=I.cfn_to 
		                       LEFT JOIN tblstudcmat as J ON I.cmat_id = J.cmat_id
		                       WHERE J.is_actived = 1 AND disapproved_note = "" AND H.cfn = A.cfn AND IsActive = 1 AND H.Status = ""
		                     )
		                    +
		                    ( SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as H 
		                      INNER JOIN tblstudcmatloads as I ON H.StudNo=I.StudNo AND H.cfn=I.cfn_to 
		                      LEFT JOIN tblstudcmat as J ON I.cmat_id = J.cmat_id
		                      WHERE J.is_actived = 1 AND disapproved_note = "" AND H.cfn = A.cfn AND IsActive = 0 AND H.Status = ""
		                    )
		                 ) 
				        AS ClassSize
				';
				      $this->db->select($sql, FALSE)
				          ->join('tblcourse as B','A.subject_id = B.CourseId','left')
				          ->where('subject_id',$this->uri->segment(3))
				          ->where('CollegeId',$this->uri->segment(4))
				          ->where('ProgramId',$this->uri->segment(5))
				          ->where('MajorId',$this->uri->segment(6))
				          ->where('A.SyId',$_SESSION['sy_sem']['SyId'])
				          ->where('A.SemId',$_SESSION['sy_sem']['SemId']);

				$data['priority_subjects'] = $this->db->get('tblsched as A')->result_array();



				$cfn = array();
				foreach($data['priority_subjects'] as $row)
				{
					$cfn[] = $row['cfn'];
				}


				
				/*
				* Filter First Year Schedule
				* ONLY Student with "K" on their student id
				* are ALLOWED to access First Year Subjects.
				*/
				if (in_array($_SESSION['student_info']['LengthOfStayBySem'], array(1, 2))) // (substr($_SESSION['student_id'],0,1) == "K") 
				{
					// do Nothing
					// $this->db->where('CollegeId', $_SESSION['student_curriculum']['CollegeId']);
					
				}
				else
				{
					if($_SESSION['sy_sem']['SemId'] != 3)
					{
						if ($_SESSION['student_info']['AllowAccessTo1stYrSched'] != 1) 
						{
							$this->db->where('LEFT(year_section,2) != "I-"', NULL, FALSE);
						}
					}

				}

			 	$sql = 'A.*, B.*, 
			 	(
			 	 (SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as studsched WHERE studsched.Cfn = A.cfn AND IsActive = 1 AND Status = "") +
			 	 (SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as studcl LEFT JOIN tblstudcmat as studc ON studcl.cmat_id = studc.cmat_id
			 	    WHERE cfn_to = A.cfn AND studc.is_actived = 1 AND disapproved_note = "") 
			 	 - 
			 	 (
			 	     ( SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as studcl2 
			 	       LEFT JOIN tblstudcmat as studc2 ON studcl2.cmat_id = studc2.cmat_id
			 	       WHERE cfn_from = A.cfn AND studc2.is_actived = 1 AND studcl2.is_actived = 1 AND disapproved_note = "" AND (studc2.printed_at = "0000-00-00 00:00:00" AND is_regis_print = 0)
			 	     )
			 	    +
			 	     ( SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as H 
			 	       INNER JOIN tblstudcmatloads as I ON H.StudNo=I.StudNo AND H.cfn=I.cfn_to 
			 	       LEFT JOIN tblstudcmat as J ON I.cmat_id = J.cmat_id
			 	       WHERE J.is_actived = 1 AND disapproved_note = "" AND H.cfn = A.cfn AND IsActive = 1 AND H.Status = ""
			 	     )
			 	    +
			 	    ( SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as H 
			 	      INNER JOIN tblstudcmatloads as I ON H.StudNo=I.StudNo AND H.cfn=I.cfn_to 
			 	      LEFT JOIN tblstudcmat as J ON I.cmat_id = J.cmat_id
			 	      WHERE J.is_actived = 1 AND disapproved_note = "" AND H.cfn = A.cfn AND IsActive = 0 AND H.Status = ""
			 	    )
			 	 )
			 	) 
			 	AS ClassSize';
			 	$this->db->select($sql, FALSE)
				 	->where('A.SyId',$_SESSION['sy_sem']['SyId'])
				 	->where('A.SemId',$_SESSION['sy_sem']['SemId'])
				 	->join('tblcourse as B','A.subject_id = B.CourseId','left');
				
			 	

			 	if(!empty($cfn))
			 	$this->db->where_not_in('cfn',$cfn);
				

				if(!empty($equiv_course))
				{
					$equivalentcourse[] = $this->uri->segment(3);
					foreach ($equiv_course as  $row) 
					{
						// $this->db->or_where('subject_id',$row);	
						$equivalentcourse[] = $row;
					}
					
				 	$this->db->where_in('subject_id', $equivalentcourse);
				}
				else
				{
				 	$this->db->where('subject_id',$this->uri->segment(3));
				}
				
				if($_SESSION['student_curriculum']['CollegeId'] == "6")
				{
					// $this->db->where('college_id', 6);
					if ( ! in_array($this->uri->segment(3), array(19, 14, 1857, 1858, 1859))) 	# NSTP 1, NSTP 2
					{
						$this->db->where('CollegeId', 6);
					}
				}
				
				if ( ! in_array($_SESSION['student_curriculum']['CollegeId'], array('6', '13')))
				{
					// disable viewing coahs & cmli subjects
					// $this->db->where('CollegeId !=', 6);
					$this->db->where_not_in('CollegeId', array('6', '13'));	
				}
				
				// $this->db->where('A.Cfn !=', 'A213A703');
				// $this->db->where_not_in('A.Cfn', array('A213A703','A213A733','A213A741','A213B035'));
				$data['subjects'] = $this->db->get('tblsched as A')->result_array();
				// echo $this->db->last_query();
				// echo '<p style="font-size:2px; color:white; display: none;">' .  $this->db->last_query() . '</p>';
				if ( empty($data['subjects']) && empty($data['priority_subjects'])) 
				{
					if ($_SESSION['student_curriculum']['CollegeId'] != "6")
					{
						echo '<p class="lead">The section available for this course is currently restricted to either a specific program(COAHS)
						or year level(1<sup>st</sup> year). Please ask permission from the Registrar\'s Office to add this course,
						however additional fees may apply.</p>';
					}
					else
					{
					// Regular Course/Subject are restricted to COAHS Student due to tuition fee computation
						echo '<p class="lead">The section available for this course is currently restricted to either a specific year level(1<sup>st</sup> Year).
						Please ask permission from the Registrar\'s Office to add this course,
						however additional fees may apply.</p>';
						// echo '<p style="font-size:2px; color:white">' .  $this->db->last_query() . '</p>';
					}
				}
			 	

		}
		$this->load->view('template_schedule', $data);
		// $this->output->enable_profiler(TRUE);
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
              // $this->session->set_flashdata('success','You have successfully deleted the selected subject.');
              $_SESSION['success'] = 'You have successfully deleted the selected subject.';
              redirect('student');
              
           }
           else
           {
              // $this->session->set_flashdata('error','Unable to delete the selected subject.');
              $_SESSION['error'] = 'Unable to delete the selected subject.';
              redirect('student');
           }

        }
        else
        {
            // $this->session->set_flashdata('error','Unable to delete the selected subject.');
            $_SESSION['error'] = 'Unable to delete the selected subject.';
              redirect('student');
        }
	}


	public function save_schedule()
	{
		if($this->input->post('subject'))
		{
			$_SESSION['success'] = '';
			$_SESSION['error'] = '';
			
			$cfn = $this->input->post('subject');
			$Sem = $_SESSION['sy_sem']['SemId'];
			$Sy = $_SESSION['sy_sem']['SyId'];
			$StudNo = $_SESSION['student_info']['StudNo'];

			$validate_sched = $this->M_addsched->validate_conflict($Sem,$Sy,$cfn,$StudNo);
           	
           	
			if($validate_sched['conflict_cnt']< 1)
			{
				$affected_rows = $this->M_enroll->enroll_student($_SESSION['student_info']['StudNo'],$this->input->post('subject'));
				if($affected_rows > 0)
				{
				  $this->M_enroll->set_user_logs('Add Subject - CFN ' . $this->input->post('subject'));	
				  $this->session->keep_flashdata('success','You have successfully added the selected subject.');
				  $_SESSION['success'] = 'You have successfully added the selected subject.';
	              redirect('student/');
				}
				else
				{
					$this->session->keep_flashdata('error','Class size limit has been reached. Unable to add the selected subject.');
					$_SESSION['error'] = 'Class size limit has been reached. <br>Unable to add the selected subject.';
	              	redirect('student/');
				}
			}
			else
			{
				
				$this->session->set_flashdata('error','There is a time conflict on your selected subject.'.$validate_sched['msg'] );
	            $_SESSION['error'] = 'There is a time conflict on your selected subject.'.$validate_sched['msg'];
	            redirect('student/');	
			}

			
			
			
		}
		else
		{
			$this->session->set_flashdata('error','Unable to add the selected subject.');
			$_SESSION['error'] = 'Unable to add the selected subject.';
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
			$this->db->where('IsActive',1);
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
				// $this->session->set_flashdata('success','You have successfully added the selected block schedule.');
				// $_SESSION['success'] = 	'You have successfully added the selected block schedule.';			 
				$_SESSION['success'] = 	'You have successfully added the courses in your block section. <strong>DONT FORGET TO ADD ANY SECTION FOR P.E. & NSTP BEFORE SAVING</strong>';
              redirect('student/');
			}
			else
			{
				// $this->session->set_flashdata('error','Unable to add the selected block schedule.');
              	$_SESSION['error'] = 'Unable to add the selected block schedule.';
              	redirect('student/');
			}		
		}
		else
		{
			// $this->session->set_flashdata('error','Unable to add the selected block schedule.');
			$_SESSION['error'] = 'Unable to add the selected block schedule.';
			redirect('student/');
		}

	}

	public function show_block_schedule()
	{
		$data['block_section_schedule'] = $this->M_enroll->get_block_section_schedule($_SESSION['sy_sem']['SyId'],
			$_SESSION['sy_sem']['SemId'],
			$_SESSION['student_curriculum']['CurriculumId'],
			$_SESSION['student_info']['LengthOfStayBySem'],
			$_SESSION['student_id'],
			$_SESSION['student_curriculum']['ProgramId'],
			$_SESSION['student_curriculum']['CollegeId'],
			$_SESSION['student_curriculum']['MajorId']);
		$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
		$this->M_enroll->set_user_logs('View Block Schedule');				
		$this->load->view('template_block_schedule',$data);
	}

	public function confirm_schedule()	
	{		
		$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],1,0);	
		$this->M_enroll->set_user_logs('Confirm Selected Class Schedule');
		redirect('student/encoded_subjects_assessment');
	}

    public function residency_scholarship()
    {            
    	$this->M_enroll->set_user_logs('View Chage of Residency and Scholarship Process');	
        $data['main_content'] = 'residencyProcess';
        $this->load->view('template_student',$data);
    }
               
    public function encoded_subjects_assessment()
    {
    	$studno = strtoupper($_SESSION['student_info']['StudNo']);
    	$sy_id = $_SESSION['sy_sem']['SyId'];
    	$sem_id = $_SESSION['sy_sem']['SemId'];

    	$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($sy_id, $sem_id, $studno);

    	if(!$_SESSION['enrollment_trans']['IsEncoded'])
		redirect('student/');

    	// MISC FEE PAYMENT
    	$data['student_org_payment'] = $this->M_assessment->getStudentPayment($studno);

		$data['ownedvoters'] = $this->M_assessment->getVotersCertificate($studno);
    	$data['printbutton'] = '';
    	
    	
		/**
		 * Student Assessment
		 * Do NOT assess if Student under the department of COAHS
		 *
		 **/

    	if ($_SESSION['student_curriculum']['CollegeId'] != "6") 	# COAHS
    	{

	    	$this->load->model('m_tuition');
	    	$tuition = $this->m_tuition->get_by(array('curriculum_id'=>$_SESSION['student_curriculum']['CurriculumId']), TRUE);
	    	// var_dump($this->db->last_query());
	    	if (count($tuition)) 
	    	{
		        // Process COAHS assessment
	    		$assessment = $this->M_assessment->_is_coahs_assessed($studno, $sy_id, $sem_id);
				if ($assessment === FALSE) 
    	        $assessment = $this->M_assessment->coahs_student_assess($studno, $sy_id, $sem_id);

				
    	        if ( ! empty($studno)) 
    	        {
    	        	// $this->db->where_in('AssId', array(2, 5));
    	        	$this->db->where(array('SemId'=>$sem_id, 'SyId'=>$sy_id, 'StudNo'=>$studno))->delete('tblassessmenttrans');
    	        }

	    		$data['per_unit_assessment'] = $assessment;

				// MISC FEE PAYMENT
    	        $data['student_org_payment']['Amount'] = 1.00;

    	        // TUITION FEE PAYMENT
	    		$data['student_tokenfee']['Amount'] = $assessment['grand_total'];
	    		$data['student_tokenfee']['DiscountPercentage'] = 0.00;
	    		$data['student_tokenfee']['IsPerUnit'] = TRUE;

	    		$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'], 0, 1);
	    	}
	    	else
	    	{
	    		// NORMAL Assessment -----------------------------------------------------------------
		        $IsAssessed = $this->M_assessment->isStudentAssessed($studno, $sy_id, $sem_id);
		    	if ($IsAssessed == FALSE)
		        {
			        // Process assessment
			        $this->M_assessment->AssessStudent($studno, $sem_id, $sy_id,
			        	$_SESSION['student_curriculum']['CollegeId'],
			        	$_SESSION['student_curriculum']['ProgramId'],
			        	$_SESSION['student_curriculum']['MajorId']
		        	);

		        }
		        
	        	$this->db->where_in('C.FeeId', array(20,21));
	        	$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($studno, TRUE);
		    	$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'],0,1);
	    	}

	        // Process payment schedule
        	if (in_array($_SESSION['enrollment_trans']['PaymentDate'], array('0000-00-00', NULL)))
        	{
        		$payment_date = $this->M_enroll->set_payment_schedule($_SESSION['enrollment_trans']['Id']);
        		$_SESSION['enrollment_trans']['PaymentDate'] = $payment_date;
        	}

        }
	    else
    	{
    		// Per Unit Computation --------------------------------------------------------------------
        	$tuition = $this->M_assessment->_is_tuition_exists($studno, $sy_id, $sem_id);

	    	if($_SESSION['enrollment_trans']['IsAssessed'] == '0')
	        {
        		if (count($tuition))
        		{
        			
			        // Process COAHS assessment
        	        $assessment = $this->M_assessment->coahs_student_assess($studno, $sy_id, $sem_id);

			        // Process student organization
			        $this->M_assessment->AssessStudent($studno, $sem_id, $sy_id,
			        	$_SESSION['student_curriculum']['CollegeId'],
			        	$_SESSION['student_curriculum']['ProgramId'],
			        	$_SESSION['student_curriculum']['MajorId']			        	
			    	);			        

			        // Update enrollment trans
			    	$this->M_enroll->update_enrollment_trans($_SESSION['enrollment_trans']['Id'], 0, 1);
        		}
        		else
        		{
        		    $_SESSION['error'] = "No tuition fee details found. Please call the attention of the accounting office.";
        		}
	        }
	        else
	        {
		    	$assessment = $this->M_assessment->_is_coahs_assessed($studno, $sy_id, $sem_id);
				
			    // Process student organization
			    $this->M_assessment->AssessStudent($studno, $sem_id, $sy_id,
			    	$_SESSION['student_curriculum']['CollegeId'],
			    	$_SESSION['student_curriculum']['ProgramId'],
			    	$_SESSION['student_curriculum']['MajorId']			        	
				);			
	        }
	        
	    
		    // dump($assessment);
		    if ( ! empty($assessment['remarks'])) 
		    {
			    $_SESSION['error'] = $assessment['remarks'];
		    }
		    
	        $this->db->where(array('FeeId' => 47, 'StudNo' => $studno, 'SyId' => $sy_id, 'SemId' => $sem_id, 'is_actived' =>1));
	        $payments = $this->db->get('tblpayment_coahs')->row_array();
	        
	        $data['tuition'] = $tuition;
	        $data['assessment']	= $assessment;
	        $data['payments'] = $payments;

	    	// $data['printbutton'] .= "<p class='lead'>Next step:<br/>";
	    	// $data['printbutton'] .= "<span style='color:red;'>Please print this advising slip and proceed to Accounting Office for your assessment.</span>";
	    	// $data['printbutton'] .= "<br/><br/><a href='".base_url()."student/print_encoded_subjects_assessment/' class='btn btn-primary btn-large' target='_blank'><b>VIEW PRINTER FRIENDLY VERSION</b> <i class='icon-print icon-white'></i> </a><br/><br/>";
	    }

    	// SCHOLARSHIP
        $data['AssDetails3'] = $this->M_assessment->getScholarship($studno);
    	
    	
    	// STUDENT SCHEDULES
    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$sy_id,$sem_id);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();

    	// MISC FEE ASSESSMENT
    	$this->db->where_not_in('C.FeeId', array(20, 21));
    	$data['student_assessment'] = $this->M_assessment->getStudentAssessment($studno);

    	$data['nstp_subject'] = $this->M_enroll->get_nstp_subject($studno, $sy_id, $sem_id); 

    	// $data['per_unit_assessment'] = $per_unit_assessment;

    	$data['main_content'] = 'encoded_subjects_assessment';
    	$this->M_enroll->update_logged_out($_SESSION['student_id']);
        $this->M_enroll->set_user_logs('View Encoded Subjects and Assessment');
        
        $this->load->view('template_student',$data);

        // $this->output->enable_profiler(TRUE);
    }

    public function print_encoded_subjects_assessment()
    {
    	$studno = strtoupper($_SESSION['student_info']['StudNo']);
    	$sy_id = $_SESSION['sy_sem']['SyId'];
    	$sem_id = $_SESSION['sy_sem']['SemId'];

    	// Fetch enrollment transaction
    	$this->db->_protect_identifiers=false;
    	$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($sy_id, $sem_id, $studno);
    	
    	//Fetch Email
    	// $stud_email = $this->db->where('StudNo',$studno)->get("{$this->feval}tblstudemailaccount")->row();

    	if (!$_SESSION['enrollment_trans']['IsEncoded'])
		redirect('student/'); 


		if ($_SESSION['student_curriculum']['CollegeId'] != 6)
		{	
			if ($_SESSION['enrollment_trans']['IsPrintedAdvisingSlip'] == '1' &&  $_SESSION["student_curriculum"]["IsGraduateProgram"] == 0 && $_SESSION["student_curriculum"]["IsTCP"] == 0 && $_SESSION["student_info"]["LengthOfStayBySem"] != '1')
			{
				$_SESSION['error'] = "<h4>Access id denied. You have already accessed your printer friendly copy of advising slip.</h4>";
		       	redirect('student/encoded_subjects_assessment');
			}

			$this->M_enroll->update_advising_slip($_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId'], $_SESSION['student_id']);
			$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'], $_SESSION['sy_sem']['SemId'], $_SESSION['student_id']);
			// 	$_SESSION['error'] = 'Printing of advising slip for non-COAHS student is not allowed. You can proceed to cash office for token fee payment.';
			// 	redirect('student/');
		}

    	$data['ownedvoters'] = $this->M_assessment->getVotersCertificate($studno);
    	$data['printbutton'] = '';

		// MISC ASSESSMENT
		$this->db->where_not_in('C.FeeId', array(20, 21));
		$data['student_assessment'] = $this->M_assessment->getStudentAssessment($studno);

		$data['nstp_subject'] = $this->M_enroll->get_nstp_subject($studno, $sy_id, $sem_id); 
		
		
		// MISC PAYMENT
		$data['student_org_payment'] = $this->M_assessment->getStudentPayment($studno);

    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$sy_id,$sem_id);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();

    	// if( $data['ownedvoters'] == TRUE && $_SESSION['student_curriculum']['CollegeId'] != "6") :

    	/**
    	 * Student Assessment
    	 * Do NOT assess if Student under the department of COAHS
    	 *
    	 **/

		if ($_SESSION['student_curriculum']['CollegeId'] != "6") # COAHS
		{
			// Fetch student scholarship
	        $data['AssDetails3'] = $this->M_assessment->getScholarship($studno);
			
        	$this->load->model('m_tuition');
        	$tuition = $this->m_tuition->get_by(array('curriculum_id'=>$_SESSION['student_curriculum']['CurriculumId']), TRUE);
        	
        	if (count($tuition)) 
        	{
        		$assessment = $this->M_assessment->_is_coahs_assessed(
        			$studno,
        			$sy_id,
        			$sem_id
    			);

    			if ($assessment === FALSE) 
    			{
    		        // Process COAHS assessment
        	        $assessment = $this->M_assessment->coahs_student_assess(
        	        	$studno,
        	        	$sy_id,
        	        	$sem_id
                	);

        	        /*// Process student organization
        	        $this->M_assessment->AssessStudent(
        	        	$studno,
        	        	$sem_id,
        	        	$sy_id,
        	        	$_SESSION['student_curriculum']['CollegeId'],
        	        	$_SESSION['student_curriculum']['ProgramId'],
        	        	$_SESSION['student_curriculum']['MajorId']			        	
        	    	);

        	        if ( ! empty($studno)) 
        	        {
        	        	$this->db->where('SemId', $sem_id);
        	        	$this->db->where('SyId', $sy_id);
        		    	$this->db->where('StudNo', $studno);
        	        	$this->db->where_in('AssId', array(2, 5));
        	        	$this->db->delete('tblassessmenttrans');
        	        }*/
    			}
				// MISC FEE PAYMENT
    	        $data['student_org_payment']['Amount'] = 1.00;

    	        // TUITION FEE PAYMENT
        		$data['student_tokenfee']['Amount'] = $assessment['grand_total'];
        		$data['student_tokenfee']['DiscountPercentage'] = 0.00;
        		$data['student_tokenfee']['IsPerUnit'] = TRUE;
        	}
        	else
        	{
				$this->db->where_in('C.FeeId', array(20,21));
				$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($studno, TRUE);
        	}

        	// sending Email
        	// if (count($stud_email)) 
        	// {
        	// 	$Email = ENVIRONMENT == 'production' ? $stud_email->Email : "johndenver.diaz@umak.edu.ph";
		       //  $message = "Please Do Not Reply on this Email.This is Automated Email Genaration";
		       //  $html = $this->load->view('pdf/pdf_advising_slip', $data,true);
		       //  // dump($html);
		       //  $attached_file = $this->attached_file($html);
		       //  $result = $this->send_verification($Email, $message, $attached_file);
        	// }
	        //sending Email Code End

	        $this->load->view('template_print', $data);
	    }
	    else
	    {
	    	if($_SESSION['enrollment_trans']['IsAssessed'] == '0')
	           	redirect('student/encoded_subjects_assessment');

        	// Fetch tuition
        	$tuition = $this->M_assessment->_is_tuition_exists(
        		$studno,
        		$sy_id,
        		$sem_id
        	);

        	// Fetch assessment
        	$assessment = $this->M_assessment->_is_coahs_assessed(
        		$studno,
        		$sy_id,
        		$sem_id
    		);

    		if ( ! $tuition)
    		{
    		    $_SESSION['error'] = "No tuition fee details found. Please call the attention of the accounting office.";
	           	redirect('student/encoded_subjects_assessment');
    		}

    		if ($assessment['assessed_by'] == 0) 
    		{
	           	redirect('student/encoded_subjects_assessment');
    		}

    		// Process payment schedule
	        // dump($_SESSION['enrollment_trans']);
        	if (in_array($_SESSION['enrollment_trans']['PaymentDate'], array('0000-00-00', NULL)) && $assessment['assessed_by'] > 0);
        	{
        		$payment_date = $this->M_enroll->set_payment_schedule($_SESSION['enrollment_trans']['Id']);
        		$_SESSION['enrollment_trans']['PaymentDate'] = $payment_date;
        		// dump($payment_date);
        	}
	        
	        $data['tuition']	= $tuition;
	        $data['assessment']	= $assessment;
	        if ($assessment['assessed_by'] > 0) 
	        {
	        	$staff = $this->db->where('Id', $assessment['assessed_by'])->get('tbluser')->row();
	        	$data['accounting_staff'] = $staff->lastname . ',' . $staff->firstname;
	        }

	    	// $data['printbutton'] .= "<p class='lead'>Next step:<br/>";
	    	// $data['printbutton'] .= "<span style='color:red;'>Please print this advising slip and proceed to Accounting Office for your assessment on ";

	    	// sending Email
			// if (count($stud_email)) 
   //      	{
   //      		$Email = ENVIRONMENT == 'production' ? $stud_email->Email : "johndenver.diaz@umak.edu.ph";
		 //        $message = "Please Do Not Reply on this Email.This is Automated Email Genaration";
		 //        $html = $this->load->view('pdf/pdf_advising_slip', $data,true);
		 //        // dump($html);
		 //        $attached_file = $this->attached_file($html);
		 //        $result = $this->send_verification($Email, $message, $attached_file);
   //      	}
	        //sending Email Code End

	        $this->load->view('template_print_coahs_advising', $data);
		}
		// dump($stud_email);
        $this->M_enroll->set_user_logs('Print Encoded Sujects and Assessment');
        // $this->load->view('template_print_otc_lbp', $data);
    }

    public function print_online_cor_development()
    {
    	echo "<h3>This page is under maintenance, try to access your C.O.R. at 2PM today June 5, 2014. Thank you for your patience.</h3>";
    	echo "<p><a href='#' onclick='window.close()'>Back to enrollment page</a>.</p>";
    }


    public function print_online_cor()
    {
    	echo "<h3>Your Online Certificate Of Registration will be sent to your UMak e-mail account after 24 hours upon payment. Thank you.</h3>";
    	echo "<p><a href='".base_url('student/encoded_subjects_assessment')."'>Back to enrollment page</a>.</p>";

    	return TRUE;

    	$studno = strtoupper($_SESSION['student_info']['StudNo']);
    	$sy_id = $_SESSION['sy_sem']['SyId'];
    	$sem_id = $_SESSION['sy_sem']['SemId'];

    	// get enrollment trans
    	$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($sy_id, $sem_id, $studno);
    	if(!$_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/');

    	$timezone = "Asia/Hong_Kong";
    	if(function_exists('date_default_timezone_set'))
    	date_default_timezone_set($timezone);
    	$data['current_date'] = date('Y-m-d');

        // assessment STUDENT ORG PAYMENT details
        $data['student_assessment'] = $this->M_assessment->getStudentPayment($studno);

        // nstp payment
        $data['nstp_payment'] = $this->M_assessment->get_nstp_payment($studno, $sy_id, $sem_id); 

    	$data['ownedvoters'] = $this->M_assessment->getVotersCertificate($studno);
    	$data['printbutton'] = '';
		if ($_SESSION['student_curriculum']['CollegeId'] != "6") 	# COAHS
		{
			// Fetch student scholarship
	        $data['AssDetails3'] = $this->M_assessment->getScholarship($studno);
			/*
			// Fetch assessment
			// $this->db->where_not_in('C.FeeId', array(20,21));
			$data['student_assessment'] = $this->M_assessment->getStudentPayment($studno);

			$this->db->where_in('C.FeeId', array(20,21));
			$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($studno, TRUE);*/

	    	$this->load->model('m_tuition');
	    	$tuition = $this->m_tuition->get_by(array('curriculum_id'=>$_SESSION['student_curriculum']['CurriculumId']), TRUE);
	    	
	    	if (count($tuition)) 
	    	{
	    		$assessment = $this->M_assessment->_is_coahs_assessed(
	    			$studno,
	    			$sy_id,
	    			$sem_id
				);

				if ($assessment === FALSE) 
				{
			        // Process COAHS assessment
	    	        $assessment = $this->M_assessment->coahs_student_assess(
	    	        	$studno,
	    	        	$sy_id,
	    	        	$sem_id
	            	);

				}

				// MISC FEE PAYMENT
    	        $data['student_org_payment']['Amount'] = 1.00;

    	        // TUITION FEE PAYMENT
	    		$data['student_tokenfee']['Amount'] = $assessment['grand_total'];
	    		$data['student_tokenfee']['DiscountPercentage'] = 0.00;
	    		$data['student_tokenfee']['IsPerUnit'] = TRUE;
	    	}
	    	else
	    	{

		        $IsAssessed = $this->M_assessment->isStudentAssessed($studno, $sy_id, $sem_id);
		    	// if($_SESSION['enrollment_trans']['IsAssessed'] == '0' ||  $IsAssessed == FALSE)
		    	if ($IsAssessed === FALSE)
		        {
			        // Process assessment
			        $this->M_assessment->AssessStudent(
			        	$studno,
			        	$sem_id,
			        	$sy_id,
			        	$_SESSION['student_curriculum']['CollegeId'],
			        	$_SESSION['student_curriculum']['ProgramId'],
			        	$_SESSION['student_curriculum']['MajorId']
		        	);

		        }
		        
	        	$this->db->where_in('C.FeeId', array(20,21));
	        	$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($studno, TRUE);
	    	}
	    }
	    else
	    {
	    	if($_SESSION['enrollment_trans']['IsAssessed'] == '0')
	           	redirect('student/encoded_subjects_assessment');
	        

        	// Fetch tuition
        	$tuition = $this->M_assessment->_is_tuition_exists(
        		$studno,
        		$sy_id,
        		$sem_id
        	);

        	// Fetch assessment
        	$assessment = $this->M_assessment->_is_coahs_assessed(
        		$studno,
        		$sy_id,
        		$sem_id
    		);

    		if ( ! $tuition)
    		{
    		    $_SESSION['error'] = "No tuition fee details found. Please call the attention of the accounting office.";
	           	redirect('student/encoded_subjects_assessment');
    		}

    		if ($assessment['assessed_by'] == 0) 
    		{
	           	redirect('student/encoded_subjects_assessment');
    		}

    		// Process payment schedule
	        // dump($_SESSION['enrollment_trans']);
        	if (in_array($_SESSION['enrollment_trans']['PaymentDate'], array('0000-00-00', NULL)) && $assessment['assessed_by'] > 0);
        	{
        		$payment_date = $this->M_enroll->set_payment_schedule($_SESSION['enrollment_trans']['Id']);
        		$_SESSION['enrollment_trans']['PaymentDate'] = $payment_date;
        		// dump($payment_date);
        	}
	        
	        $this->db->where(array(
	        	'FeeId' => 47, 
	        	'StudNo' => $studno, 
	        	'SyId' => $sy_id, 
	        	'SemId' => $sem_id,
	        	'is_actived' => 1)
	       	);
	        $payments = $this->db->get('tblpayment_coahs')->row_array();
	        
	        if ($assessment['assessed_by'] > 0) 
	        {
	        	$staff = $this->db->where('Id', $assessment['assessed_by'])->get('tbluser')->row();
	        	$data['accounting_staff'] = $staff->lastname . ',' . $staff->firstname;
	        }

	        $data['tuition']	= $tuition;
	        $data['assessment']	= $assessment;
	        $data['payments']	= $payments;

	    	// $data['printbutton'] .= "<p class='lead'>Next step:<br/>";
	    	// $data['printbutton'] .= "<span style='color:red;'>Please print this advising slip and proceed to Accounting Office for your assessment on ";
		}

    	$data['dean'] = $this->db->where('college_id', $_SESSION['student_curriculum']['CollegeId'])->get('tbldean')->row_array();
    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$sy_id,$sem_id);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
        $this->M_enroll->set_user_logs('Print online C.O.R.');

        
		if ($_SESSION['student_curriculum']['CollegeId'] == "6") 	# COAHS
        $this->load->view('template_print_cor_coahs',$data);
        else
        $this->load->view('template_print_cor',$data);
        
		$this->M_enroll->update_cor_trans($_SESSION['enrollment_trans']['Id']);
        // $this->output->enable_profiler(TRUE);
        
    }    


    public function print_online_cor_tmp()
    {
    	$studno = strtoupper($_SESSION['student_info']['StudNo']);
    	$sy_id = $_SESSION['sy_sem']['SyId'];
    	$sem_id = $_SESSION['sy_sem']['SemId'];

    	// get enrollment trans
    	$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($sy_id, $sem_id, $studno);
    	if(!$_SESSION['enrollment_trans']['IsEncoded'])
    		redirect('student/');

    	$timezone = "Asia/Hong_Kong";
    	if(function_exists('date_default_timezone_set'))
    	date_default_timezone_set($timezone);
    	$data['current_date'] = date('Y-m-d');

        // assessment STUDENT ORG PAYMENT details
        $data['student_assessment'] = $this->M_assessment->getStudentPayment($studno);


        // nstp payment
        $data['nstp_payment'] = $this->M_assessment->get_nstp_payment($studno, $sy_id, $sem_id); 

    	$data['ownedvoters'] = $this->M_assessment->getVotersCertificate($studno);
    	$data['printbutton'] = '';
		if ($_SESSION['student_curriculum']['CollegeId'] != "6") 	# COAHS
		{
			// Fetch student scholarship
	        $data['AssDetails3'] = $this->M_assessment->getScholarship($studno);

	    	$this->load->model('m_tuition');
	    	$tuition = $this->m_tuition->get_by(array('curriculum_id'=>$_SESSION['student_curriculum']['CurriculumId']), TRUE);
	    	
	    	if (count($tuition)) 
	    	{
	    		$assessment = $this->M_assessment->_is_coahs_assessed(
	    			$studno,
	    			$sy_id,
	    			$sem_id
				);

				if ($assessment === FALSE) 
				{
			        // Process COAHS assessment
	    	        $assessment = $this->M_assessment->coahs_student_assess(
	    	        	$studno,
	    	        	$sy_id,
	    	        	$sem_id
	            	);

				}

				// MISC FEE PAYMENT
    	        $data['student_org_payment']['Amount'] = 1.00;

    	        // TUITION FEE PAYMENT
	    		$data['student_tokenfee']['Amount'] = $assessment['grand_total'];
	    		$data['student_tokenfee']['DiscountPercentage'] = 0.00;
	    		$data['student_tokenfee']['IsPerUnit'] = TRUE;
	    	}
	    	else
	    	{

		        $IsAssessed = $this->M_assessment->isStudentAssessed($studno, $sy_id, $sem_id);
		    	// if($_SESSION['enrollment_trans']['IsAssessed'] == '0' ||  $IsAssessed == FALSE)
		    	if ($IsAssessed === FALSE)
		        {
			        // Process assessment
			        $this->M_assessment->AssessStudent(
			        	$studno,
			        	$sem_id,
			        	$sy_id,
			        	$_SESSION['student_curriculum']['CollegeId'],
			        	$_SESSION['student_curriculum']['ProgramId'],
			        	$_SESSION['student_curriculum']['MajorId']
		        	);

		        }
		        
	        	$this->db->where_in('C.FeeId', array(20,21));
	        	$data['student_tokenfee'] = $this->M_assessment->getStudentAssessment($studno, TRUE);
	        	
	        	
	        	var_dump($_SESSION['token_fee_payment']);
	    	}
	    }
	    else
	    {
	    	if($_SESSION['enrollment_trans']['IsAssessed'] == '0')
	           	redirect('student/encoded_subjects_assessment');
	        

        	// Fetch tuition
        	$tuition = $this->M_assessment->_is_tuition_exists(
        		$studno,
        		$sy_id,
        		$sem_id
        	);

        	// Fetch assessment
        	$assessment = $this->M_assessment->_is_coahs_assessed(
        		$studno,
        		$sy_id,
        		$sem_id
    		);

    		if ( ! $tuition)
    		{
    		    $_SESSION['error'] = "No tuition fee details found. Please call the attention of the accounting office.";
	           	redirect('student/encoded_subjects_assessment');
    		}

    		if ($assessment['assessed_by'] == 0) 
    		{
	           	redirect('student/encoded_subjects_assessment');
    		}

    		// Process payment schedule
        	if (in_array($_SESSION['enrollment_trans']['PaymentDate'], array('0000-00-00', NULL)) && $assessment['assessed_by'] > 0);
        	{
        		$payment_date = $this->M_enroll->set_payment_schedule($_SESSION['enrollment_trans']['Id']);
        		$_SESSION['enrollment_trans']['PaymentDate'] = $payment_date;
        	}
	        
	        $this->db->where(array(
	        	'FeeId' => 47, 
	        	'StudNo' => $studno, 
	        	'SyId' => $sy_id, 
	        	'SemId' => $sem_id)
	       	);
	        $payments = $this->db->get('tblpayment_coahs')->row_array();
	        
	        if ($assessment['assessed_by'] > 0) 
	        {
	        	$staff = $this->db->where('Id', $assessment['assessed_by'])->get('tbluser')->row();
	        	$data['accounting_staff'] = $staff->lastname . ',' . $staff->firstname;
	        }

	        $data['tuition']	= $tuition;
	        $data['assessment']	= $assessment;
	        $data['payments']	= $payments;

	    	// $data['printbutton'] .= "<p class='lead'>Next step:<br/>";
	    	// $data['printbutton'] .= "<span style='color:red;'>Please print this advising slip and proceed to Accounting Office for your assessment on ";
		}

    	$data['dean'] = $this->db->where('college_id', $_SESSION['student_curriculum']['CollegeId'])->get('tbldean')->row_array();
    	$data['selected_schedule'] = $this->M_enroll->get_selected_schedule($_SESSION['student_id'],$sy_id,$sem_id);
    	$data['rooms'] = $this->db->join('tblbuilding as B','A.BuildingId = B.BuildingId')->get('tblroom as A')->result_array();
        
		if ($_SESSION['student_curriculum']['CollegeId'] == "6") 	# COAHS
        $this->load->view('template_print_cor_coahs',$data);
        else
        $this->load->view('template_print_cor_tmp',$data);
        
        // $this->output->enable_profiler(TRUE);
        
    }    


	public function logout()
    {
    	$this->M_enroll->set_user_logs('Log Out');
        $this->M_enroll->update_logged_out($_SESSION['student_id']);
        unset($_SESSION);
        session_destroy();
        redirect(base_url());
    }


    public function student_profile()
    {
    	$this->load->model('m_guidance_student');
        $fields = $this->db->field_data('umaktest_guidance.tblstudentinfo');
    	$student = $this->m_guidance_student->get_by(array('studno'=>$_SESSION['student_id']),TRUE);
    	if (!(count($student))) 
    		$student = $this->m_guidance_student->get_new();

    	$rules = $this->m_guidance_student->rules;
    	$this->form_validation->set_rules($rules);
    	if ($this->form_validation->run() == TRUE)
		{
			
		}
		else
		{
			dump(validation_errors());
		}

    	// dump(db_fields($fields));
    	$data['student'] = $student;
    	$data['question'] = $this->db->get('umaktest_guidance.tblquestion')->result();
    	$data['category'] = $this->db->get('umaktest_guidance.tblquestioncat')->result();
        $data['main_content'] = 'stud_profile';
        $this->load->view('template_student',$data);        
    }


    public function attached_file($html = NULL)
    {
    	if ($html != NULL) 
    	{
    		// dump($pdf);
	    	$this->load->library('Pdf');
	    	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	    	$pdf->SetTitle('ADVISING SLIP');
			$pdf->SetPrintHeader(false);
			$pdf->SetPrintFooter(false);
			// $pdf->SetAutoPageBreak(true, 0);
			$pdf->SetAuthor('ITC SOLUTION SECTION');
			$pdf->SetDisplayMode('real', 'default');
			// $pdf->setCellHeightRatio(2);
			$pdf->AddPage();

			// $data['studentdata'] = $this->student_m->get_student_info($StudNo, $SyId, $SemId);
			// $data['random_password'] = $random_password;
			// $data['transaction_no'] = $FinalPermitId;
			// $data['Fp'] = $this->final_permit_m->get($FinalPermitId,TRUE);
			$pdf->writeHTML($html,true, false, true, false, '');
			if (ob_get_contents()) ob_end_clean();

			 $attached_file = $_SERVER['DOCUMENT_ROOT'] .'olea/assets/advising_pdf/test.pdf';

			$pdf->Output($attached_file,'F');

			return $attached_file;
    	}
    } 

    public function send_verification($email,$msg, $attached_file)
    {
        $this->db->where('sentcount < 490');
        $umak_email = $this->db->get($this->feval .'tblumakemailaccount')->row();
        $current_email = $umak_email->email;
        $current_pass = $umak_email->password;

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => $current_email,
            'smtp_pass' => $current_pass,
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        // Set to, from, message, etc.
        $this->email->from('itc_support@umak.edu.ph', 'UMAK-ITC SUPPORT');
        $this->email->to($email);
        $this->email->cc('itc_olea@umak.edu.ph'); 
        $this->email->subject('Advising Slip');
        $this->email->message($msg); 
        $this->email->attach($attached_file);   

        $this->db->query('update ' .$this->feval. 'tblumakemailaccount set sentcount = sentcount+2 where umakemailaccount_id = '.$umak_email->umakemailaccount_id);
                
        return $result = $this->email->send();
        // echo $this->email->print_debugger();  
    }

}

/* End of file site.php */
/* Location: ./application/controllers/site.php */
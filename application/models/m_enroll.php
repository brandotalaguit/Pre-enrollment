<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_enroll extends CI_Model{
		
	function __construct()
	{
		parent::__construct();		
	}

	function get_current_sy_sem()
    {
        $this->db->select('A.EnrollmentDateStart,A.EnrollmentDateEnd,B.*,C.*,EncodingDateEnd');
        $this->db->from('tblsysem as A');
        $this->db->join('tblsem as B','A.SemId = B.SemId');
        $this->db->join('tblsy as C','A.SyId = C.SyId');
        // $this->db->where('IsCurrentSem','1');
        $this->db->where(array('A.SyId' => 7, 'A.SemId' => 1));
        // $this->db->where('IsClassSchedule','1');
        $query = $this->db->get();
        $row = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
        }
        $this->db->close();
        return $row;
    }

    function get_student_info($student_id)
    {
    	$student_info = array();
        $student_info = $this->db->where('StudNo',$student_id)
        ->get('tblstudinfo')->row_array();                
        return $student_info;
    }

	function get_student_curriculum($student_id)
	{
		$student_curriculum = array();
		$student_curriculum = $this->db
									->select('B.*, ProgramDesc, ProgramCode, CollegeDesc, CollegeCode, MajorDesc, MajorCode')
									->join('tblcurriculum as B','A.CurriculumId = B.CurriculumId', 'left')
									->join('tblprogram as C','B.ProgramId = C.ProgramId', 'left')
									->join('tblcollege as D','B.CollegeId = D.CollegeId', 'left')
									->join('tblmajor as E','B.MajorId = E.MajorId', 'left')
									->where('StudNo',$student_id)
									->get('tblstudcurriculum as A')
									->row_array();
		return $student_curriculum;
	}

	function get_year_level($curriculum_id, $college_id, $LengthOfStayBySem)
	{
		//if ($college_id == 6 && !in_array($curriculum_id, array('53'))) 
	if (in_array($college_id, array('6','11')) && !in_array($curriculum_id, array('53')))
        {
            $data['semester'] = array(  1  => 'First Year' , 
                                        2  => 'First Year', 
                                        3  => 'First Year', 
                                        4  => 'Second Year', 
                                        5  => 'Second Year', 
                                        6  => 'Second Year', 
                                        7  => 'Third Year', 
                                        8  => 'Third Year',
                                        9  => 'Third Year',
                                        10 => 'Fourth Year', 
                                        11 => 'Fourth Year'); 

        }
        else
        {
            switch ($curriculum_id) 
            {
    			case '144':  # BACHELOR IN PERFORMING ARTS MAJOR IN THEATER ARTS(2014)
    	        	$data['semester'] = array(  1  => 'First Year' , 
    	                                    2  => 'First Year',
    	                                    3  => 'First Year', 
    	                                    4  => 'Second Year', 
    	                                    5  => 'Second Year', 
    	                                    6  => 'Second Year', 
    	                                    7  => 'Third Year', 
    	                                    8  => 'Third Year',
    	                                    9  => 'Fourth Year', 
    	                                    10 => 'Fourth Year');             
    	        	break;
                case '55':  # BACHELOR OF SCIENCE IN CIVIL ENGINEERING
                    $data['semester'] = array(  1  => 'First Year' , 
                                                2  => 'First Year', 
                                                3  => 'Second Year', 
                                                4  => 'Second Year', 
                                                5  => 'Third Year', 
                                                6  => 'Third Year',
                                                7  => 'Fourth Year', 
                                                8  => 'Fourth Year',
                                                9  => 'Fourth Year', 
                                                10 => 'Fifth Year', 
                                                11 => 'Fifth Year');             
                    break;

					case '53':  # BACHELOR OF SCIENCE IN RADIOLOGIC TECHNOLOGY
                    $data['semester'] = array(  1  =>'First Year' , 
	        				                	2  =>'First Year', 
	        				                	3  =>'First Year', 
	        				                	4  =>'Second Year', 
	        				                	5  =>'Second Year', 
	        				                	6  =>'Second Year', 
	        				                	7  =>'Third Year', 
	        				                	8  =>'Third Year',
	        				                	9  =>'Fourth Year', 
	        				                	10 =>'Fourth Year');
                    break;

                    case '25': # BACHELOR OF SCIENCE IN ACCOUNTANCY FIFTH YEAR PROGRAM
                    $data['semester'] = array(  1  =>'Fifth Year' , 
	        				                	2  =>'Fifth Year', 
	        				                	10  =>'Fifth Year', 
	        				                	11  =>'Fifth Year');
                    break;

                    case '66':  # DIPLOMA IN CIVIL TECHNOLOGY (DCET)
                    $data['semester'] = array(  1  =>'First Year' , 
                                                    2  =>'First Year', 
                                                    3  =>'Second Year', 
                                                    4  =>'Second Year', 
                                                    5  =>'Second Year', 
                                                    6  =>'Third Year', 
                                                    7  =>'Third Year');
	                         break;

                    case '135':  # BACHELOR OF SCIENCE IN CONSTRUCTION ENGINEERING TECHNOLOGY
                    case '191':  # BACHELOR OF SCIENCE IN CONSTRUCTION ENGINEERING 2016
					$data['semester'] = array(  1  => 'First Year', 
							                    2  => 'First Year', 
							                    3  => 'First Year', 
							                    4  => 'Second Year', 
							                    5  => 'Second Year', 
							                    6  => 'Second Year', 
							                    7  => 'Third Year', 
							                    8  => 'Third Year',
							                    9  => 'Third Year',
							                    10 => 'Fourth Year', 
							                    11 => 'Fourth Year'); 
	                    break;

	                case '172':  # BACHELOR OF SCIENCE IN CIVIL ENGINEERING 2014
	                case '190':  # BACHELOR OF SCIENCE IN CIVIL ENGINEERING 2016
                    $data['semester'] = array(		1  => 'First Year', 
	                                                2  => 'First Year', 
	                                                3  => 'Second Year', 
	                                                4  => 'Second Year', 
	                                                5  => 'Third Year', 
	                                                6  => 'Third Year',
	                                                7  => 'Fourth Year', 
	                                                8  => 'Fourth Year',
	                                                9  => 'Fourth Year', 
	                                                10 => 'Fifth Year', 
	                                                11 => 'Fifth Year');             
	                    break;

                    case '189':  # BACHELOR IN PHYSICAL WELLNESS MAJOR IN SPORTS MANAGEMENT
                    case '210':  # BACHELOR IN PHYSICAL WELLNESS MAJOR IN SPORTS MANAGEMENT (2017)
                    $data['semester'] = array(		1  => 'First Year', 
	                                                2  => 'First Year', 
	                                                3  => 'Second Year', 
	                                                4  => 'Second Year', 
	                                                5  => 'Second Year', 
	                                                6  => 'Third Year', 
	                                                7  => 'Third Year',
	                                                8  => 'Third Year', 
	                                                9  => 'Fourth Year', 
	                                                10  => 'Fourth Year');     
	                    break;

                    
                default:    # REGULAR PROGRAM
                    $data['semester'] = array(  0  => '',
                    				1  => 'First Year' ,
                                                2  => 'First Year', 
                                                3  => 'Second Year', 
                                                4  => 'Second Year', 
                                                5  => 'Third Year', 
                                                6  => 'Third Year',
                                                7  => 'Fourth Year', 
                                                8  => 'Fourth Year',
                                                9  => 'Fifth Year', 
                                                10 => 'Fifth Year');             
                    break;

            } # end case 
            

        } # end if 

        return $data['semester'][$LengthOfStayBySem];
	}

	function get_selected_schedule($student_id,$sy_id,$sem_id)
	{
		// $this->remove_inactive_schedule($student_id,$sy_id,$sem_id);
		$selected_schedule = array();
		$this->db->where('IsActive',1);
		$selected_schedule = $this->db->where('StudNo',$student_id)->where('A.SyId',$sy_id)->where('A.SemId',$sem_id)->join('tblsched as B','A.Cfn = B.cfn','left')->join('tblcourse as C','B.subject_id = C.CourseId','left')->order_by('A.Cfn')->get('tblstudentschedule as A')->result_array();	
		return $selected_schedule;
	}

	public function get_nstp_subject($studno, $sy_id, $sem_id)
	{
        $nstp_course_id = array(14, 19, 1857, 1858, 1859, 1860, 1861, 1862); 
        
        $this->db->where_in('subject_id', $nstp_course_id);
        return $this->get_selected_schedule($studno, $sy_id, $sem_id); 
	}
	
	public function set_payment_schedule($enrollment_trans_id)
	{
		$time = date('H:i');
		$payment_sched = 'b.payment_schedule >= "' . date('Y-m-d') . '"';
		if ($time > '12:00') 
		$payment_sched = 'b.payment_schedule > "' . date('Y-m-d') . '"';

		$this->db->where('enrollment_trans_id', $enrollment_trans_id);
		$this->db->limit(1)->delete('tblstudpaymentsched');

		// Assign student payment schedule
		$sql = 'INSERT INTO tblstudpaymentsched(enrollment_trans_id, payment_schedule_id)
		    		SELECT ?, payment_schedule_id FROM tblpaymentschedule as b
			    		WHERE (SELECT COUNT(*)+1 FROM tblenrollmenttrans as c WHERE c.PaymentDate = b.payment_schedule) <= b.max_student 
			    		AND ' . $payment_sched . 'ORDER BY  b.payment_schedule ASC 
					LIMIT 1';


		$this->db->query($sql, array($enrollment_trans_id));


		$payment_date = $this->db->where('enrollment_trans_id', $enrollment_trans_id)
			    		->join('tblstudpaymentsched as b', 'b.payment_schedule_id = a.payment_schedule_id', 'left')
			    		->get('tblpaymentschedule as a')
			    		->row_array();

		// Update enrollment transaction payment date
		$this->db->where('Id', $enrollment_trans_id)->update('tblenrollmenttrans', 
					array(
						'PaymentDate' => $payment_date['payment_schedule']
					)
		);

		// echo $this->db->last_query();
		// $affected_data = $this->db->affected_rows();
		// echo "affected_rows $affected_data" ;

		return $payment_date['payment_schedule'];

	}

	private function remove_inactive_schedule($student_id,$sy_id,$sem_id)
	{
		/*
		$this->load->helper('date');
		$timestamp = now();
		$timezone  = 'UP8';
		$date_time = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));
	    
		$this->db->query("INSERT INTO tblstudentschedule_inactive(SyId,SemId,StudNo,Cfn,DateLogged)
					 SELECT SyId,SemId,StudNo,Cfn,'$date_time' 
					 FROM tblstudentschedule
					 WHERE  StudNo = '$student_id' AND
					 	SyId = $sy_id AND 
					 	SemId = $sem_id AND 
					 	IsActive = 0
					 ");
		
		$this->db->where('StudNo',$student_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->where('IsActive',0);
		$this->db->delete('tblstudentschedule');			
		*/
	}
	
	
	
	function get_inactive_schedule($student_id,$sy_id,$sem_id)
	{
		$inactive_schedule = array();
		$this->db->where('StudNo',$student_id)->where('SyId',$sy_id)->where('SemId',$sem_id);
		$inactive_schedule = $this->db->get('tblstudentschedule')->result_array();
		return $inactive_schedule;
	}	
	

	function enroll_student($StudNo,$Cfn)
    {
    	/*
        $sql = 'INSERT INTO tblstudentschedule(SyId,SemId,StudNo,Cfn)
        SELECT SyId,SemId,?,cfn FROM tblsched
        WHERE cfn = ?  AND 
        (
            ( SELECT COALESCE(COUNT(*)+1, 0) FROM tblstudentschedule WHERE Cfn = ? AND IsActive = 1 ) - 
            ( SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as A LEFT JOIN tblstudcmat as B ON A.cmat_id = B.cmat_id
                WHERE cfn_from = ? AND B.is_actived = 1 AND disapproved_note = "" )
        ) + 
        (
            SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as A LEFT JOIN tblstudcmat as B ON A.cmat_id = B.cmat_id
                WHERE cfn_to = ? AND B.is_actived = 1 AND disapproved_note = "" 
        )
		<= class_size LIMIT 1';
	*/
	$sql = 'INSERT INTO tblstudentschedule(SyId,SemId,StudNo,Cfn)
        	SELECT SyId,SemId,?,cfn FROM tblsched
        	WHERE cfn = ?  AND (
        	(
        			(SELECT COALESCE(COUNT(*)+1, 0) FROM tblstudentschedule as C WHERE C.Cfn = ? AND IsActive = 1) +
	 			(SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as F LEFT JOIN tblstudcmat as G ON F.cmat_id = G.cmat_id
				 	WHERE cfn_to = ? AND G.is_actived = 1 AND disapproved_note = "")
			) 
			- 
			(
				 ( SELECT COALESCE(COUNT(*), 0) FROM tblstudcmatloads as D 
				 LEFT JOIN tblstudcmat as E ON D.cmat_id = E.cmat_id
				 WHERE cfn_from = ? AND E.is_actived = 1 AND disapproved_note = "" AND E.printed_at = "0000-00-00 00:00:00"
				 )
			 +
				 ( SELECT COALESCE(COUNT(*), 0) FROM tblstudentschedule as H 
				 INNER JOIN tblstudcmatloads as I ON H.StudNo=I.StudNo AND H.cfn=I.cfn_to 
				 LEFT JOIN tblstudcmat as J ON I.cmat_id = J.cmat_id
				 WHERE J.is_actived = 1 AND disapproved_note = "" AND H.cfn = ?
				 )
			)
 
		) <= class_size LIMIT 1';
        $this->db->query($sql, array($StudNo,$Cfn,$Cfn,$Cfn,$Cfn,$Cfn));
        return $this->db->affected_rows();
    }

    function first_yr_sechedule_restriction()
    {
    	if ($_SESSION['student_info']['AllowAccessTo1stYrSched'] != 1) 
    	{
    		$this->db->where('LEFT(year_section,2) != "I-"', NULL, FALSE);
    	}
    }

	function get_curriculum_template($curriculum_id,$student_id,$length_of_stay,$sy_id,$sem_id)
	{
		$filter_remarks = array('FAILED', 'LOA', 'UD', 'OD', 'UNOFFICIALLY DROPPED', 'OFFICIALLY DROPPED');
		$passed_remarks = array('PASSED', 'P');

		$curriculum_template = array();
		$query = $this->db->where('CurriculumId',$curriculum_id)
		->join('tblcourse as B','A.CourseId = B.CourseId')->
		get('tblcurriculumdetails as A');		
		$ctr = 0;
		if($query->num_rows() > 0)
	    {
	    	foreach($query->result_array() as $row)
	    	{        		
	    		$curriculum_template[$ctr]['CourseId'] = $row['CourseId'];
				$curriculum_template[$ctr]['CourseCode'] = $row['CourseCode'];
				if($row['CourseId'] == $row['EquivalentCourse'])
				{
					$curriculum_template[$ctr]['EquivalentCourse'] = '';
				}
				else
				{
					$curriculum_template[$ctr]['EquivalentCourse'] = $row['EquivalentCourse'];
				}
				
				$curriculum_template[$ctr]['CourseDesc'] = $row['CourseDesc'];
				$curriculum_template[$ctr]['Units'] = $row['Units'];		
				$curriculum_template[$ctr]['LengthOfStayBySem'] = $row['LengthOfStayBySem'];		
				
				if(!empty($row['PreRequisiteCourseCode']))
				{
					$pre_requisite = explode(',',$row['PreRequisiteCourseCode']);
					$pre_requisites = NULL;
					$ctr1 = 1;
					foreach($pre_requisite as $pr)
					{
						 $ccode = $this->db->select('CourseCode')->where('CourseId',$pr)->get('tblcourse')->row_array();
						 if(count($pre_requisite) == $ctr1)
							 $pre_requisites .= $ccode['CourseCode'] ;
						 else
						 	$pre_requisites .= $ccode['CourseCode'] . ',' ;
						 $ctr1++;
					}
					$curriculum_template[$ctr]['PreRequisiteCourseCode'] = $pre_requisites;						
				}
				else
				{
					$curriculum_template[$ctr]['PreRequisiteCourseCode'] = '';
				}


				if ( ! empty($row['EquivalentCourse'])) 
				{
					$EquivalentCourse = $row['CourseId'] . ',' . $row['EquivalentCourse'];
					$this->db->where("CourseId IN($EquivalentCourse)", NULL);
				}
				else
				{
					$this->db->where('CourseId', $row['CourseId']);
				}
				// $grade = $this->db->select('Remarks')->where('StudNo',$student_id)->where('is_actived', 1)->get('tblstudgrade');

				$grade = $this->db->select('Remarks, nametable, IsCompleted')
					->where('(UPPER(Remarks) IN("PASSED", "INCOMPLETE", "INC") OR IsCompleted = 1)', NULL, FALSE)
					->where(array('StudNo'=>$student_id, 'is_actived' => 1, 'IsLapsed' => 0))
					->get('tblstudgrade');
				
				if($grade->num_rows() > 0)
				{
					// foreach($grade->result_array() as $remarks)
					// {
					// }
					$remarks = $grade->row_array();
				}
				else
				{
					$remarks['Remarks'] = 'NOT TAKEN';
				}
																			
				if(strtoupper($remarks['Remarks']) == 'PASSED')					
				{					
					$curriculum_template[$ctr]['Remarks'] = 'TAKEN';
					$curriculum_template[$ctr]['Message'] = 'TAKEN';
				}
				else if(strtoupper($remarks['Remarks']) == 'INC' || strtoupper($remarks['Remarks']) == 'INCOMPLETE')
				{

					if ( ! empty($remarks['nametable'])) 
					{
						if (empty($row['PreRequisiteCourseCode'])) 
						{
							// non-pre-requisite (within 1 year after incurred)
						}
						else
						{
							// with pre-requisite (within the semester after incurred)
						}
					}

					$curriculum_template[$ctr]['Remarks'] = 'INC';				
					$curriculum_template[$ctr]['Message'] = 'INC';
					if ($remarks['IsCompleted'] == '1') 
					{
						$curriculum_template[$ctr]['Remarks'] = 'TAKEN';				
						$curriculum_template[$ctr]['Message'] = 'TAKEN';
					}


				}

				else if(in_array(strtoupper($remarks['Remarks']), $filter_remarks) || empty($remarks['Remarks']))
				{	
					
					if(!empty($row['PreRequisiteCourseCode']))
					{	
						$is_passed = TRUE;	
						foreach($pre_requisite as $pr)
						{
							// $is_passed_pre = $this->db->select('Remarks')->where('CourseId',$pr)->where('StudNo',$student_id)->where('is_actived', 1)->get('tblstudgrade')->result_array();

							$this->db->where_in('Remarks', array_merge($passed_remarks, array('INC', 'INCOMPLETE', 'Incomplete')));
							$is_passed_pre = $this->db->select('Remarks')->where(array('StudNo'=>$student_id, 
								'CourseId' => $pr,
								'is_actived' => 1,
								'IsLapsed' => 0,
								))->get('tblstudgrade')->result_array();
							
							if(count($is_passed_pre) > 0)
							{						
								foreach($is_passed_pre as $pre_req_grade)
								{
									if(in_array(strtoupper($pre_req_grade['Remarks']), $filter_remarks) || empty($pre_req_grade['Remarks']))
									{									
										$is_passed = FALSE;						
									}								
								}
							}
							else
							{
								$is_passed = FALSE;
							}

							if(!$is_passed)
							{
								$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
								$curriculum_template[$ctr]['Message'] = 'YOU HAVE NOT TAKEN/PASSED THE PRE-REQUISITES.';		

								// HOSPITAL PHARMACY INTERSHIP
								if ($row['CourseId'] == '1384') 
								{
									// PH CARE 3
									$param = array(
										'IsLapsed' => 0,
										'is_actived' => 1, 
										'StudNo' => $student_id, 
										'CourseId' => '1938', 
										'Remarks' => 'FAILED');
									$grade = $this->db->where($param)->get('tblstudgrade')->row_array();
									if ( ! empty($grade)) 
									{
										$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
										$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
									}
								}
								// MANUFACTURING PHARMACY INTERSHIP
								else if ($row['CourseId'] == '1385') 
								{
									// PH CARE 3
									$param = array(
										'IsLapsed' => 0,
										'is_actived' => 1, 
										'StudNo' => $student_id,
										'CourseId' => '1383',
										'Remarks' => 'FAILED');
									$grade = $this->db->where($param)->get('tblstudgrade')->num_rows();
									if ($grade > 0) 
									{
										$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
										$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
									}
								}
								

							}
							else
							{								
								$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
								
								$sched_exists_e = 0;
								
								if(!empty($row['EquivalentCourse']))
								{
									$equiv_id = explode(',',$row['EquivalentCourse']);															
									foreach($equiv_id as $e_id)
									{
										$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
									}
								}
								if($sched_exists > 0 || $sched_exists_e > 0)
								{
									$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
									$course_id = array();
									foreach($selected_sched as $ceq)
									{
										$course_id[] = $ceq['CourseId'];
										if(!empty($ceq['EquivalentCourse']))
										{
											$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
											foreach($equiv_id_ceq as $eic)
											{
												$course_id[] = $eic;
											}
											
										}
									}	
									
									$in_equiv_course = FALSE;

									if(!empty($row['EquivalentCourse']))
									{
										$eq_c = explode(',',$row['EquivalentCourse']);
										foreach($eq_c as $row1)
										{
												if(in_array($row1,$course_id))
												{
													$in_equiv_course = TRUE;
												}
										}
									}

																		
									if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
									{
										
										$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
									}
									else
									{										
										$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
									}										
									
												
								}
								else
								{
									$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
									$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
								}

								
							}	


						}	# end for loop
					}
					else
					{
							$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
								
								$sched_exists_e = 0;
								
								if(!empty($row['EquivalentCourse']))
								{
									$equiv_id = explode(',',$row['EquivalentCourse']);															
									foreach($equiv_id as $e_id)
									{
										$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
									}
								}
								if($sched_exists > 0 || $sched_exists_e > 0)
								{
									$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
									$course_id = array();
									foreach($selected_sched as $ceq)
									{
										$course_id[] = $ceq['CourseId'];
										if(!empty($ceq['EquivalentCourse']))
										{
											$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
											foreach($equiv_id_ceq as $eic)
											{
												$course_id[] = $eic;
											}
											
										}
									}	
																					
									$in_equiv_course = FALSE;

									if(!empty($row['EquivalentCourse']))
									{
										$eq_c = explode(',',$row['EquivalentCourse']);
										foreach($eq_c as $row1)
										{
												if(in_array($row1,$course_id))
												{
													$in_equiv_course = TRUE;
												}
										}
									}

									if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
									{
										
										$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
									}
									else
									{										
										$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
									}										
									
												
								}
								else
								{
									$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
									$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
								}
					}
					
				}
				else if(strtoupper($remarks['Remarks']) == 'NOT TAKEN')
					{

						// if (substr($student_id, 0, 1) == "K" || substr($student_id, 0, 1) == "A")
						if ($_SESSION['student_info']['LengthOfStayBySem'] == 1)
						{
							// var_dump($_SESSION['student_curriculum']);
							if(($length_of_stay >= $row['LengthOfStayBySem']) || ($_SESSION['student_curriculum']['CollegeId'] == 11 && $_SESSION['student_curriculum']['Controlled'] == 1))
							{

								if(!empty($row['PreRequisiteCourseCode']))
								{			
									$is_passed = TRUE;							
									foreach($pre_requisite as $pr)
									{
										$pre_req = $this->db->where('CourseId', $pr)->get('tblcourse')->row_array();
										if ( ! empty($pre_req['EquivalentCourse']))
										{
											$EquivalentCourse = $pr . ',' . $pre_req['EquivalentCourse'];
											$this->db->where("CourseId IN($EquivalentCourse)", NULL);
										}
										else
										{
											$this->db->where('CourseId', $pr);
										}
										
										// $is_passed_pre = $this->db->select('Remarks')->where('StudNo', $student_id)->where('is_actived', 1)->get('tblstudgrade');

										$this->db->where_in('Remarks', array_merge($passed_remarks, array('INC', 'INCOMPLETE', 'Incomplete')));
										$is_passed_pre = $this->db->select('Remarks')->where(array('StudNo'=>$student_id, 
											'is_actived' => 1,
											'IsLapsed' => 0,
											))->get('tblstudgrade');

										if($is_passed_pre->num_rows() > 0)
										{										
											foreach($is_passed_pre->result_array() as $pre_req_grade)
											{
												if(in_array(strtoupper($pre_req_grade['Remarks']), $filter_remarks) || empty($pre_req_grade['Remarks']))
												{									
													$is_passed = FALSE;						
												}								
											}
										}
										else
										{
											$is_passed = FALSE;
										}	
									
									}
										
										if(!$is_passed)
										{
											$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
											$curriculum_template[$ctr]['Message'] = 'YOU HAVE NOT TAKEN/PASSED THE PRE-REQUISITES..';

											// HOSPITAL PHARMACY INTERSHIP
											if ($row['CourseId'] == '1384') 
											{
												$param = array(
													'IsLapsed' => 0, 
													'is_actived' => 1, 
													'StudNo' => $student_id, 
													'CourseId' => '1938', 
													'Remarks' => 'FAILED');
												
												$grade = $this->db->where($param)->get('tblstudgrade')->row_array();
												if ( ! empty($grade)) 
												{
													$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
													$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
												}
											}
											// MANUFACTURING PHARMACY INTERSHIP
											else if ($row['CourseId'] == '1385') 
											{
												// PH CARE 3
												$param = array(
													'IsLapsed' => 0,
													'is_actived' => 1, 
													'StudNo' => $student_id,
													'CourseId' => '1383',
													'Remarks' => 'FAILED');
												$grade = $this->db->where($param)->get('tblstudgrade')->num_rows();
												if ($grade > 0) 
												{
													$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
													$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
												}
											}
											

										}
										else
										{								
											$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
									
											$sched_exists_e = 0;
									
											if(!empty($row['EquivalentCourse']))
											{
												$equiv_id = explode(',',$row['EquivalentCourse']);															
												foreach($equiv_id as $e_id)
												{
													$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
												}
											}
											if($sched_exists > 0 || $sched_exists_e > 0)
											{
												$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
												$course_id = array();
												foreach($selected_sched as $ceq)
												{
													$course_id[] = $ceq['CourseId'];
													if(!empty($ceq['EquivalentCourse']))
													{
														$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
														foreach($equiv_id_ceq as $eic)
														{
															$course_id[] = $eic;
														}
														
													}
												}	
												
																					
												$in_equiv_course = FALSE;

												if(!empty($row['EquivalentCourse']))
												{
													$eq_c = explode(',',$row['EquivalentCourse']);
													
													foreach($eq_c as $row1)
													{
															if(in_array($row1,$course_id))
															{
																$in_equiv_course = TRUE;
															}
													}
												}

																					
												if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
												{
													
													$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
													$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
												}
												else
												{										
													$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
													$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
												}										
												
															
											}
											else
											{
												$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
												$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
											}
									
										}	
									
								}
								else
								{
									$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
									
									$sched_exists_e = 0;
									
									if(!empty($row['EquivalentCourse']))
									{
										$equiv_id = explode(',',$row['EquivalentCourse']);															
										foreach($equiv_id as $e_id)
										{
											$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
										}
									}
									if($sched_exists > 0 || $sched_exists_e > 0)
									{
										$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
										$course_id = array();
										foreach($selected_sched as $ceq)
										{
											$course_id[] = $ceq['CourseId'];
											if(!empty($ceq['EquivalentCourse']))
											{
												$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
												foreach($equiv_id_ceq as $eic)
												{
													$course_id[] = $eic;
												}
												
											}
										}	
										
																			
										$in_equiv_course = FALSE;

										if(!empty($row['EquivalentCourse']))
										{
											$eq_c = explode(',',$row['EquivalentCourse']);
											foreach($eq_c as $row1)
											{
													if(in_array($row1,$course_id))
													{
														$in_equiv_course = TRUE;
													}
											}
										}

																			
										if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
										{
											
											$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
											$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
										}
										else
										{										
											$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
											$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
										}										
										
													
									}
									else
									{
										$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
									}
								}			
							
							}
							else 
							{
								$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';
								$curriculum_template[$ctr]['Message'] = 'LENGTH OF STAY';
							}
						}
						else 
						{
						/* COLLEGE STUDENT FILTER BY LengthOfStayBySem */
						// if($length_of_stay >= $row['LengthOfStayBySem'])
						// {
							if(!empty($row['PreRequisiteCourseCode']))
							{			
								$is_passed = TRUE;

								foreach($pre_requisite as $pr)
								{
									$pre_req = $this->db->where('CourseId', $pr)->get('tblcourse')->row_array();
									if ( ! empty($pre_req['EquivalentCourse']))
									{
										$EquivalentCourse = $pr . ',' . $pre_req['EquivalentCourse'];
										$this->db->where("CourseId IN($EquivalentCourse)", NULL);
									}
									else
									{
										$this->db->where('CourseId', $pr);
									}
									
									// $is_passed_pre = $this->db->select('Remarks')->where('StudNo', $student_id)->where('is_actived', 1)->get('tblstudgrade');
									
									$this->db->where_in('Remarks', array_merge($passed_remarks, array('INC', 'INCOMPLETE', 'Incomplete')));
									$is_passed_pre = $this->db->select('Remarks')->where(array(
										'StudNo' => $student_id, 
										'is_actived' => 1, 
										'IsLapsed' => 0))->get('tblstudgrade');

									if($is_passed_pre->num_rows() > 0)
									{
										foreach($is_passed_pre->result_array() as $pre_req_grade)
										{
											if(in_array(strtoupper($pre_req_grade['Remarks']), $filter_remarks) || empty($pre_req_grade['Remarks']))
											{
												$is_passed = FALSE;
											}								
										}
									}
									else
									{
										$is_passed = FALSE;
									}	
								
								}
									
									if(!$is_passed)
									{
										$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'YOU HAVE NOT TAKEN/PASSED THE PRE-REQUISITES...';

										// HOSPITAL PHARMACY INTERSHIP
										if ($row['CourseId'] == '1384') 
										{
											// PH CARE 3
											$param = array(
												'IsLapsed' => 0,
												'is_actived' => 1, 
												'StudNo' => $student_id, 
												'CourseId' => '1938', 
												'Remarks' => 'FAILED');
											
											$grade = $this->db->where($param)->get('tblstudgrade')->row_array();
											if ( ! empty($grade)) 
											{
												$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
												$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
											}
										}
										// MANUFACTURING PHARMACY INTERSHIP
										else if ($row['CourseId'] == '1385') 
										{
											// PH CARE 3
											$param = array(
												'IsLapsed' => 0,
												'is_actived' => 1, 
												'StudNo' => $student_id,
												'CourseId' => '1383',
												'Remarks' => 'FAILED');
											$grade = $this->db->where($param)->get('tblstudgrade')->num_rows();
											if ($grade > 0) 
											{
												$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';
												$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';		
											}
										}
										

									}
									else
									{
										$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
										$sched_exists_e = 0;
								
										if(!empty($row['EquivalentCourse']))
										{
											$equiv_id = explode(',',$row['EquivalentCourse']);															
											foreach($equiv_id as $e_id)
											{
												// $this->first_yr_sechedule_restriction();
												$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
												// dump($this->db->last_query());
											}
										}
										// dump($sched_exists);
										// dump($sched_exists_e);
										if($sched_exists > 0 || $sched_exists_e > 0)
										{
											$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
											$course_id = array();
											foreach($selected_sched as $ceq)
											{
												$course_id[] = $ceq['CourseId'];
												if(!empty($ceq['EquivalentCourse']))
												{
													$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
													foreach($equiv_id_ceq as $eic)
													{
														$course_id[] = $eic;
													}
													
												}
											}	
											
																				
											$in_equiv_course = FALSE;

											if(!empty($row['EquivalentCourse']))
											{
												$eq_c = explode(',',$row['EquivalentCourse']);
												
												foreach($eq_c as $row1)
												{
														if(in_array($row1,$course_id))
														{
															$in_equiv_course = TRUE;
														}
												}
											}

																				
											if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
											{
												
												$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
												$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
											}
											else
											{										
												$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
												$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
											}										
											
														
										}
										else
										{
											$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
											$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
										}
								
									}	
								
							}
							else
							{
								$sched_exists = $this->db->where('subject_id',$row['CourseId'])->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();
								
								$sched_exists_e = 0;

								if(!empty($row['EquivalentCourse']))
								{
									$equiv_id = explode(',',$row['EquivalentCourse']);															
									foreach($equiv_id as $e_id)
									{
										$sched_exists_e += $this->db->where('subject_id',$e_id)->where('SyId',$sy_id)->where('SemId',$sem_id)->get('tblsched')->num_rows();		
									}
								}
								if($sched_exists > 0 || $sched_exists_e > 0)
								{
									$selected_sched = $this->get_selected_schedule($student_id,$sy_id,$sem_id);
									$course_id = array();
									foreach($selected_sched as $ceq)
									{
										$course_id[] = $ceq['CourseId'];
										if(!empty($ceq['EquivalentCourse']))
										{
											$equiv_id_ceq = explode(',',$ceq['EquivalentCourse']);
											foreach($equiv_id_ceq as $eic)
											{
												$course_id[] = $eic;
											}
											
										}
									}	
									
																		
									$in_equiv_course = FALSE;

									if(!empty($row['EquivalentCourse']))
									{
										$eq_c = explode(',',$row['EquivalentCourse']);
										foreach($eq_c as $row1)
										{
												if(in_array($row1,$course_id))
												{
													$in_equiv_course = TRUE;
												}
										}
									}

																		
									if(in_array($row['CourseId'],$course_id) || $in_equiv_course)
									{
										
										$curriculum_template[$ctr]['Remarks'] = 'ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'ENROLLED';	
									}
									else
									{										
										$curriculum_template[$ctr]['Remarks'] = 'CAN BE ENROLLED';						
										$curriculum_template[$ctr]['Message'] = 'CAN BE ENROLLED';
									}										
									
												
								}
								else
								{
									$curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';						
									$curriculum_template[$ctr]['Message'] = 'SUBJECT NOT OFFERED FOR THIS SEMESTER. INQUIRE WITH THE REGISTRARS OFFICE FOR OFFERINGS';		
								}
							}			
						// }
						// else 
						// {
							// $curriculum_template[$ctr]['Remarks'] = 'CANNOT BE ENROLLED';
							// $curriculum_template[$ctr]['Message'] = 'LENGTH OF STAY';
						// }
							
						}

					}																											
				$ctr++;	
			}					        	
		}        	
		return $curriculum_template;

	}

	function get_block_section_schedule($sy_id,$sem_id,$curriculum_id,$length_of_stay_by_sem,$student_id,$program_id,$college_id,$major_id)
    {    	        
        
        if ($college_id != 21) 
	    {
	        $this->db->where('CurriculumId',$curriculum_id)
	        ->where('LengthOfStayBySem',$length_of_stay_by_sem)                        
			->join('tblcourse as B','A.CourseId = B.CourseId','left');              
	    }
	    else
	    {
	    	$this->db->where('CurriculumId',$curriculum_id)
			->join('tblcourse as B','A.CourseId = B.CourseId','left');  
	    }
		              
        $query = $this->db->get('tblcurriculumdetails as A');
        
        $curriculum_block = array();
        $ctr=0;
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $curriculum_block[$ctr]['CourseId'] = $row['CourseId'];                
                $curriculum_block[$ctr]['PreRequisites'] = $row['PreRequisiteCourseCode'];   

                if ( ! empty($row['EquivalentCourse'])) 
                {
                	$EquivalentCourse = $row['CourseId'] . ',' . $row['EquivalentCourse'];
                	$this->db->where("CourseId IN($EquivalentCourse)", NULL);
                }
                else
                {
                	$this->db->where('CourseId', $row['CourseId']);
                }

                $this->db->where(array('StudNo' => $student_id, 'is_actived' => 1, 'IsLapsed' => 0));
                $this->db->where_in('Remarks', array('PASSED', 'INC', 'INCOMPLETE'));
                $grade = $this->db->get('tblstudgrade')->row_array();

                if(!empty($grade))
                {
                	if(in_array(strtoupper($grade['Remarks']), array('PASSED', 'INC', 'INCOMPLETE')))
          			$curriculum_block[$ctr]['GradeRemarks'] = 'TAKEN';   
          			else
          			$curriculum_block[$ctr]['GradeRemarks'] = 'NOT TAKEN';
                }
                else
                {
					$curriculum_block[$ctr]['GradeRemarks'] = 'NOT TAKEN';                   	
                }

                $curriculum_block[$ctr]['Remarks'] = 'CAN BE ENROLL';

                if(!empty($row['PreRequisiteCourseCode']))
                {
                	$pre_req_grade = explode(',',$row['PreRequisiteCourseCode']);
                	foreach($pre_req_grade as $pre_rg)
                	{
                		$pre_req = $this->db->where('CourseId', $pre_rg)->get('tblcourse')->row_array();
                		$pr_eq_c = explode(',', $pre_req['EquivalentCourse']);
                		
            			if ( ! in_array($pre_rg, $pr_eq_c)) 
        				$pr_eq_c[] = $pre_rg;

        				$pr_eq_c = array_filter($pr_eq_c, function($v) { return $v !== ''; });  // remove "" value

            			$this->db->where_in('CourseId', $pr_eq_c);
                		$this->db->where(array('StudNo' => $student_id, 'is_actived' => 1, 'IsLapsed' => 0));	
                		$this->db->where_in('Remarks', array('PASSED', 'INC', 'INCOMPLETE'));
                		$grade = $this->db->get('tblstudgrade');
                		if($grade->num_rows() > 0)
                		{
                			foreach($grade->result_array() as $remarks)
                			{
                				if(strtoupper($remarks['Remarks']) == 'FAILED' || empty($remarks['Remarks']))
                				{
                					$curriculum_block[$ctr]['Remarks'] = 'CANNOT BE ENROLL';
                				}
                				else if(in_array(strtoupper($remarks['Remarks']), array('PASSED', 'INC', 'INCOMPLETE')))
                				{
                					$curriculum_block[$ctr]['Remarks'] = 'CAN BE ENROLL';	
                				}
                			}
                		}
                		else
                		{
                			$curriculum_block[$ctr]['Remarks'] = 'CANNOT BE ENROLL';
                			break;
                		}
                	}	
            		// dump($curriculum_block);
            	}
                $ctr++;
            }
        }
       	
        $ctr=0;
        $tobeenrolled = array();
        foreach($curriculum_block as $row1)
        {
        	if($row1['Remarks'] == 'CAN BE ENROLL' && $row1['GradeRemarks'] == 'NOT TAKEN')
        	{
        		$tobeenrolled[$ctr]['CourseId'] = $row1['CourseId'];                   
        		$ctr++;
        	}
        	
        }	

        $this->db->distinct();
        $this->db->select('year_section');
        if($curriculum_id == 25) // Accountancy Section
        {        	
        	$this->db->like('year_section', 'V-', 'after'); 
        } 
        else
        {        	
	    	$year_level = self::get_year_level($curriculum_id, $college_id, $length_of_stay_by_sem);
        // if($length_of_stay_by_sem == 1 || $length_of_stay_by_sem == 2)
        // $this->db->like('year_section', 'I-','after');
        // if($length_of_stay_by_sem == 3 || $length_of_stay_by_sem == 4)
        // $this->db->like('year_section', 'II-','after');
        // if($length_of_stay_by_sem == 5 || $length_of_stay_by_sem == 6)
        // $this->db->like('year_section', 'III-','after');
        // if($length_of_stay_by_sem == 7 || $length_of_stay_by_sem == 8)
        // $this->db->like('year_section', 'IV-');
        // if($length_of_stay_by_sem == 9 || $length_of_stay_by_sem == 10)
        // $this->db->like('year_section', 'V-');

        	if ($year_level == 'First Year') 		$level = 'I-';
        	elseif ($year_level == 'Second Year') 	$level = 'II-';
        	elseif ($year_level == 'Third Year') 	$level = 'III-';
        	elseif ($year_level == 'Fourth Year') 	$level = 'IV-';
        	elseif ($year_level == 'Fifth Year') 	$level = 'V-';
        	else    $level = '';
        	
        	if ($college_id != 21) 
	        $this->db->like('year_section', $level, 'after');
        }       
        $this->db->where('ProgramId',$program_id);
        $this->db->where('CollegeId',$college_id);
        $this->db->where('MajorId',$major_id);
        $this->db->where('SyId',$sy_id);
        $this->db->where('SemId',$sem_id);        
        $block_sched = $this->db->get('tblsched as A');             

        if($block_sched->num_rows() > 0)
        {
            $ctr=0;
            foreach($block_sched->result_array() as $row)
            {
                foreach($tobeenrolled as $row2)
                {
                    $this->db->select('A.*,C.*,(SELECT COUNT(*) FROM tblstudentschedule as C WHERE C.Cfn = A.cfn AND IsActive = 1 ) AS ClassSize');
                    $this->db->where('A.SyId',$sy_id);
                    $this->db->where('A.SemId',$sem_id);
                    $this->db->where('subject_id',$row2['CourseId']);                    
                    $this->db->where('year_section',$row['year_section'])                    
                    ->join('tblcourse as C','A.subject_id = C.CourseId','left');
                    
                    $query = $this->db->get('tblsched as A');

		    	
                    if($query->num_rows() > 0)
                    {
                        $row3[$ctr][] = $query->result_array();
                    }
                }
                $ctr++;
            }
        }
		if(!empty($row3))                
        return $row3;
	}	


	function get_max_units($curriculum_id,$length_of_stay_by_sem)
    {                
        $total_units = 0;
        $query = $this->db->where('CurriculumId',$curriculum_id)
        ->where('LengthOfStayBySem',$length_of_stay_by_sem)
        ->join('tblcourse as B','A.CourseId = B.CourseId')
        ->get('tblcurriculumdetails as A');        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $total_units += $row['Units'];
            }
        }

        return $total_units;
    }

    function get_allowed_overload_units($curriculum_id, $length_of_stay_by_sem)
    {    	
    	$this->db->where('CurriculumId', $curriculum_id)->where('LengthOfStayBySem', $length_of_stay_by_sem);
    	$query = $this->db->get('tblallowedoverloadunits');
    	
    	return $query->row_array();
    }

    function get_enrollment_trans($sy_id,$sem_id,$student_id)
    {
        $this->db->where('SyId',$sy_id);
        $this->db->where('SemId',$sem_id);
        $this->db->where('StudNo',$student_id);
        $query = $this->db->get('tblenrollmenttrans');
        $row = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
        }
        $this->db->close();
        return $row;
    }

	function add_enrollment_trans($sy_id,$sem_id,$student_id)
    {

        $this->load->helper('date');
        $timestamp = now();
        $timezone = 'UP8';
        $date_now = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone)); 
        // $data = array('SyId'=>$sy_id,'SemId'=>$sem_id,'StudNo'=>$student_id,'EncodedDateTimeStart'=>$date_now);
        // $this->db->insert('tblenrollmenttrans',$data);
    	$this->db->query("INSERT INTO tblenrollmenttrans (SyId, SemId, StudNo, EncodedDateTimeStart) 
			SELECT ?, ?, StudNo, ? FROM tblstudinfo WHERE StudNo = ? AND NOT EXISTS(SELECT 1 FROM tblenrollmenttrans 
																		WHERE SyId = ? AND SemId = ? AND StudNo = ? LIMIT 1
								    		    					) LIMIT 1", 
    							[$sy_id, $sem_id, $date_now, $student_id, $sy_id, $sem_id, $student_id]);

    	// $qry = $this->db->last_query();
    	return $this->db->affected_rows();

    	// self::set_student_logs($student_id, $qry);
    }

    function update_enrollment_trans($enrollment_trans,$edte,$adts)
    {
        // $this->load->helper('date');
        // $timestamp = now();
        // $timezone = 'UP8';
        // $date_now = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone)); 

    	$date_now = date('Y-m-d H:i:s');

        if($edte)
        {
            $data = array('EncodedDateTimeEnd'=>$date_now,'IsEncoded'=>'1');
        }
        
        if($adts)
        {
            $data = array('AssessedDateTime'=>$date_now, 'IsAssessed'=>'1');
        }
        
        $this->db->where('Id', $enrollment_trans);
        $this->db->update('tblenrollmenttrans',$data);

        $this->set_initial_sched();
    }

    function set_initial_sched()
    {
        $studno = $_SESSION['student_info']['StudNo'];
        $SyId = $_SESSION['sy_sem']['SyId'];
        $SemId = $_SESSION['sy_sem']['SemId'];

        $condition = array(
        	'StudNo' => $studno,
        	'SyId' => $SyId,
        	'SemId' => $SemId,
        	'IsActive' => 1,
	    	);

        if ( ! empty($studno) && ! empty($SyId) && ! empty($SemId)) 
        $this->db->where($condition)->update('tblstudentschedule', array('IsInitial' => 1));
    }

    function reset_enrollment_trans($enrollment_trans)
    {
        
        $data = array('EncodedDateTimeEnd'=>'0000-00-00','IsEncoded'=>'0','AssessedDateTime'=>'0000-00-00','IsAssessed'=>'0','IsDeactivated'=>'0');
        
        $this->db->where('Id',$enrollment_trans);
        $this->db->update('tblenrollmenttrans',$data);
    }
	
	function update_logged_in($student_id)
    {
    	$this->load->helper('date');
        $timestamp = now();
        $timezone = 'UP8';
        $last_logged = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone)); 
        $data = array('LastLoggedIn' => $last_logged, 'IsLoggedIn' => '1');
        $this->db->where('StudNo',$student_id);
        $this->db->update('tblstudentaccount',$data);
    }

    public function update_logged_in2()
    {
    	// $last_five_mins = date('Y-m-d H:i:s', strtotime('-5 minutes', $timestamp));
    	// $this->db->where('LastLoggedIn <=', $last_five_mins);
    	// $this->db->where('IsLoggedIn', 1)->update('tblstudentaccount', ['IsLoggedIn' => 0]);
    	$sql = "UPDATE tblstudentaccount SET IsLoggedIn = 0 WHERE LastLoggedIn <= NOW() - INTERVAL 15 MINUTE";
    	$this->db->query($sql);
    }

    function update_logged_out($student_id)
    {
    	// Pre enrollment
        $now = date('Y-m-d');
        if ($now < '2017-05-02') 
        {
        	$SyId = $_SESSION['sy_sem']['SyId'];
        	$SemId = $_SESSION['sy_sem']['SemId'];

        	$this->db->where(['StudNo' => $student_id, 'SyId' => $SyId, 'SemId' => $SemId, 'IsActive' => 1]);
        	$load = $this->db->get('tblstudentschedule');
        	if ($load->num_rows()) 
        	{
	        	$this->db->where('StudNo', $student_id)->limit(1)->update('tblstudinfo', ['PreEnrolled'=>1]);
	        	self::set_student_logs($student_id, 'Pre-enrollment');
        	}
        	
        }

        $data = array('IsLoggedIn' => '0');
        $this->db->where('StudNo',$student_id);
        $this->db->update('tblstudentaccount',$data);

    }


    function update_cor_trans($enrollment_trans)
    {
        $this->load->helper('date');
        $timezone = "Asia/Hong_Kong";
        if(function_exists('date_default_timezone_set'))
        date_default_timezone_set($timezone);
        $date_now = date('Y-m-d H:i:s');

        $data = array('DatePrint'=>$date_now,'IsPrinted'=>'1');
        
        $this->db->where('Id',$enrollment_trans);
        $this->db->update('tblenrollmenttrans',$data);
    }


    function set_user_logs($logs)    
    {
        $this->load->helper('date');
        $timestamp = now();
        $timezone = 'UP8';
        $date_t = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));
        $data = array('student_id' => $_SESSION['student_info']['StudNo'], 'action' => $logs,'date_logged' => $date_t);
        $this->db->insert('tblenrollmentuserlogs',$data);    
    }

    public function set_student_logs($student_id, $logs)
    {
    	$this->load->helper('date');
    	$timestamp = now();
    	$timezone = 'UP8';
    	$date_t = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));
    	$data = array('student_id' => $student_id, 'action' => $logs,'date_logged' => $date_t);
    	$this->db->insert('tblenrollmentuserlogs', $data);
    }
    
    
    function update_enrollment_payment($student_id, $sem_id, $sy_id)
    {
    	$condition = array(
    			'StudNo' => $student_id,
    			'SemId' => $sem_id,
    			'SyId' => $sy_id,
    		);

    	$curriculum = $this->get_student_curriculum($student_id);

    	if ($curriculum['CollegeId'] == 6) 
    	{
	    	$token_fee = $this->db->where($condition)->get('tblpayment_coahs')->result_array();
    	}
    	else
    	{
	    	$token_fee = $this->db->where($condition)->get('tblpayment')->result_array();
    	}

    	$scholarship = $this->db->where($condition)->get('tblstudentscholar')->row_array();
    	$misc_fee = $this->db->where($condition)->get('tblpaymentmisc')->result_array();

    	$affected_rows = 0;

    	if (count($scholarship)) 
    	{
    		if (count($misc_fee)) 
    			$affected_rows = $this->_set_enrollment_payment($student_id, $sem_id, $sy_id, 1);
    		else
    			$affected_rows = $this->_set_enrollment_payment($student_id, $sem_id, $sy_id, 0);
    	}
    	else
    	{
    		if (count($misc_fee) && count($token_fee)) 
    			$affected_rows = $this->_set_enrollment_payment($student_id, $sem_id, $sy_id, 1);
    		else
    			$affected_rows = $this->_set_enrollment_payment($student_id, $sem_id, $sy_id, 0);
    	}

    	return $affected_rows;
    }

    private function _set_enrollment_payment($student_id, $sem_id, $sy_id, $IsPaid = 0)
    {
    	$condition = array(
    			'StudNo' => $student_id,
    			'SemId' => $sem_id,
    			'SyId' => $sy_id,
    		);

    	$data['IsPaid'] = $IsPaid;

    	$this->db->limit(1);
    	$this->db->where($condition);
    	$this->db->update('tblenrollmenttrans', $data);

    	return $this->db->affected_rows();
    }

    function add_student_losby($student_id, $sy_id, $sem_id)
    {
    	$promotion = 1;
    	$this->db->where(['StudNo'=>$student_id]);
    	$student_curriculum = $this->db->get('tblstudcurriculum')->row();
    	
    	if (empty($student_curriculum)) 
		return FALSE;

		if (in_array($student_curriculum->CurriculumId, [184, 181, 179, 182,144])) 
		{
			$this->db->where('StudNo', $student_id);
			$student = $this->db->get('tblstudinfo')->row();
			if ($student_curriculum->CurriculumId == 144 && $student->LengthOfStayBySem == 2) 
			{
				// for those student who have summer in thier curriculum but without offered schedule
				$promotion++; 
			}
			else
			{
				if (in_array($student->LengthOfStayBySem, [2,4,6])) 
				{
					// for those student who have summer in thier curriculum but without offered schedule
					$promotion++; 
				}
			}
		}


    	$this->db->query("UPDATE tblstudinfo 
							SET LengthOfStayBySem = (LengthOfStayBySem+$promotion) 
							WHERE StudNo = ? AND EXISTS(SELECT 1 FROM tblenrollmenttrans WHERE SyId = ? AND SemId = ? AND StudNo = ? AND IsPromoted != 1) LIMIT 1", 
								[$student_id, $sy_id, $sem_id, $student_id]);
    	// $qry = $this->db->last_query();
    	return $this->db->affected_rows();

    	// self::set_student_logs($student_id, $qry);
    	// return $val;
    }

    public function promote_student($student_id, $sy_id, $sem_id)
    {
    	$this->db->query("UPDATE tblenrollmenttrans SET IsPromoted = 1 WHERE SyId = ? AND SemId = ? AND StudNo = ? LIMIT 1", 
    					[$sy_id, $sem_id, $student_id]);
    	// $qry = $this->db->last_query();
    	return $this->db->affected_rows();

    	// self::set_student_logs($student_id, $qry);
    	// return $val;
    }

    public function update_advising_slip($SyId, $SemId, $student_id)
    {
    	if ( ! empty($student_id)) 
    	{
	    	$this->db->where(['SyId' => $SyId, 'SemId' => $SemId, 'StudNo' => $student_id]);
	    	$this->db->limit(1)->update('tblenrollmenttrans', 
											[
												'IsPrintedAdvisingSlip' => 1, 
												'DatePrintAdvisingSlip' => date('Y-m-d H:i:s')
											]);
	    	return $this->db->affected_rows();
    	}

    	return FALSE;
    }

    public function get_email($student_id)
    {
    	$this->db->where('StudNo', $student_id);
    	return $this->db->get(DBFE . 'tblstudemailaccount')->row();
    }

    public function set_email($student_id)
    {
    	$this->db->where('StudNo', $student_id);
    	$student = $this->db->get('tblstudinfo')->row();

    	if (count($student)) 
    	{
    		$replace_arr = array(". "," ",",JR","JR.","JR");
    		$password = strtoupper(random_string('alnum', 10));
    		$email = strtolower(substr($student->Fname,0,1).str_replace($replace_arr,"",$student->Lname)).".".strtolower($student->StudNo).'@umak.edu.ph';
    		$email = str_replace(['Ñ', 'ñ'], 'n', $email);
    		$this->db->query("SET NAMES 'utf8'");
			$this->db->query("SET CHARACTER SET 'utf8'");
    		$this->db->query("INSERT INTO " . DBFE . "tblstudemailaccount (StudNo, email, Firstname, Lastname, Password)
    			SELECT StudNo, ?, Fname, Lname, ? FROM tblstudinfo WHERE StudNo = ? AND 
    				! EXISTS(SELECT 1 FROM " . DBFE . "tblstudemailaccount WHERE StudNo = ?) LIMIT 1",
    				[$email, $password, $student_id, $student_id]);
    		// $qry = $this->db->last_query();
    		// self::set_student_logs($student_id, $qry);
    		self::set_student_logs($student_id, 'Student UMak Email Account Created');

    	}

    	return self::get_email($student_id);
    }
	    		
}

/* End of file m_enroll.php */
/* Location: ./application/models/m_enroll.php */
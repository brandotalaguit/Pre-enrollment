<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_addsched extends CI_Model{
		
	function __construct()
	{
		parent::__construct();		
	}


	public function array_unique_key_group($array) 
	{
		if(!is_array($array))
		    return false;

		// $temp = array_unique($array,SORT_NUMERIC);
		$temp = array_unique($array);
		foreach($array as $key => $val) {
		    $i = array_search($val,$temp);
		    if(!empty($i) && $key != $i) {
		        $temp[$i.','.$key] = $temp[$i];
		        unset($temp[$i]);
		    }
		}
		return $temp;
	}

	public function get_second_time($cfn = NULL)
	{
			if ($cfn == NULL) 
				return false;

			$this->db->where('cfn',$cfn)
                 ->where('IsSecondTime',1)
                 ->where('is_actived',1);                 
        	$SecondTime = $this->db->get('tbladdsched')->result_array();

        	$time_arr =array();
        	$day_arr =array();
        	$room_arr =array();

        	foreach ($SecondTime as $keys => $subject) 
        	{
        		$sched=array();

        		if($subject['time_start_mon'] != '00:00:00' && $subject['time_end_mon'] != '00:00:00') 	
        		{				 
					$mon = array('M/'. $subject['room_id_mon'] => date('h:i A',strtotime($subject['time_start_mon'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_mon'])));
					$sched = array_merge($sched,$mon);
				}

				if($subject['time_start_tue'] != '00:00:00' && $subject['time_end_tue'] != '00:00:00') 
				{
						$tue = array('T/'. $subject['room_id_tue'] => date('h:i A',strtotime($subject['time_start_tue'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_tue'])));
						$sched = array_merge($sched,$tue);						
				}  

				if($subject['time_start_wed'] != '00:00:00' && $subject['time_end_wed'] != '00:00:00') 
				{
						$wed = array('W/'. $subject['room_id_wed'] => date('h:i A',strtotime($subject['time_start_wed'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_wed'])));
						$sched = array_merge($sched,$wed); 
				}

				if($subject['time_start_thu'] != '00:00:00' && $subject['time_end_thu'] != '00:00:00') 
				{
						$thu = array('TH/'. $subject['room_id_thu'] => date('h:i A',strtotime($subject['time_start_thu'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_thu'])));
						$sched = array_merge($sched,$thu); 
				}

				if($subject['time_start_fri'] != '00:00:00' && $subject['time_end_fri'] != '00:00:00') 
				{
						$fri = array('F/'. $subject['room_id_fri'] => date('h:i A',strtotime($subject['time_start_fri'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_fri'])));
						$sched = array_merge($sched,$fri); 
				}

				if($subject['time_start_sat'] != '00:00:00' && $subject['time_end_sat'] != '00:00:00') 
				{
					$sat = array('SAT/'. $subject['room_id_sat'] => date('h:i A',strtotime($subject['time_start_sat'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_sat'])));
					$sched = array_merge($sched,$sat); 
				}

				if($subject['time_start_sun'] != '00:00:00' && $subject['time_end_sun'] != '00:00:00') 
				{
						$sun = array('SUN/'. $subject['room_id_sun'] => date('h:i A',strtotime($subject['time_start_sun'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_sun'])));
						$sched = array_merge($sched,$sun); 	
				}

				$sched = $this->array_unique_key_group($sched);

				$ctr = 0;
				$time_c = "";	
				foreach ($sched as $time) 
				{
					if (count($sched) == 1 || count($sched) == $ctr+1) 					
						$time_c .= $time;
					else
						$time_c .= $time . '/';

					$ctr++;
				}
				$time_arr[]	= $time_c;
				$ctrx =1;
				$day_c = '';
				foreach ($sched as $key_t => $time) 
				{
					$days = explode(',',$key_t);
					$max_c =1;

					foreach ($days as $day) 
					{
						$da = explode('/',$day);
						if (count($days) > 1) 
						{
							if(count($days) == $max_c && count($sched) != $ctrx)             
			                   $day_c .= $da[0].'/';          
			                else
			                   $day_c .= $da[0];  
						}

						else
			            {  
			                $day_c .=  $da[0];
			            } 

						$max_c++;
					}

					$ctrx++;
				}   

               $day_arr[]	= $day_c;
               $max_a = 0;

               foreach ($sched as $keys => $time) 
               {
               		$days = explode(',',$keys);
               		$d = array();

               		foreach ($days as $day) 
               		{
               			$da = explode('/',$day); 
                      	array_push($d,$da[1]);
                      	$d = array_unique($d);
               		}

               		$max_d = 0;

               		foreach ($d as $e) 
               		{
               			if (count($sched) == 1 || count($sched) == $max_a+1) 
               			{
               				 if(!$e == 0)
                              {
                                  $broom = $this->db->select('BuildingCode,RoomNum')->join('tblbuilding as B','A.BuildingId = B.BuildingId')->where('RoomId',$e)->get('tblroom as A')->row_array();
                                  $room_arr[] =  $broom['BuildingCode'] . ' ' . $broom['RoomNum'];
                              }
                              
               			}
               			else
               			{
               				 if(!$e == 0)
                              {
                                  $broom = $this->db->select('BuildingCode,RoomNum')->join('tblbuilding as B','A.BuildingId = B.BuildingId')->where('RoomId',$e)->get('tblroom as A')->row_array();
                                  $room_arr[] =  $broom['BuildingCode'] . ' ' . $broom['RoomNum'] .'/';
                              }                              
               			}

               			$max_d++;
               		}

               		$max_a++;
               }
        	}

        	return array('time_c' =>$time_arr , 'day_c' =>$day_arr , 'room_c' =>$room_arr);
        	
	}

	public function validate_conflict($Sem = NULL,$Sy =NULL ,$cfn =NULL,$StudNo =NULL)
	{		
			$msg ="";
			$conflict_cnt = 0;
			$check_tblsched= $this->db->where('B.Cfn',$cfn)
			->get('tblsched as B');
			//---------------------------------------------------------------------------------------------------------------------           	           	           	
           	foreach($check_tblsched->result_array() as $row)
           	{
           		$sql = "SELECT A.*,D.*,E.* FROM tblsched as A  LEFT JOIN tblcourse as D ON D.CourseId = A.subject_id LEFT JOIN tblstudentschedule as E ON E.Cfn = A.cfn WHERE E.StudNo = '".$StudNo."' AND E.IsActive = 1 
           		AND A.SyId = " . $Sy . " AND A.SemId = " .$Sem . " 
				AND (((time_start_mon >= '". $row['time_start_mon'] ."' 
            	AND time_start_mon < '". $row['time_end_mon'] . "'  OR '". $row['time_start_mon'] . "' >= time_start_mon AND '". $row['time_start_mon'] ."' < time_end_mon)) || ((time_start_tue >= '". $row['time_start_tue'] ."' 
            	AND time_start_tue < '". $row['time_end_tue'] . "'  OR '". $row['time_start_tue'] . "' >= time_start_tue AND '". $row['time_start_tue'] ."' < time_end_tue)) || ((time_start_wed >= '". $row['time_start_wed'] ."' 
            	AND time_start_wed < '". $row['time_end_wed'] . "'  OR '". $row['time_start_wed'] . "' >= time_start_wed AND '". $row['time_start_wed'] ."' < time_end_wed)) || ((time_start_thu >= '". $row['time_start_thu'] ."' 
            	AND time_start_thu < '". $row['time_end_thu'] . "'  OR '". $row['time_start_thu'] . "' >= time_start_thu AND '". $row['time_start_thu'] ."' < time_end_thu)) || ((time_start_fri >= '". $row['time_start_fri'] ."' 
            	AND time_start_fri < '". $row['time_end_fri'] . "'  OR '". $row['time_start_fri'] . "' >= time_start_fri AND '". $row['time_start_fri'] ."' < time_end_fri)) || ((time_start_sat >= '". $row['time_start_sat'] ."' 
            	AND time_start_sat < '". $row['time_end_sat'] . "'  OR '". $row['time_start_sat'] . "' >= time_start_sat AND '". $row['time_start_sat'] ."' < time_end_sat)) || ((time_start_sun >= '". $row['time_start_sun'] ."' 
            	AND time_start_sun < '". $row['time_end_sun'] . "'  OR '". $row['time_start_sun'] . "' >= time_start_sun AND '". $row['time_start_sun'] ."' < time_end_sun)))"; 	
				
				$tblsched_result = $this->db->query($sql)->result();	

							
           	}

           	foreach($check_tblsched->result_array() as $row)
           	{
           		$sql = "SELECT A.*,D.*,E.*,F.year_section FROM tbladdsched as A  
           			LEFT JOIN tblsched as F on F.cfn = A.cfn
           			LEFT JOIN tblcourse as D ON D.CourseId = F.subject_id 
           			LEFT JOIN tblstudentschedule as E ON E.Cfn = F.cfn          			
           			WHERE E.StudNo = '".$StudNo."' AND E.IsActive = 1 AND A.is_actived =1 AND A.IsSecondTime =1
           		AND A.SyId = " . $Sy . " AND A.SemId = " .$Sem . " 
				AND (((A.time_start_mon >= '". $row['time_start_mon'] ."' 
            	AND A.time_start_mon < '". $row['time_end_mon'] . "'  OR '". $row['time_start_mon'] . "' >= A.time_start_mon AND '". $row['time_start_mon'] ."' < A.time_end_mon)) || ((A.time_start_tue >= '". $row['time_start_tue'] ."' 
            	AND A.time_start_tue < '". $row['time_end_tue'] . "'  OR '". $row['time_start_tue'] . "' >= A.time_start_tue AND '". $row['time_start_tue'] ."' < A.time_end_tue)) || ((A.time_start_wed >= '". $row['time_start_wed'] ."' 
            	AND A.time_start_wed < '". $row['time_end_wed'] . "'  OR '". $row['time_start_wed'] . "' >= A.time_start_wed AND '". $row['time_start_wed'] ."' < A.time_end_wed)) || ((A.time_start_thu >= '". $row['time_start_thu'] ."' 
            	AND A.time_start_thu < '". $row['time_end_thu'] . "'  OR '". $row['time_start_thu'] . "' >= A.time_start_thu AND '". $row['time_start_thu'] ."' < A.time_end_thu)) || ((A.time_start_fri >= '". $row['time_start_fri'] ."' 
            	AND A.time_start_fri < '". $row['time_end_fri'] . "'  OR '". $row['time_start_fri'] . "' >= A.time_start_fri AND '". $row['time_start_fri'] ."' < A.time_end_fri)) || ((A.time_start_sat >= '". $row['time_start_sat'] ."' 
            	AND A.time_start_sat < '". $row['time_end_sat'] . "'  OR '". $row['time_start_sat'] . "' >= A.time_start_sat AND '". $row['time_start_sat'] ."' < A.time_end_sat)) || ((A.time_start_sun >= '". $row['time_start_sun'] ."' 
            	AND A.time_start_sun < '". $row['time_end_sun'] . "'  OR '". $row['time_start_sun'] . "' >= A.time_start_sun AND '". $row['time_start_sun'] ."' < A.time_end_sun)))"; 	
				
				$tbladdsched_result = $this->db->query($sql)->result();				
           	}

           	if (count($tblsched_result)) 
			{
				foreach ($tblsched_result as $key => $conflict_val) 
				{
					$msg .='<span class="label label-important ">' . $conflict_val->CourseCode . ' - ' . $conflict_val->CourseDesc . ' - ' . $conflict_val->year_section. '3</span><br>';
					$conflict_cnt++;
				}
				
			}

			if (count($tbladdsched_result)) 
			{
				foreach ($tbladdsched_result as $key => $conflict_val) 
				{
					$msg .='<span class="label label-important ">' . $conflict_val->CourseCode . ' - ' . $conflict_val->CourseDesc . ' - ' . $conflict_val->year_section. '4</span><br>';
					$conflict_cnt++;
				}
				
			}

			

           	//--------------------------------------------------------------------------------------------------------------------------

			$check_addtblsched= $this->db->where('B.Cfn',$cfn)->where('B.is_actived',1)->where('B.IsSecondTime',1)
			->get('tbladdsched as B');
			//---------------------------------------------------------------------------------------------------------------------   
			if (($check_addtblsched->num_rows()) > 0) 
			{
					foreach($check_addtblsched->result_array() as $row)
		           	{
		           		$sql = "SELECT A.*,D.*,E.* FROM tblsched as A  LEFT JOIN tblcourse as D ON D.CourseId = A.subject_id LEFT JOIN tblstudentschedule as E ON E.Cfn = A.cfn WHERE E.StudNo = '".$StudNo."' AND E.IsActive = 1 
		           		AND A.SyId = " . $Sy . " AND A.SemId = " .$Sem . " 
						AND (((time_start_mon >= '". $row['time_start_mon'] ."' 
		            	AND time_start_mon < '". $row['time_end_mon'] . "'  OR '". $row['time_start_mon'] . "' >= time_start_mon AND '". $row['time_start_mon'] ."' < time_end_mon)) || ((time_start_tue >= '". $row['time_start_tue'] ."' 
		            	AND time_start_tue < '". $row['time_end_tue'] . "'  OR '". $row['time_start_tue'] . "' >= time_start_tue AND '". $row['time_start_tue'] ."' < time_end_tue)) || ((time_start_wed >= '". $row['time_start_wed'] ."' 
		            	AND time_start_wed < '". $row['time_end_wed'] . "'  OR '". $row['time_start_wed'] . "' >= time_start_wed AND '". $row['time_start_wed'] ."' < time_end_wed)) || ((time_start_thu >= '". $row['time_start_thu'] ."' 
		            	AND time_start_thu < '". $row['time_end_thu'] . "'  OR '". $row['time_start_thu'] . "' >= time_start_thu AND '". $row['time_start_thu'] ."' < time_end_thu)) || ((time_start_fri >= '". $row['time_start_fri'] ."' 
		            	AND time_start_fri < '". $row['time_end_fri'] . "'  OR '". $row['time_start_fri'] . "' >= time_start_fri AND '". $row['time_start_fri'] ."' < time_end_fri)) || ((time_start_sat >= '". $row['time_start_sat'] ."' 
		            	AND time_start_sat < '". $row['time_end_sat'] . "'  OR '". $row['time_start_sat'] . "' >= time_start_sat AND '". $row['time_start_sat'] ."' < time_end_sat)) || ((time_start_sun >= '". $row['time_start_sun'] ."' 
		            	AND time_start_sun < '". $row['time_end_sun'] . "'  OR '". $row['time_start_sun'] . "' >= time_start_sun AND '". $row['time_start_sun'] ."' < time_end_sun)))"; 	
						
						$tblsched_result = $this->db->query($sql)->result();	

									
		           	}

		           	foreach($check_addtblsched->result_array() as $row)
		           	{
		           		$sql = "SELECT A.*,D.*,E.*,F.year_section FROM tbladdsched as A  
		           			LEFT JOIN tblsched as F on F.cfn = A.cfn
		           			LEFT JOIN tblcourse as D ON D.CourseId = F.subject_id 
		           			LEFT JOIN tblstudentschedule as E ON E.Cfn = F.cfn          			
		           			WHERE E.StudNo = '".$StudNo."' AND E.IsActive = 1 AND A.is_actived =1 AND A.IsSecondTime =1
		           		AND A.SyId = " . $Sy . " AND A.SemId = " .$Sem . " 
						AND (((A.time_start_mon >= '". $row['time_start_mon'] ."' 
		            	AND A.time_start_mon < '". $row['time_end_mon'] . "'  OR '". $row['time_start_mon'] . "' >= A.time_start_mon AND '". $row['time_start_mon'] ."' < A.time_end_mon)) || ((A.time_start_tue >= '". $row['time_start_tue'] ."' 
		            	AND A.time_start_tue < '". $row['time_end_tue'] . "'  OR '". $row['time_start_tue'] . "' >= A.time_start_tue AND '". $row['time_start_tue'] ."' < A.time_end_tue)) || ((A.time_start_wed >= '". $row['time_start_wed'] ."' 
		            	AND A.time_start_wed < '". $row['time_end_wed'] . "'  OR '". $row['time_start_wed'] . "' >= A.time_start_wed AND '". $row['time_start_wed'] ."' < A.time_end_wed)) || ((A.time_start_thu >= '". $row['time_start_thu'] ."' 
		            	AND A.time_start_thu < '". $row['time_end_thu'] . "'  OR '". $row['time_start_thu'] . "' >= A.time_start_thu AND '". $row['time_start_thu'] ."' < A.time_end_thu)) || ((A.time_start_fri >= '". $row['time_start_fri'] ."' 
		            	AND A.time_start_fri < '". $row['time_end_fri'] . "'  OR '". $row['time_start_fri'] . "' >= A.time_start_fri AND '". $row['time_start_fri'] ."' < A.time_end_fri)) || ((A.time_start_sat >= '". $row['time_start_sat'] ."' 
		            	AND A.time_start_sat < '". $row['time_end_sat'] . "'  OR '". $row['time_start_sat'] . "' >= A.time_start_sat AND '". $row['time_start_sat'] ."' < A.time_end_sat)) || ((A.time_start_sun >= '". $row['time_start_sun'] ."' 
		            	AND A.time_start_sun < '". $row['time_end_sun'] . "'  OR '". $row['time_start_sun'] . "' >= A.time_start_sun AND '". $row['time_start_sun'] ."' < A.time_end_sun)))"; 	
						
						$tbladdsched_result = $this->db->query($sql)->result();				
		           	}

		           	if (count($tblsched_result)) 
					{
						foreach ($tblsched_result as $key => $conflict_val) 
						{
							$msg .='<span class="label label-important ">' . $conflict_val->CourseCode . ' - ' . $conflict_val->CourseDesc . ' - ' . $conflict_val->year_section. '1</span><br>';
							$conflict_cnt++;
						}
						
					}

					if (count($tbladdsched_result)) 
					{
						foreach ($tbladdsched_result as $key => $conflict_val) 
						{
							$msg .='<span class="label label-important ">' . $conflict_val->CourseCode . ' - ' . $conflict_val->CourseDesc . ' - ' . $conflict_val->year_section. '2</span><br>';
							$conflict_cnt++;
						}
						
					}
			}        	           	
           	

           	return array('msg'=>$msg ,'conflict_cnt' =>$conflict_cnt);
           	
	}
}

?>
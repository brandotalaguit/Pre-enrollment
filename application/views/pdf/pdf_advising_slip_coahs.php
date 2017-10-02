<?php //if($ownedvoters==TRUE && $_SESSION['student_curriculum']['CollegeId'] != "6") : ?>
<?php if($_SESSION['student_curriculum']['CollegeId'] != "6") : ?>
<?php

$SubTotal = 0.00;
$TuitionFee = TUITION_FEE;
$Exemption = $AssDetails3 ? $AssDetails3['ScholarshipDesc'] : '';
// $CityHall = ($TuitionFee - $AssDetails4[0]['Amount']); //$_SESSION['student_info']['IsMakatiResident'] == 1 ? 9000.00 : 7000.00;
$CityHall = ($TuitionFee - $student_tokenfee['Amount']);

if ( ! empty($student_tokenfee['IsPerUnit'])) 
{
$TuitionFee = $student_tokenfee['Amount'];
$CityHall = 0.00;
}


$Discount = $AssDetails3 ? $student_tokenfee['Amount'] * $AssDetails3['DiscountPercentage'] : 0;
$TokenFee = $TuitionFee - $CityHall - $Discount;
endif;
?>
<?php
function array_unique_key_group($array) {
if(!is_array($array))
    return false;

$temp = array_unique($array,SORT_NUMERIC);
foreach($array as $key => $val) {
    $i = array_search($val,$temp);
    if(!empty($i) && $key != $i) {
        $temp[$i.','.$key] = $temp[$i];
        unset($temp[$i]);
    }
}
return $temp;
}
?>

<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			.header-line{
				background:#f18d05;
				padding: 1px;
				border-radius: 5px;
				color:#fff;
				text-align: center;
			}

			.name{
				color:#f18d05;
			}

		</style>
	</head>
	<body>
		<br><br>
		<table style="width: 100%">
			<?php 
				$_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
                $payment_date = $_SESSION['enrollment_trans']['PaymentDate']
			 ?>
			<tr>
				<td style="width: 50%;font-size: 10px;" ;>University of Makati</td>
				<td style="text-align:center;font-size: 12px; border: 2 solid black" ;>SCHEDULE OF PAYMENT: <?php echo date('F d, Y',strtotime($payment_date)); ?></td>
			</tr>
			<tr>
				<td style="font-size: 14px;" width="50%";>Advising Slip</td>
				<td style="font-size: 9px; color:red" width="50%";>Only payments on designated dates are accepted. Please strictly follow the schedule.
      		  Otherwise you will pay on the last day of scheduled payment</td>

			</tr>
		</table>
		<br><br>
		<table style="width: 100%">
			<tr>
				<td style="width: 50%;font-size: 13px; font-weight: strong" ;>Student Information</td>
			</tr>
			<tr>
				<td style="width: 50%;font-size: 7px; font-weight: strong" ;>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
			</tr>
		</table >

		<br><br>
		<table cellpadding="2">
          <tr>
              <th width="15%" style="font-size: 10px;border: 1px solid black ;  !important " >College</th>
              <td width="35%" style="font-size: 10px;border: 1px solid black ;  " ><?php echo strtoupper($_SESSION['student_curriculum']['CollegeDesc']); ?></td>
              <th width="15%" style="font-size: 10px;border: 1px solid black ;  " >Academic Year</th>
              <td width="35%"style="font-size: 10px;border: 1px solid black ;  " ><?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
          </tr>
          <tr>
              <th style="font-size: 10px;border: 1px solid black ;  ">Program/Major</th>
              <td colspan="3" style="font-size: 10px;border: 1px solid black ;  "><?php echo $_SESSION['student_curriculum']['ProgramDesc']; if(!empty($_SESSION['student_curriculum']['MajorDesc'])) echo 'MAJOR IN ' . $_SESSION['student_curriculum']['MajorDesc'];  ?></td>              
          </tr>
          <tr>
              <th style="font-size: 10px;border: 1px solid black ;  ">Name</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php echo $_SESSION['student_info']['Fname'] . ' ' . $_SESSION['student_info']['Mname'] . ' ' . $_SESSION['student_info']['Lname']; ?></td>
              <th style="font-size: 10px;border: 1px solid black ;  ">Student No.</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php echo strtoupper($_SESSION['student_info']['StudNo']); ?></td>
          </tr>
          <tr>
              <th style="font-size: 10px;border: 1px solid black ;  ">Address</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php echo strtoupper($_SESSION['student_info']['AddressStreet']) . ', ' . strtoupper($_SESSION['student_info']['AddressBarangay']) . ', ' . strtoupper($_SESSION['student_info']['AddressCity']); ?></td>
              <th style="font-size: 10px;border: 1px solid black ;  "> Gender</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php if($_SESSION['student_info']['Gender'] == 'F') echo 'FEMALE'; else { echo 'MALE'; } ?></td>
          </tr>
          <tr>
              <th style="font-size: 10px;border: 1px solid black ;  ">Guardian</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php echo strtoupper($_SESSION['student_info']['Guardian']) ?></td>
              <th style="font-size: 10px;border: 1px solid black ;  ">Date of Birth</th>
              <td style="font-size: 10px;border: 1px solid black ;  "><?php echo date('F d, Y',strtotime($_SESSION['student_info']['BirthDay'])); ?></td>
          </tr>
      </table>
	  <br><br>
	  <table style="width: 100%">
		<tr>
			<td style="width: 50%;font-size: 13px; font-weight: strong" ;>Encoded Subject(s)</td>
		</tr>
		<tr>
			<td style="width: 50%;font-size: 7px; font-weight: strong" ;>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
		</tr>
	  </table >	
	  <br><br>
	  <table cellpadding="2">
        
          <tr>            
            <th width="10%" style="font-size: 10px;border: 1px solid black" ;>CFN</th>
            <th width="15%" style="font-size: 10px;border: 1px solid black" ;>Course Code</th>
            <th width="20%" style="font-size: 10px;border: 1px solid black" ;>Course Description</th>
            <th width="10%" style="font-size: 10px;border: 1px solid black" ;>Section</th>
            <th width="10%" style="font-size: 10px;border: 1px solid black" ;>Units</th>
            <th width="15%" style="font-size: 10px;border: 1px solid black" ;>Time</th>
            <th width="10% " style="font-size: 10px;border: 1px solid black" ;>Days</th>
            <th width="10%" style="font-size: 10px;border: 1px solid black" ;>Room</th>
            <!-- <th width="10%">Faculty</th> -->
          </tr>
        
        <?php $totalUnits = 0;?>
        <?php  foreach($selected_schedule as $keys => $subject): ?>      
        <?php  $SecondTime = $this->M_addsched->get_second_time($subject['cfn']) ?>   
		<?php $sched=array(); ?>
		<?php 
		  if($subject['time_start_mon'] != '00:00:00' && $subject['time_end_mon'] != '00:00:00')  {        
		  $mon = array('M/'. $subject['room_id_mon'] => date('h:i A',strtotime($subject['time_start_mon'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_mon'])));
		$sched = array_merge($sched,$mon);
		} 
		?>        

		<?php if($subject['time_start_tue'] != '00:00:00' && $subject['time_end_tue'] != '00:00:00') {
		$tue = array('T/'. $subject['room_id_tue'] => date('h:i A',strtotime($subject['time_start_tue'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_tue'])));
		$sched = array_merge($sched,$tue);            }  
		?>

		<?php if($subject['time_start_wed'] != '00:00:00' && $subject['time_end_wed'] != '00:00:00') {
		$wed = array('W/'. $subject['room_id_wed'] => date('h:i A',strtotime($subject['time_start_wed'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_wed'])));
		$sched = array_merge($sched,$wed); 
		}
		 ?>     

		<?php if($subject['time_start_thu'] != '00:00:00' && $subject['time_end_thu'] != '00:00:00') {
		$thu = array('TH/'. $subject['room_id_thu'] => date('h:i A',strtotime($subject['time_start_thu'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_thu'])));
		$sched = array_merge($sched,$thu); 
		} 
		?>              
		<?php if($subject['time_start_fri'] != '00:00:00' && $subject['time_end_fri'] != '00:00:00') {
		$fri = array('F/'. $subject['room_id_fri'] => date('h:i A',strtotime($subject['time_start_fri'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_fri'])));
		$sched = array_merge($sched,$fri); 
		} ?>            
		<?php if($subject['time_start_sat'] != '00:00:00' && $subject['time_end_sat'] != '00:00:00') {
		$sat = array('SAT/'. $subject['room_id_sat'] => date('h:i A',strtotime($subject['time_start_sat'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_sat'])));
		$sched = array_merge($sched,$sat); 
		} ?>        
		<?php if($subject['time_start_sun'] != '00:00:00' && $subject['time_end_sun'] != '00:00:00') {
		$sun = array('SUN/'. $subject['room_id_sun'] => date('h:i A',strtotime($subject['time_start_sun'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_sun'])));
		$sched = array_merge($sched,$sun);            
		} ?>        

		  
		    <tr>   
				<td style="font-size: 8px;border: 1px solid black" >
					<?php echo $subject['cfn']; ?>    
				</td>
				<td style="font-size: 8px;border: 1px solid black" ><?php echo ($subject['subject_id'] != 0 ? $subject['CourseCode'] : $subject['sub_code']); ?>
				</td>
				<td style="font-size: 8px;border: 1px solid black" ><?php echo ($subject['subject_id'] != 0 ? $subject['CourseDesc'] : $subject['sub_desc']) ; ?></td>

				<td style="font-size: 8px;border: 1px solid black" ><?php echo $subject['year_section']; ?></td>        
				<td style="font-size: 8px;border: 1px solid black" ><?php echo ($subject['subject_id'] != 0 ? $subject['Units'] : $subject['units']); ?></td>                   
				<td style="font-size: 8px;border: 1px solid black" >        
					<?php $sched = array_unique_key_group($sched); ?>
					<?php $ctr =0; foreach($sched as $time ): ?>          
					<?php if(count($sched) == 1 || count($sched) == $ctr+1): ?>
					<?php echo $time; ?>          
					<?php else: ?>
					<?php echo $time . '/'; ?>          
					<?php endif;?>
					<?php $ctr++; endforeach; ?>    
					<?php   echo "/".implode('/ ',$SecondTime['time_c']) ?>                
				</td>

				<td style="font-size: 8px;border: 1px solid black" >          
					<?php  $ctrx=1;  foreach($sched as $keys => $time ): ?>        
					<?php $days = explode(',',$keys); ?>        
					<?php $max_c = 1; foreach($days as $day): ?>
					<?php $da = explode('/',$day);  ?>           


					<?php 
						if(count($days) > 1) 
						{  
							if(count($days) == $max_c && count($sched) != $ctrx)             
								echo $da[0].'/';          
							else
								echo $da[0];          
						}
						else
						{  
							echo $da[0].'/';
						}     
						$max_c++;             
					?>       

					<?php endforeach; ?>              
					<?php  $ctrx++; endforeach; ?>    
					<?php   echo "/".implode('/ ',$SecondTime['day_c']) ?>                
				</td>
		     	<td style="font-size: 8px;border: 1px solid black" >
		        <?php  
		        	$max_a = 0; 
		        	foreach($sched as $keys => $time ): 
		        ?>        
		        <?php $days = explode(',',$keys); ?>
		        <?php $d = array(); ?>    
		        
		        <?php foreach($days as $day): ?>
		        <?php 
		            $da = explode('/',$day); 
		            array_push($d,$da[1]);
		            $d = array_unique($d);    
		        ?>
		        <?php endforeach; $max_d = 0; ?>                
		        <?php //print_r($d); ?>    

		        <?php foreach($d as $e): ?>
		        
		        <?php              
		        
		            if(count($sched) == 1 || count($sched) == $max_a+1)     
		            {
		                if(!$e == 0)
		                {
		                    $broom = $this->db->select('BuildingCode,RoomNum')->join('tblbuilding as B','A.BuildingId = B.BuildingId')->where('RoomId',$e)->get('tblroom as A')->row_array();
		                    echo  $broom['BuildingCode'] . ' ' . $broom['RoomNum'];
		                }
		                else
		                {
		                    echo '';
		                }
		                
		            }            
		            else
		            {                
		                if(!$e == 0)
		                {
		                    $broom = $this->db->select('BuildingCode,RoomNum')->join('tblbuilding as B','A.BuildingId = B.BuildingId')->where('RoomId',$e)->get('tblroom as A')->row_array();
		                    echo  $broom['BuildingCode'] . ' ' . $broom['RoomNum'] .'/';
		                }
		                else
		                {
		                    echo ' ' .'/';
		                }
		            }
		            
		       
		        ?>                  
		        <?php $max_d++; endforeach; ?>                            
		        <?php $max_a++; endforeach; ?>
		        </td>
		      <!-- <td>
		        <?php echo $subject['faculty_name']; ?>            
		      </td> -->   
		    </tr>
		    <?php $totalUnits += $subject['Units']; ?>
		<?php endforeach;  ?>
		    <tr>
		        <th width="10%" style="font-size: 8px;border: 1px solid black" ;></th>
	            <th width="15%" style="font-size: 8px;border: 1px solid black" ;> </th>
	            <th width="20%" style="font-size: 8px;border: 1px solid black" ;> </th>
	            <th width="10%" style="font-size: 8px;border: 1px solid black" ;>Total Units:</th>
	            <th width="10%" style="font-size: 8px;border: 1px solid black" ;><?php echo number_format($totalUnits,1); ?></th>
	            <th width="15%" style="font-size: 8px;border: 1px solid black" ;></th>
	            <th width="10% " style="font-size: 8px;border: 1px solid black" ;></th>
	            <th width="10%" style="font-size: 8px;border: 1px solid black" ;></th>
		    </tr>
		</table>
		<br>
		<br>
<?php

  $SubTotal = 0.00;
  // dump($assessment);
  // dump($tuition);

  $tuition_fee = $assessment['no_units'] * $tuition['rate_per_unit'];
  $rle_aff_fee = $assessment['no_rle_hours'] * $tuition['rle_rate_per_hour'];
  $lab_fee = $assessment['no_lab_units'] * $tuition['lab_rate_per_unit'];
  $misc_fee = $tuition['misc_fee'];
  $total_fees = $tuition_fee + $rle_aff_fee + $lab_fee + $misc_fee;

?>
		  <table width="100%" cellpadding="3">
			  <tr>
				  <td width="50%" colspan='2' style="font-size: 14px;border: 1px solid black"><small><strong><?php echo $tuition['description'] ?></strong></small></td>
				  <td rowspan="12" width="50%"> 
				  	<table width="100%" cellpadding="3">
				  		<tr>
					  		<td colspan="2" style="width: 80%; text-align: center;">
					  			<h4 style="margin: 13px; text-align: center; border-top: 1px solid #000;">COAHS Approving Officer</h4>
					  		</td>
				  		</tr>
				  		<tr>
				  			<td colspan="2" style="margin: 11px;font-weight: bold;">PAYMENT SCHEME</td>
				  		</tr>
				  		<?php if ($assessment['payment_scheme'] == 1): ?>
					  		<tr>
					  			<td colspan="2" style="font-size: 8px;font-weight: bold;"> ( A ) Full Payment</td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Grand Total</td>
					  			<td style="font-size: 8px;border: 1px solid black"> <?php echo nf($total_fees) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Less: 10% Discount </td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo nf($tuition_fee * 0.10) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Total Fees</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo nf($total_fees - ($tuition_fee * 0.10)) ?></td>
					  		</tr>
				  		<?php elseif ($assessment['payment_scheme'] == 2): ?>
				  			<tr>
					  			<td colspan="2" style="font-size: 8px;font-weight: bold;"> ( B ) Installment</td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">First Payment (30% of Total Fees)</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf($total_fees * 0.30) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Balance (Divided into 4 months)</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf($total_fees - ($total_fees * 0.30)) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Total Monthly Fees</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf(($total_fees - ($total_fees * 0.30))/4) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Total Fees</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo nf($total_fees) ?></td>
					  		</tr>
				  		<?php elseif ($assessment['payment_scheme'] == 3): ?>
				  			<tr>
					  			<td colspan="2" style="font-size: 8px;font-weight: bold;"> ( C ) Installment</td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">First Payment (10% of Total Fees)</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf($total_fees * 0.10) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Remaining Balance</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf($total_fees - ($total_fees * 0.10)) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Balance plus 5% interest </td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf(($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Total Monthly Fees </td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo  nf((($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05))/4) ?></td>
					  		</tr>
					  		<tr>
					  			<td style="font-size: 8px;border: 1px solid black">Total Fees</td>
					  			<td style="font-size: 8px;border: 1px solid black"><?php echo nf($total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></td>
					  		</tr>
				  		<?php endif ?>
				  		<tr>
				  			<td colspan="2" style="font-size: 8px;"><?php echo $tuition['description'] ?></td>
				  		</tr>
				  	</table>
					
				  </td>
			  </tr>
			  <tr>
				  <td  width="35%" style="font-size: 8px;border: 1px solid black">No. of Units</td>
				  <td  width="15%" style="font-size: 8px;border: 1px solid black"><?php echo $assessment['no_units'] ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black">Rate per Unit</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo $tuition['rate_per_unit'] ?></td>
			  </tr>
			  <tr style='font-size:18px; font-weight: bold;border: 1px solid black '>
				  <td style="border: 1px solid black">Tuition Fee</td>
				  <td style="border: 1px solid black"><?php echo nf($assessment['no_units'] * $tuition['rate_per_unit']) ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black" class="assessment_td">No. of Hours</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo $assessment['no_rle_hours'] ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black" class="assessment_td">Rate per Hour</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo $tuition['rle_rate_per_hour'] ?></td>
			  </tr>
			  <tr style='font-size:18px; font-weight: bold;border: 1px solid black'>
				  <td style="border: 1px solid black">RLE and Affiliation Fee</td>
				  <td style="border: 1px solid black"><?php echo nf($assessment['no_rle_hours'] * $tuition['rle_rate_per_hour']) ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black" class="assessment_td">No. of Units</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo $assessment['no_lab_units'] ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black" class="assessment_td">Rate per Unit</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo $tuition['lab_rate_per_unit'] ?></td>
			  </tr>
			  <tr style='font-size:18px; font-weight: bold;border: 1px solid black'> 
				  <td style="border: 1px solid black">Laboratory Fee</td>
				  <td style="border: 1px solid black"><?php echo nf($assessment['no_lab_units'] * $tuition['lab_rate_per_unit']) ?></td>
			  </tr>
			  <tr>
				  <td style="font-size: 8px;border: 1px solid black" class="assessment_td">Miscellaneous Fees</td>
				  <td style="font-size: 8px;border: 1px solid black"><?php echo nf($tuition['misc_fee']) ?></td>
			  </tr>
			  <tr style='font-size:18px; font-weight: bold;'>
				  <td style="border: 1px solid black">Total Fees</td>
				  <td style="border: 1px solid black"><?php echo nf($total_fees) ?></td>
			  </tr>

			
		  </table>

		  <?php if (count($student_assessment)): ?>  
		  	<br><br>
			<table width="100%" cellpadding="3" nobr="true">	
				<tr>
					<td width="35%" style="text-align:center;font-size: 10px;;border: 1px solid black">STUDENT ORGANIZATION FEE(S)</td>
					<td width="15%" style="font-size: 10px;border: 1px solid black">Amount</td>
					<td rowspan="<?php echo intval(1)+count($student_assessment) ?>" style="font-size: 8px;">
						<h2>
						 Scholarship Requirements
					 	</h2>
					 	<p>
					  	<strong>
						  	Basic Requirements: 
					  	</strong>
					  	</p>

						<ul>
							<li>Accomplished MACES Form (for new applicant), MACES Form (for continuing applicant)</li>
							<li>Residency Verification Form </li>
							<li>1 x 1 ID Picture(for new scholar applicant)</li>
							<li>Encoded Subjects and Assessment</li>
						</ul>
		
						<p><strong>Other Requirements:</strong></p>
						<ul>
							<li>Base on kind of Scholarship</li>
						</ul>
					</td>
				</tr>

				<?php foreach ($student_assessment as $misc): ?>
					<tr>
						<td style="font-size: 8px;border: 1px solid black"><?php echo $misc['FeeDesc']; ?></td>
						<td style="font-size: 8px;border: 1px solid black"><?php echo nf($misc['Amount']); ?></td>
					</tr>
					<?php $SubTotal += $misc['Amount']; ?>
					<?php endforeach ?>

					<tr>
						<th style="font-size: 16px;border: 1px solid black" >Sub-Total</th>
						<th style="font-size: 16px;border: 1px solid black"><?php echo nf($SubTotal); ?></th>
					</tr>

					<?php if ( ! empty($nstp_subject)): ?>
			        <tr>
			            <td style="font-size: 8px;border: 1px solid black">NSTP Fee</td>
			            <td style="font-size: 8px;border: 1px solid black">100.00</td>
			        </tr>
			        <tr>
			            <th style="font-size: 8px;border: 1px solid black" style="font-size:16px">Sub-Total</th>
			            <th style="font-size: 8px;border: 1px solid black"><strong>100.00</strong></th>
			        </tr>
			        <?php endif ?>
			</table>
		   <?php endif ?>

		   <table width="">
				<!-- <tr align="center" style="font-size: 14px;">
				  <td>
					<h3>ACCOUNTING OFFICE</h3>
					<strong>Payment Slip</strong>
					<h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>
				  </td>
				</tr> -->

				<tr>
				  <td width='10%' style="font-size: 8px;" >Name:</td>
				  <td width='40%' style="font-size: 8px;"><?php echo $_SESSION['student_info']['Fname'] . ' ' . $_SESSION['student_info']['Mname'] . ' ' . $_SESSION['student_info']['Lname']; ?></td>
				  <td width='15%' style="font-size: 8px;">Student No.</td>
				  <td width='35%'><?php echo strtoupper($_SESSION['student_info']['StudNo']); ?></td>
				</tr>
				<!-- <tr>
				  <td width='30%' colspan="2" style="font-size: 8px;" colspan='2'><strong>PARTICULAR</strong></td>
				  <td width='70%' colspan="2"  style="font-size: 8px;" colspan='2'><strong>AMOUNT</strong></td>
				</tr>
				<tr>
				  <td colspan='2' style="font-size: 8px;">Total Fees</td>
				  <td colspan='2' style="font-size: 8px;">
					<?php if ($assessment['payment_scheme'] == 1): ?>
						<strong><?php echo nf($total_fees - ($tuition_fee * 0.10)) ?></strong>
						<?php $grand_total = $total_fees - ($tuition_fee * 0.10); ?>
					<?php endif ?>

					<?php if ($assessment['payment_scheme'] == 2): ?>
						<strong><?php echo  nf($total_fees * 0.30) ?></strong>      
						<?php $grand_total = $total_fees * 0.30; ?>
					<?php endif ?>

					<?php if ($assessment['payment_scheme'] == 3): ?>
						<strong><?php echo  nf($total_fees * 0.10) ?></strong>
						<?php $grand_total = $total_fees * 0.10 ?>
					<?php endif ?>
				  </td>
				</tr>
				<tr>
				  <td colspan='2' style="font-size: 8px;">Penalty</td>
				  <td colspan='2' style="font-size: 8px;">&nbsp;</td>
				</tr>
				<tr>
				  <th colspan='2' style="font-size: 8px;">Grand Total</th>
				  <th colspan='2' style="font-size: 8px;">Php <?php echo nf($grand_total) ?></th>
				</tr>
				<tr>
				  <td colspan='4'>&nbsp;</td>
				</tr>
				<tr>
				  <td style="font-size: 8px;" >Approved by</td>
				  <td style="font-size: 8px;" ><?php echo $accounting_staff; ?></td>        
				  <td style="font-size: 8px;">Date approved</td>
				  <td style="font-size: 8px;"><?php echo date('F j, Y', strtotime($assessment['date_assessed'])); ?></td>
				</tr> -->
			</table>
			<span class="muted">Note: This form is for Cash Office use only.</span>
		
	</body>
</html>


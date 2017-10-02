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
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $site_title; ?><?php if(isset($page_title)) echo $page_title; ?></title>
	<meta name="description" content="<?php echo $site_description; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	<link rel="shortcut icon" href="<?php echo $site_icon; ?>">        
		
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="all">    
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css" media="all">        
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>   
	<script src="<?php echo base_url(); ?>assets/js/disable.js" ></script>   
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
	<![endif]-->
	<style type="text/css" media="print">
		table { page-break-inside:avoid; }
		tr    { page-break-inside:avoid; page-break-after:auto;  }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }
		@page { size: letter;/*size:8.5in 14in portrait;*/ /*width:8.5in; height: 14in;*/ margin: 1.2cm 1.5cm 1.5cm; font-size: 3pt; }
	</style>
	</head>
<body style="background:none" onload="window.print()">
<div class="container"> 
<header>	
	<div class="row">
		<div align="center">
			 <!--  <img src="<?php echo base_url(); ?>assets/img/umak_logo.png" /> -->
			  <h2 style="font-family:arial;color:#333;font-weight:bold;">
		  UNIVERSITY OF MAKATI<br/>
		  <span class="cor-subtitle">J.P. Rizal Extension, West Rembo, Makati City</span>
		</h2>
		
			  <h3 style="font-family:arial;color:#000;font-weight:bold;">ONLINE CERTIFICATE OF REGISTRATION</h3>
		</div>
		
	  </div> 
</header>

<div role="main" id="main">	         
	  <!-- <h2>Student Information</h2>  -->
	  <!-- <h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5> -->      
	  <div class="row">        
		<div class="span2 offset6" style="margin-left:490px;"><strong>Date</strong></div>
		<div class="span2" style="margin-left:0px;"><?php echo date("m/d/Y", strtotime($current_date))?></div>
	  </div>
	  <table class="table table-bordered table-condensed">          
		  <tr>
			  <th width="15%">College</th>
			  <td width="35%"><?php echo strtoupper($_SESSION['student_curriculum']['CollegeDesc']); ?></td>
			  <th width="15%">Academic Year</th>
			  <td width="35%"><?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
		  </tr>
		  <tr>
			  <th>Program/Major</th>
			  <td><?php echo $_SESSION['student_curriculum']['CurriculumDesc']; #echo $_SESSION['student_curriculum']['ProgramDesc']; if(!empty($_SESSION['student_curriculum']['MajorDesc'])) echo 'MAJOR IN ' . $_SESSION['student_curriculum']['MajorDesc'];  ?></td>
			  <th>Yr Level</th>
			  <td><?php echo $this->M_enroll->get_year_level($_SESSION['student_curriculum']['CurriculumId'], $_SESSION['student_curriculum']['CollegeId'], $_SESSION['student_info']['LengthOfStayBySem']); ?></td>
		  </tr>
		  <tr>
			  <th>Name</th>
			  <td><?php echo $_SESSION['student_info']['Fname'] . ' ' . $_SESSION['student_info']['Mname'] . ' ' . $_SESSION['student_info']['Lname']; ?></td>
			  <th>Student No.</th>
			  <td><?php echo strtoupper($_SESSION['student_info']['StudNo']); ?></td>
		  </tr>
		  <tr>
			  <th>Address</th>
			  <td><?php echo strtoupper($_SESSION['student_info']['AddressStreet']) . ', ' . strtoupper($_SESSION['student_info']['AddressBarangay']) . ', ' . strtoupper($_SESSION['student_info']['AddressCity']); ?></td>
			  <th>Gender</th>
			  <td><?php if($_SESSION['student_info']['Gender'] == 'F') echo 'FEMALE'; else { echo 'MALE'; } ?></td>
		  </tr>
		  <tr>
			  <th>Guardian</th>
			  <td><?php echo strtoupper($_SESSION['student_info']['Guardian']) ?></td>
			  <th>Date of Birth</th>
			  <td><?php echo date('F d, Y',strtotime($_SESSION['student_info']['BirthDay'])); ?></td>
		  </tr>
	  </table>
	  <?php if(!empty($selected_schedule)) : ?>      
	  <h2>Encoded Subject(s)</h2> 
	  <h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>

	  
	  <table class="table table-bordered table-condensed" >
		<thead>
		  <tr>            
			<th width="5%">CFN</th>
			<th width="13%">Course Code</th>
			<th width="20%">Course Description</th>
			<th width="7%">Section</th>
			<th width="3%">Units</th>
			<th width="15%">Time</th>
			<th width="10%">Days</th>
			<th width="10%">Room</th>
			<!-- <th width="10%">Faculty</th> -->
		  </tr>
		</thead>
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
	  <td>
		<?php echo $subject['cfn']; ?>    
	  </td>
	  <td><?php echo ($subject['subject_id'] != 0 ? $subject['CourseCode'] : $subject['sub_code']); ?></td>
			<td><?php echo ($subject['subject_id'] != 0 ? $subject['CourseDesc'] : $subject['sub_desc']) ; ?></td>
			
			<td><?php echo $subject['year_section']; ?></td>        
			<td><?php echo ($subject['subject_id'] != 0 ? $subject['Units'] : $subject['units']); ?></td>                   
	   <td>        
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

	  <td>          
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
		  <?php   echo "/".implode('/ ',$SecondTime['day_c']) ?>              
		<?php  $ctrx++; endforeach; ?>                  
	  </td>
	  <td>
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
		<tfoot>
		<th colspan ="4" >Total Units: </th>
		<th width="7%" ><?php echo number_format($totalUnits,1); ?></th>
		<th colspan="4" ></th>
		</tfoot>
	</tr>
</table>
<?php endif; ?>



<div class="row">

  <div class="span45">
	<p class="text-justify">
	  Please register me in the above listed courses. I have already TAKEN and PASSED the PRE-REQUISITES, otherwise, I shall not claim credits for them.
	</p>
	<div style="margin-bottom:25px; text-align:center">
	  <hr class="sig_bar" style="width:70%;">
	  STUDENT'S SIGNATURE      
	</div>
  </div>

  <div class="span7">
	<div class="row">
	  <div class="span2">
		<?php 

		include( APPPATH . 'third_party/phpqrcode/qrlib.php'); 
		
		
		$url = 'https://umak.edu.ph/olea_development/qr_code/' . $_SESSION['student_info']['StudNo'];
		
		define('EXAMPLE_TMP_SERVERPATH', APPPATH . '../assets/qrcodes/');
			
		QRcode::png($url, EXAMPLE_TMP_SERVERPATH.$_SESSION['student_info']['StudNo'].".png",QR_ECLEVEL_L,3);

		// displaying 
		echo "<img src='".base_url()."assets/qrcodes/".$_SESSION['student_info']['StudNo'].".png' />"; 
		
		?>
	  </div>
	  <div class="span5">

		<table class="table-condensed span5">
		  <tr>
			<th class="pull-right">
			  <!--Recommended:-->
			</th>
			<td> <!-- style="border-bottom:1px #333 solid; width:70%; " -->
			  &nbsp;
			</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="text-center">
			  <!--Registration Officer-->
			</td>
		  </tr>
		  <tr>
			<th class="pull-right">
			  Approved:
			</th>
			<th style="border-bottom:1px #333 solid; width:70%; text-align:center">
			  <?php echo $dean['Prefix'] . ' ' . $dean['Fname'] . ' ' . $dean['Mname'] . '. ' . $dean['Lname'] . ' ' . $dean['Suffix']?>
			</th>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td style="text-align:center">
			  Dean/Director
			</td>
		  </tr>
		</table>
		
	  </div>
	</div>
  </div>

</div>



<div class="row">
  <div class="span45">
	<h4 class="title text-center">NOTICE TO EVERY STUDENT</h4>
	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;Students cannot claim credits for unofficially registered courses.
	</p>
	<p class="text-justify">      
	  &nbsp;&nbsp;&nbsp;&nbsp;The Removal of Incomplete grade (INC) in <b> non-pre-requisite course/s</b>
	  must be done <b>within one year after it has been incurred.</b>Howevre, the
	  incomplete grade in a <b> pre-requisite course/s</b> must be removed <b> within the
	  semester after it has been incurred,</b>otherwise the student has to re-enroll
	  the said course/s and <b>cannot claim credits for the the advanced course/s.</b>
	</p>

	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;Any student who at the end of the semester obtains a grade of "5.0" in three
	  courses (equivalent to 9 units) <b>shall not be admitted in the regular program.</b>
	</p>
	
	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;Accumulation of a total of five failing grades or the equivalent of fifteen units
	  <b>shall be barred from re-enrollment.</b>
	</p>
	
	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;A student may drop a course anytime during the semester, but not later than
	  a week after the midterm examination period. A student who intends to drop a
	  course should accomplish the dropping form and seek the approval of the
	  concerned teacher and the Dean of the college. The student shall be marked
	  <b>O.D. (Officially Dropped).</b>
	</p>
		  
	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;A student who stopped attending class/es without filling the official
	  dropping form shall be marked <b> U.D. (Unofficially Dropped).</b>
	</p>
		  
	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;Accumulation of a total of five U.D. courses or the equivalent of 15 units
	  (excluding ROTC), the students shall be barred from re-enrollment.
	</p>

	<p class="text-justify">
	  &nbsp;&nbsp;&nbsp;&nbsp;Amendment of Grade/s or inclusion of name of student in the Grade Sheets
	  has to be made within a year after the issuance period of the Reports of
	  Grades. This has to be approved by the University Council.
	</p>
  </div>


  <!-- misc fee -->  
  <div class="span7">
  <?php
  
  $SubTotal = 0.00;

  $tuition_fee = $assessment['no_units'] * $tuition['rate_per_unit'];
  $rle_aff_fee = $assessment['no_rle_hours'] * $tuition['rle_rate_per_hour'];
  $lab_fee = $assessment['no_lab_units'] * $tuition['lab_rate_per_unit'];
  $misc_fee = $tuition['misc_fee'];
  $total_fees = $tuition_fee + $rle_aff_fee + $lab_fee + $misc_fee;
  
  ?>
  <h5 class="pull-right"><?php echo $tuition['description'] ?></h5>
  <h4>PAYMENT SCHEME</h4>
  <div class="well">
	
  <?php if ($assessment['payment_scheme'] == 1): ?>
	  <strong>( A )</strong>
	  <strong>Full Payment</strong>
	  <p>Grand Total <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
	  <p>Less: 10% Discount <u class='pull-right'>(<strong><?php echo nf($tuition_fee * 0.10) ?></strong>)</u></p>
	  <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees - ($tuition_fee * 0.10)) ?></strong></u></p>
	  
  <?php endif ?>

  <?php if ($assessment['payment_scheme'] == 2): ?>
	  <strong>( B )</strong>
	  <strong>Installment</strong>
	  <p>First Payment (30% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.30) ?></strong></u></p>
	  <p>Balance (Divided into 4 months) <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.30)) ?></strong></u></p>
	  <p>Total Monthly Fees <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.30))/4) ?></strong></u></p>
	  <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
  <?php endif ?>

  <?php if ($assessment['payment_scheme'] == 3): ?>
	  <strong>( C )</strong>
	  <p>First Payment (10% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.10) ?></strong></u></p>
	  <p>Remaining Balance <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.10)) ?></strong></u></p>
	  <p>Balance plus 5% interest <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
	  <p>Total Monthly Fees <u class='pull-right'><strong><?php echo  nf((($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05))/4) ?></strong></u></p>
	  <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
  <?php endif ?>

  </div>

  
  
	<table class="table table-bordered table-condensed">
	  
	<?php if ($student_assessment) { ?>

			<thead>
				<tr>
				  <th style="text-align:center;">MISCELLANEOUS FEE(S)</th>
				  <th>Amount</th>
				</tr>
			</thead>

				<tbody class="table-condensed">

				  <?php foreach ($student_assessment as $misc): ?>

							<tr>
							  <td style="text-align:right; padding-right:45px;"><?php echo $misc['FeeDesc']; ?></td>
							  <td><?php echo nf($misc['Amount']); ?></td>
							</tr>
			  	  <?php $SubTotal += $misc['Amount']; ?>
				  <?php endforeach ?>

				  <tr>
					  <th style="text-align:right; padding-right:45px;font-size:16px">Sub-Total</th>
					  <th style="font-size:16px"><?php echo nf($SubTotal); ?></th>
				  </tr>

				  <?php if ( ! empty($nstp_payment)): ?>
				    <tr>
				    <th style="text-align:center;" colspan="2">NSTP Payment</th>
				    </tr>
				    <tr>
				      <td style="text-align:right; padding-right:45px;">Receipt No.</td>
				      <td style="font-size:16px"><?php echo nf($nstp_payment['ornum']) ?></td>
				    </tr>
				    <tr>
				      <td style="text-align:right; padding-right:45px;">Amount</td>
				      <td style="font-size:16px"><?php echo nf($nstp_payment['Amount']) ?></td>
				    </tr>
				  
				  <?php endif ?>

				  <tr><td colspan="2">&nbsp;</td></tr>
				</tbody>

	<?php } ?>

		  <thead>
			  <tr>
				  <td><h4 class="title">TUITION FEE</h4></td>
				  <th style="background-color:white;color:#333;font-weight:bold;font-size:18px;"><?php echo nf($assessment['grand_total']); ?></th>
			  </tr>
		  </thead>
		  <tbody>
			  <tr>
				  <td style="text-align:right; padding-right:45px;">Less: SCHOLARSHIP/PRIVILEGE From Makati City Government</td>
				  <td><?php echo "( ". nf(0) ." )"; ?></td>
			  </tr>

			  <tr>
				  <th style="text-align:right; padding-right:45px;font-size:18px">Tuition Fee</th>
				  <th style="font-size:18px" ><?php echo nf($assessment['grand_total']); ?></th>
			  </tr>
		  </tbody>
    </table>

    <div class="clearfix"></div>

	<table class="table table-bordered table-condensed table-striped">
	  <tr>
		<td colspan="2">
		  <h4 class="title">PAYMENT</h4>
		</td>
	  </tr>
	  <tr>	  	
		<?php if ($assessment['promissory'] == 1): ?>
		<th style="width:280px;"><span class="pull-right">Payment Mode</span></th>
		<td>
			<h3>PROMISSORY NOTE</h3>
		</td>
		<?php endif ?>
	  </tr>
	  <tr>
		<th><span class="pull-right">OR No.</span></th>
		<td class="lead">
		  <?php 
			if ($assessment['grand_total'] > 0)
			{
				if ( ! empty($payments['ornum'])) 
				  echo $payments['ornum'];
			}
		  ?>
		</td>
	  </tr>
	  <tr>
		<th><span class="pull-right">Date</span></th>
		<td class="lead" style="vertical-align:bottom;">

		  <?php 
			if ($assessment['grand_total'] > 0)
			{
				if ( ! empty($payments['Date'])) 
				  echo date('m/d/Y', strtotime($payments['Date']));
			}
		  ?>

		</td>
	  </tr>      
	  <tr>
		<th><span class="pull-right">Amount Paid</span></th>
		<td class="lead" style="vertical-align:bottom;">          
		  <div class="row-fluid">
			<div class="span1">
			  <strong>Php</strong>
			</div>
			<div class="span6">
			  <span class="pull-right">
				<?php 
				  if ($assessment['grand_total'] > 0) 
				  {
				  	if ( ! empty($payments['Amount'])) 
					echo number_format($payments['Amount'],2);
				  }
				?>
			  </span>
			</div>
		  </div>
		</td>
	  </tr>
	  <tr>
		<th><span class="pull-right">Balance</span></th>
		<td class="lead" style="vertical-align:bottom;">
		  <div class="row-fluid">
			<div class="span1">
			  <strong>Php</strong>
			</div>
			<div class="span6">
			  <span class="pull-right">
				<?php 
				  if ($assessment['grand_total'] > 0)
				  {                    
					echo number_format($assessment['grand_total'] - (! empty($payments['Amount']) ? $payments['Amount'] : 0) , 2);
				  }
				?>
			  </span>
			</div>
		  </div>
		</td>
	  </tr>
	  <tr>
		<th><span class="pull-right">Payment Received by</span></th>
		<td style="vertical-align:bottom;">
		  <?php 
			if ($assessment['grand_total'] > 0) 
			{
				if ( ! empty($payments['User'])) 
				  echo $payments['User'];
			}
		  ?>
		</td>
	  </tr>
	</table>

  </div>
  <!--/. assessment ./-->
   
</div>


</body>
</html>

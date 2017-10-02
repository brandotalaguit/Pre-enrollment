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
    
    </head>
<body style="background:none" onload="window.print()">
<div class="container"> 
<header>	
    <div class="row">
    	<div class="span6">
			 <!--  <img src="<?php echo base_url(); ?>assets/img/umak_logo.png" /> -->
			  <h2 style="font-family:arial;color:#333">University of Makati</h1>
			  <h1 style="font-family:arial;color:#000">Advising Slip</h2>
      	</div>
      	<div class="span6">
            <?php            
                  $_SESSION['enrollment_trans'] = $this->M_enroll->get_enrollment_trans($_SESSION['sy_sem']['SyId'],$_SESSION['sy_sem']['SemId'],$_SESSION['student_id']);
                  $payment_date = $_SESSION['enrollment_trans']['PaymentDate'];
            ?>
      		  <h2 style="font-family:arial;color:#000;border:3px solid #000;padding:2px 3px">SCHEDULE OF PAYMENT: <?php
 echo date('F d, Y',strtotime($payment_date)); ?></h2>
           <h3 class="text-danger">Only payments on designated dates are accepted. Please strictly follow the schedule.
      		  Otherwise you will pay on the last day of scheduled payment
           </h3>
      	</div>
      </div> 
</header>
<hr>
<div role="main" id="main">	         
      <h2>Student Information</h2> 
      <h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>
      <table class="table table-bordered table-condensed">
          <tr>
              <th width="15%">College</th>
              <td width="35%"><?php echo strtoupper($_SESSION['student_curriculum']['CollegeDesc']); ?></td>
              <th width="15%">Academic Year</th>
              <td width="35%"><?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
          </tr>
          <tr>
              <th>Program/Major</th>
              <td colspan="3"><?php echo $_SESSION['student_curriculum']['ProgramDesc']; if(!empty($_SESSION['student_curriculum']['MajorDesc'])) echo 'MAJOR IN ' . $_SESSION['student_curriculum']['MajorDesc'];  ?></td>              
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
            <th width="8%">CFN</th>
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
        <?php  $ctrx++; endforeach; ?>    
        <?php   echo "/".implode('/ ',$SecondTime['day_c']) ?>                
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
<div class="span7">    
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
  ?>
  <table class="table table-bordered table-condensed">
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
          <tr>
              <td colspan="2">&nbsp;</td>
          </tr>

          <?php if ( ! empty($nstp_subject)): ?>
          <tr>
              <td style="text-align:right; padding-right:45px;">NSTP Fee</td>
              <td>100.00</td>
          </tr>
          <tr>
              <th style="text-align:right; padding-right:45px;font-size:16px">Sub-Total</th>
              <th style="font-size:16px"><strong>100.00</strong></th>
          </tr>
          <?php endif ?>

          <thead>
              <tr>
                  <th style="text-align:center;">TUITION FEE</th>
                  <th style="background-color:white;color:#333;font-weight:bold;font-size:18px;"><?php echo nf($TuitionFee); ?></th>
              </tr>
          </thead>
          
          <tr>
              <td style="text-align:right; padding-right:45px;">Less: SCHOLARSHIP/PRIVILEGE From Makati City Government</td>
              <td><?php echo "( ". nf($CityHall) ." )"; ?></td>
          </tr>

          <?php if($Discount > 0): ?>
          <tr>
              <td style="text-align:right; padding-right:45px;"><?php echo "Less: Scholarship ".$Exemption; ?></td>
              <td><?php echo "( ". nf($Discount)." )"; ?></td>
          </tr>
          <?php endif; ?>

          
          <tr>
              <th style="text-align:right; padding-right:45px;font-size:18px">Token Fee</th>
              <th style="font-size:18px" ><?php echo nf($TokenFee); ?></th>
          </tr>
          
  </tbody>
  </table>
<?php else: ?>
<?php echo $printbutton;?>
<?php
 echo date('F d, Y',strtotime($payment_date)); ?>
</span>
<?php endif; ?>
</div>
<div class="span45">    
    <!-- <h2>Reminders</h2>
    <span>Please read.</span>
    <br><br>
    <p >Be sure that you have taken and passed the pre-requisite course/s before enrolling the advanced course/s, otherwise, it will not be given credit.
    </p>
    <p >
    Only graduating students are allowed to have an overload, provided it will not exceed 28 units.
    </p> -->
    
    <h2>
    <!-- <img src="<?php echo base_url();?>assets/img/icon_home.png" class="right"> --> Change of Residency Procedure 
  </h2>
    <p>
        <strong>
            A student who claims to be a resident must attach any of the following:
        </strong>
    </p>

            
            <!-- <img src="<?php echo base_url();?>assets/img/id_card.png" class="thumnails pull-right" width="80"> -->
            <ol>
                <li>Accomplished Residency Verification Form </li>
                <li>Vote's ID or latest Voter's Certification if student is 18 yrs. old and above</li>
                <li>SK Voter's ID if student is below 18 yrs. old.</li>
                <li>Voter's ID or latest Voter's Certification of parents or a brother or a sister.
                    <ul>
                        <li>The student and her/his sibling's Birth Certificate are required to verify the truthfulness of the relationship</li>
                        <li>If the guardian is a married sister, student must present the sister's birth and marriage certificate.</li>
                    </ul>
                </li>
            </ol>        
            <!-- <div class="alert alert-danger"> -->
                <!-- <i class="icon icon-warning-sign"></i> --> No attachments required for <strong>Non Makati Residents</strong>
            <!-- </div> -->
            <!-- <div class="badge"> --><br>
                <strong>Should there be a change in residency; the student is required to present necessary documents.</strong>
            <!-- </div> -->
    
       <br/><br/>
<h2>
   <!--  <img src="<?php echo base_url();?>assets/img/icon_scholarship.png" class="right"> --> Scholarship Requirements
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
        
        <!-- <div class="alert alert-info"> -->
            <p><strong>Other Requirements:</strong></p>
                <ul>
                    <li>Base on kind of Scholarship</li>
                </ul>
        <!-- </div> -->

    </div>     


</div>
</div>
</table>


</div>


</div>
</body>
</html>

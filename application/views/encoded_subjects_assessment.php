<?php if($_SESSION['student_info']['PreEnrolled']): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <strong>You are pre-enrolled in this schedule by your department.</strong>        
    </div> 
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <a class="close" data-dismiss="alert">×</a>
        <h3>The following error(s) occured <!-- during your e-payment -->: </h3>
        <ul>
          <?php echo $_SESSION['error'] ?>
        </ul>
    </div> 
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
        <strong>
          <?php echo $_SESSION['success'] ?>
        </strong>
    </div> 
<?php endif; ?>

<?php if(!empty($selected_schedule)) : ?>
      
<?php 
    
    $error = FALSE;
    if($_SESSION['student_curriculum']['CollegeId'] != 6)
    {
      $TuitionFee = 10000.00;
      $CityHall = ($TuitionFee - $student_tokenfee['Amount']);

      if ( ! empty($student_tokenfee['IsPerUnit'])) 
      {
        $TuitionFee = $student_tokenfee['Amount'];
        $CityHall = 0.00;
        $_SESSION['misc_fee_payment']['Amount'] = 1.00;
      }

      if ( ! empty($per_unit_assessment)) 
      {
        if ($per_unit_assessment['promissory'] == 1) 
        {
          $_SESSION['payment_mode']['PayMode'] = "PROMISSORY";
        }
      }
      
      $Discount = $AssDetails3 ? $student_tokenfee['Amount'] * $AssDetails3['DiscountPercentage'] : 0;
      $TokenFee = $TuitionFee - $CityHall - $Discount;
    }
    else
    {
      
      $TokenFee = ! empty($assessment['grand_total']) ? $assessment['grand_total'] : 0.00;

      // NO PAYMENTS set to zero 
      if ( ! $payments) 
        $payments['Amount'] = 0.00;
      

      $misc_total = 0.00;
      // loop student_assessment to get total misc fee payment
      foreach ($student_org_payment as $misc)
        $misc_total += $misc['Amount'];

      // misc fee payment
      $_SESSION['misc_fee_payment']['Amount'] = $misc_total;
      // tuition fee payment
      $_SESSION['token_fee_payment']['Amount'] = $payments['Amount'];

      if ( ! empty($assessment['promissory']))
      {
        if ($assessment['promissory'] == 1) 
        {
          $_SESSION['payment_mode']['PayMode'] = "PROMISSORY";
        }
      }

      // dump($assessment);
      // dump($student_org_payment);
      // dump($_SESSION['payment_mode']);

    }
      // dump($_SESSION['misc_fee_payment']);
      // dump($_SESSION['token_fee_payment']);
      // if($_SESSION['student_curriculum']['CollegeId'] == 6)
      // $error = TRUE;
?>     
       
       <?php if ($_SESSION['payment_mode']): ?>

               <?php if ($_SESSION['payment_mode']['PayMode'] == "PROMISSORY"): ?>

                   <?php if ($_SESSION['misc_fee_payment']['Amount'] == 0 && $_SESSION['sy_sem']['SemId'] != 3): ?>
                      <!-- COAHS -->
                      <?php if ($_SESSION['student_curriculum']['CollegeId'] == 6) { ?>
                              <!-- message for APPROVED and ZERO PAYMENT for misc fee -->
                               <?php if ( ! empty($assessment['assessed_by'])) { ?>
                                <div class="alert alert-danger">
                                  <a class="close" data-dismiss="alert">×</a>
                                      <h4>
                                     Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                                     </h4>
                                </div>
                               <?php } else { ?>

                                <!-- waiting for APPROVAL and ZERO PAYMENT for misc fee  -->
                                 <div class="alert alert-danger">
                                   <a class="close" data-dismiss="alert">×</a>
                                       <h4>
                                        Your application is waiting for the approval at the Accounting Office. 
                                        Try to access your account 1 to 2 hours after the processing time.
                                      </h4>
                                  </div> 

                               <?php } ?> 

                      <!-- end COAHS -->
                      <?php } else { ?>

                      <!-- REGULAR PROGRAMS ZERO PAYMENT FOR MISC FEE -->
                                <div class="alert alert-danger">
                                  <a class="close" data-dismiss="alert">×</a>
                                      <h4>
                                     Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                                     </h4>
                                </div> 

                      <!-- end REGULAR PROGRAMS -->
                      <?php } ?> 



                   <?php $error = TRUE ?>
                   <?php endif ?>


               <?php else: ?>

                  <?php 
                    // ZERO ASSESSMENT 
                    if($TokenFee == 0)
                    { 
                      if ($_SESSION['misc_fee_payment']['Amount'] == 0 && $_SESSION['sy_sem']['SemId'] != 3) 
                      {
                        $error = TRUE;
                      }

                    // end ZERO ASSESSMENT
                    }
                    else
                    {
                      // ZERO MISC fee payment 
                      if ($_SESSION['misc_fee_payment']['Amount'] == 0  && $_SESSION['sy_sem']['SemId'] != 3)
                      {                        
                        $error = TRUE;
                        // student has been allowed to print cor without misc fee 2015-03-18
                        // if ($_SESSION['enrollment_trans']['DatePrint'] != '0000-00-00')
                        // $error = FALSE;
                      }
                      
                      // ZERO TUITION/TOKEN fee payment 
                      if ($_SESSION['token_fee_payment']['Amount'] == 0)
                      {
                        $error = TRUE;
                      }

                    }
                    // end of ZERO MISC/TUITION fee payment
                    
                    
                  ?>

                  <?php if ($error == TRUE): ?>
                      
                              <?php if ($_SESSION['student_curriculum']['CollegeId'] == 6) { ?>

                                      <?php if ( ! empty($assessment['assessed_by'])) { ?>
                                                                
                                          <div class="alert alert-danger">
                                            <a class="close" data-dismiss="alert">×</a>
                                                <h4>
                                               Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                                               </h4>
                                           </div> 

                                      <?php } else { ?>


                                         <div class="alert alert-danger">
                                           <a class="close" data-dismiss="alert">×</a>
                                               <h4>
                                                Your application is waiting for the approval at the Accounting Office. 
                                                Try to access your account 1 to 2 hours after the processing time.1
                                              </h4>
                                          </div> 

                                      <?php } ?>
                              

                              <?php } else { ?>

                                    <div class="alert alert-danger">
                                      <a class="close" data-dismiss="alert">×</a>
                                          <h4>
                                         Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                                         </h4>
                                     </div> 

                              <?php } ?>


                  <?php endif ?><!-- /. end TRUE ./ -->

               <?php endif ?> <!-- /. end NOT PROMI ./ -->

       <?php else: ?><!-- payment mode installment -->       

                    <?php 
                      // ZERO ASSESSMENT 
                      if($TokenFee == 0)
                      { 
                        if ($_SESSION['misc_fee_payment']['Amount'] == 0 && $_SESSION['sy_sem']['SemId'] != 3) 
                        {
                          $error = TRUE;
                        }

                      // end ZERO ASSESSMENT
                      }
                      else
                      {
                        // ZERO MISC fee payment 
                        if ($_SESSION['misc_fee_payment']['Amount'] == 0  && $_SESSION['sy_sem']['SemId'] != 3)
                        {                        
                          $error = TRUE;
                          // student has been allowed to print cor without misc fee 2015-03-18
                          // if ($_SESSION['enrollment_trans']['DatePrint'] != '0000-00-00')
                          // $error = FALSE;
                        }
                        
                        // ZERO TUITION/TOKEN fee payment 
                        if ($_SESSION['token_fee_payment']['Amount'] == 0)
                        {
                          $error = TRUE;
                        }
                        // echo dump($TokenFee);

                      }
                      // end of ZERO MISC/TUITION fee payment
                    ?>

                 <?php if ($error == TRUE): ?>
                 
                    <?php if ($_SESSION['student_curriculum']['CollegeId'] == 6) { ?>


                        <?php if ( ! empty($assessment['assessed_by'])) { ?>
                         
                         <div class="alert alert-danger">
                           <a class="close" data-dismiss="alert">×</a>
                               <h4>
                              Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                              </h4>

                          </div> 

                        <?php } /*else { ?>


                        <div class="alert alert-danger">
                          <a class="close" data-dismiss="alert">×</a>
                              <h4>
                                 Your application is waiting for the approval at the Accounting Office. 
                                 <!-- Processing time of your application will start on June 05, 2015 at 3:00 PM. -->
                                 Try to access your account 1 to 2 hours after the processing time.
                             </h4>
                         </div> 

                        <?php } */?>


                    <?php } else { ?>
                        
                          <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">×</a>
                                <h4>
                               Note: Please pay your <strong>token fee</strong> and <strong>miscellaneous fee</strong>. You are not allowed to Claim your C.O.R. until you settle this fee(s).
                               </h4>
                           </div> 


                    <?php } ?>
                 
                 <?php endif ?>            


       <?php endif ?><!-- /.end payment mode installment./ -->       
       
      <?php 
        if ( ! empty($_SESSION['skey'])) 
        {
          $studno = $_SESSION['student_info']['StudNo'];
          // check if student has no copy of notice of admission
          $this->db->where('StudNo', $studno);
          $this->db->where('is_actived', 1);
          $this->db->where('created_at >', '2017-01-01');
          $tasc = $this->db->get(DBTASC . 'exam_results')->row();
          if ( ! empty($tasc)) 
          {
             if ($_SESSION['skey'] != 'ITC@UM@K MASTER KEY IS 317') 
             {
             //  $sem_id = $_SESSION['sy_sem']['SemId'];
             //  $new_id_no = array(
             //  'B6'. substr($_SESSION['sy_sem']['SyCode'], 0, 2),            // 2nd sem new student
             //  'A' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // new student
             //  'B' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // 2nd sem new student
             //  'M' . $sem_id . substr($_SESSION['sy_sem']['SyCode'], 0, 2),  // masteral
             //  );
              

              // if (in_array(substr($studno, 0, 4), $new_id_no)) 
              // {
            
              
                if ($error == FALSE) 
                {
                  echo "<div class='alert alert-danger'>
                      <a class='close' data-dismiss='alert'>&times;</a>
                        <h4>
                              Note: Please proceed to the Registrar's office for instruction on how to claim your Certificate of Registration(COR).
                        </h4>
                  </div>"; 
                }
                $error = TRUE;
                
                
              }

              
             // }

              
          }

        }
       ?>
            
       <?php  
            // if ($_SESSION['student_curriculum']['CollegeId'] == 21)
            //   $error == TRUE;
        ?>
       <?php if ($error == FALSE && $_SESSION['student_curriculum']['CollegeId'] != 21): ?>


                      <div class="alert alert-success">
                          <!-- <a class="close" data-dismiss="alert">×</a> -->
                          <!-- <h4>Note: You only have ONE (1) ACCESS privilege for ONLINE PRINTING OF COR.</h4> -->
                          <h4>Your Online Certificate Of Registration will be sent to your UMak e-mail account after 24 hours upon payment. Thank you.</h4>
                      </div>
                      <!-- <a href="<?php #echo base_url(); ?>student/print_online_cor/" class="btn btn-success btn-large right" target="_blank"><b>CLICK HERE TO PRINT YOUR C.O.R.</b> <i class="icon-print icon-white"></i> </a> -->
                   
       <?php else: ?>

              <?php if ($_SESSION['student_curriculum']['CollegeId'] == 6) { ?>

                        <?php if ( ! empty($assessment['assessed_by'])) { ?>
                              <div class="alert alert-info">
                                  <a class="close" data-dismiss="alert">×</a>
                                    <h4>
                                          Note: Please print your online advising slip immediately.
                                    </h4>
                              </div> 
                        <?php } ?>
              
              <?php } ?>


              <?php if ($_SESSION['student_curriculum']['CollegeId'] == 6) { ?>
                

                  <?php if ( ! empty($assessment['assessed_by'])): ?> 
                    <p class="lead">
                      After PRINTING of your ADVISING SLIP proceed to COAHS office for the approval of your encoded subjects.
                    </p>
                    <a href="<?php echo base_url(); ?>student/print_encoded_subjects_assessment/" class="btn btn-warning btn-large right" target="_blank"><b>CLICK HERE TO PRINT THIS FORM</b> <i class="icon-print icon-white"></i> </a>
                  <?php endif ?>
                  
                  <?php if ( empty($assessment['payment_scheme'])): ?>
                    <a href="#myModalS" class='btn btn-large btn-warning right' data-toggle="modal"><strong>SELECT YOUR PAYMENT SCHEME HERE</strong></a>
                  <?php endif ?>


              <?php 
                    } else {  
                    /*
              ?>
                    <a href="<?php echo base_url(); ?>student/print_encoded_subjects_assessment/" class="btn btn-warning btn-large right" target="_blank"><b>CLICK HERE TO PRINT THIS FORM</b> <i class="icon-print icon-white"></i> </a>
                    
                    <?php */ ?>
                    <?php 
                    if ( ! in_array($_SESSION['enrollment_trans']['PaymentDate'], array('0000-00-00', NULL))) { ?>

                    <h2 style="font-family:arial;color:#000; border:3px solid #000; padding:2px 3px">
                    SCHEDULE OF PAYMENT: <?php echo date('F d, Y', strtotime($_SESSION['enrollment_trans']['PaymentDate'])); ?>
                    </h2>
                    <div class="row">
                      <div class="span8">
                        <h3 class="text-danger">
                          Only payments on designated dates are accepted. Please strictly follow the schedule.
                          Otherwise you will pay on the last day of scheduled payment
                        </h3>
                      </div>
                      <div class="span3">

                        <?php if($_SESSION["student_info"]["LengthOfStayBySem"] == '1' || $_SESSION["student_curriculum"]["IsGraduateProgram"] == 1 || $_SESSION["student_curriculum"]["IsTCP"] == 1 ): ?>
                        <div class="pull-right">
                        <h5>Applying for scholarship?</h5>
                        <a href="<?php echo base_url(); ?>student/print_encoded_subjects_assessment/" target="_blank" style="font-size: 90%;">
                        Click here to print advising slip<br><strong>DO NOT PRINT THIS ADVISING SLIP<br>UNLESS YOU ARE APPLYING FOR<br> SCHOLARSHIP</strong>
                        </a>
                        </div>
                     

                      <?php elseif($_SESSION['enrollment_trans']['IsPrintedAdvisingSlip'] != '1'): ?>
                        <div class="pull-right">
                        <h5>Applying for scholarship?</h5>
                        <a href="<?php echo base_url(); ?>student/print_encoded_subjects_assessment/" target="_blank" style="font-size: 90%;">
                        Click here to print advising slip<br><strong>DO NOT PRINT THIS ADVISING SLIP<br>UNLESS YOU ARE APPLYING FOR<br> SCHOLARSHIP</strong>
                        </a>
                        </div>
                        <?php endif?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="alert alert-info">
                      <h4>
                      NOTE: AFTER PAYMENT OF BOTH MISCELLANEOUS AND TOKEN FEES, YOUR OFFICIAL CERTIFICATE OF REGISTRATION  WILL BE SENT TO YOUR UMAK EMAIL ACCOUNT AFTER 24HRS. FOR SCHOLARS YOU MUST SECURE THE APPROVED SCHOLARSHIP FORM FROM MACES TO ACCOUNTING OFFICE.
                      </h4>
                    </div>


                    <?php } // endif?>

              <?php } ?>



       <?php endif ?>

     <!-- <h2>Advising Slip </h2>  -->
     <!-- <span><b>A.Y. <?php //echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></b></span> -->
     <br><br>
      
      <table class="table table-bordered table-condensed table-striped dth" >
        <thead>
          <tr>
            <th width="2%"><i class="icon-file icon-white"></i></th>
            <th width="10%">CFN</th>
            <th width="13%">Course Code</th>
            <th width="20%">Course Description</th>
            <th width="5%">Section</th>
            <th width="5%">Units</th>
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


} 


?>        

  
    <tr>
      <td><i class="icon-ok"></i></td>
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
        <th colspan ="5" >Total Units: </th>
        <th width="7%" ><?php echo number_format($totalUnits,1); ?></th>
        <th colspan="4" ></th>
        </tfoot>
    </tr>
</table>
<?php endif; ?>



<?php //if($ownedvoters==TRUE && $_SESSION['student_curriculum']['CollegeId'] != 6) : ?>


<?php if($_SESSION['student_curriculum']['CollegeId'] != 6) : ?>

<?php $this->load->view('assessment'); ?>
<?php //$this->load->view('assessment_lbp'); ?>

<?php else: ?>

<?php // echo $printbutton;?>

<?php $this->load->view('assessment_coahs'); ?>

<?php endif; ?>

<?php unset($_SESSION['error']); ?>
<?php unset($_SESSION['success']); ?>


    </table>

<?php             
/*    $timezone = "Asia/Hong_Kong";
    if(function_exists('date_default_timezone_set'))    
    date_default_timezone_set($timezone);
    $date = date('Y-m-d');
    
    $date_encode = date('Y-m-d');
    $time_encode = date('H:i:s');
               

    switch( date('N', strtotime($date_encode)) )
    {
        case 1: #mon
        case 2: #tue
        case 7: #sun
            $valid_until = date('Y-m-d', strtotime($date_encode. ' + 3 days'));
            break;
        case 3: #wed
        case 4: #thu
        case 5: #fri            
            $valid_until = date('Y-m-d', strtotime($date_encode. ' + 5 days'));
            break;
        case 6: #sat
            $valid_until = date('Y-m-d', strtotime($date_encode. ' + 4 days')); 
            break;
    }
    
    if($_SESSION['enrollment_trans']['PaymentDate'] == '0000-00-00')
    {
        $update = array('PaymentDate' => $valid_until);
        $this->db->where('Id',$_SESSION['enrollment_trans']['Id']);
        $this->db->update('tblenrollmenttrans',$update);
        // echo "been here.. $valid_until";
    }
echo $time_encode;*/

#If you have PHP >= 5.1:

#function isWeekend($date) 
#{
#    return (date('N', strtotime($date)) >= 6);
#}
#otherwise:

#function isWeekend($date) {
#    $weekDay = date('w', strtotime($date));
#    return ($weekDay == 0 || $weekDay == 6);
#}

?>    
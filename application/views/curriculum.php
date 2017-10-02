<?php if(!$this->M_assessment->getResidency($_SESSION['student_info']['StudNo']) && $this->M_assessment->ageCalculator($_SESSION['student_info']['StudNo']) <= 18):?>
  <div class="alert alert-info">
    <a class="close" data-dismiss="alert">&times;</a>
    <strong><span class="label label-important">Please Read:</span>
You are required to visit the Accounting Office for residency verification. Please refer to Change of Residency for the requirements.
    </strong>            
</div>        
<?php endif; ?>

﻿<?php if($_SESSION['student_curriculum']['CollegeId'] == 16 && $_SESSION['student_curriculum']['IsControlled'] == 1  && ! empty($selected_schedule) ): // CBDA?>
  <div class="alert alert-info">
    <a class="close" data-dismiss="alert">&times;</a>
    <strong><span class="label label-important" style='font-size:15px;'>Please Read:</span><br>
    	To save your schedule, proceed to CAL Office for verification.
    </strong>
    <br>
    <em>Requirements for 1st Year</em>
    <ul>
      <li>Photocopy of Form 138</li>
      <!-- <li>UMCAT Result</li> -->
      <li>2 x 2 Picture</li>
      <li>White Long Folder</li>
    </ul>
    <br>
    <em>Requirements for 2nd, 3rd Year &amp; 4th Year</em>
    <ul>
    <li>Report of Grades 1st &amp; 2nd sem., A.Y. 2016-2017</li>
    <li>2 x 2 Picture</li>
    </ul>
    
</div>        
<?php endif; ?>



<?php if(in_array($_SESSION['student_curriculum']['CollegeId'], array(11, 5, 3)) && $_SESSION['student_curriculum']['Controlled'] == '1' && ! empty($selected_schedule) ): ?>
  <div class="alert alert-info">
    <a class="close" data-dismiss="alert">&times;</a>
    <strong><span class="label label-important" style='font-size:15px;'>Please Read:</span><br>

    <?php if ($_SESSION['student_curriculum']['CollegeId'] == 11): ?>
      To save your schedule, proceed to COE Office for verification.
    <?php endif ?>

    <?php if ($_SESSION['student_curriculum']['CollegeId'] == 5): ?>
      To save your schedule, proceed to CGPP Office for verification.
    <?php endif ?>

    <?php if ($_SESSION['student_curriculum']['CollegeId'] == 3): ?>
      To save your schedule, proceed to CCS Office for verification.
    <?php endif ?>

    </strong>
  </div>        
<?php endif; ?>


<?php if(isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <a class="close" data-dismiss="alert">&times;</a>
            <strong>Success:
            <span class="label label-important"><?php echo $_SESSION['success']; ?></span>
            </strong>            
          </div>        
<?php endif; ?>

<?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
     <div class="alert alert-error">
        <a class="close" data-dismiss="alert">&times;</a>
        <strong>Error:
        <?php echo $_SESSION['error'];; ?>
        </strong>
    </div>
<?php endif; ?>


<?php if($_SESSION['student_info']['LengthOfStayBySem'] > 6 && $_SESSION['student_curriculum']['ProgramLevel'] == '3'): ?>
     <div class="alert alert-info">
        <a class="close" data-dismiss="alert">&times;</a>
        <strong>You are allowed to have an overload, provided it will not exceed 28 units.</strong>        
    </div>
<?php endif; ?>

 
<?php $max_u = $max_units;  ?>

<?php if(!empty($selected_schedule)) : ?>
      
      <h2>Selected Schedule <img src="<?php echo base_url(); ?>assets/img/icon_classschedule.png" class="right"></h2> 
      <h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>

      
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
    <tbody>
        <?php $totalUnits = 0;?>
        <?php $WithNstp = FALSE; ?>
        <?php $WithPE = FALSE; ?>
        <?php  foreach($selected_schedule as $keys => $subject): ?>      
        <?php   $SecondTime = $this->M_addsched->get_second_time($subject['cfn']) ?>
        <?php 
          if (substr($subject['CourseCode'], 0, 4) == 'NSTP')
          {
            $WithNstp = TRUE;
          }

          $pe_subject = array('P.E. 1', 'P.E. 2', 'P.E. 3', 'P.E. 4', 'PE 1', 'PE 2', 'PE 3', 'PE 4');
          if (in_array($subject['CourseCode'], $pe_subject))
          {
            $WithPE = TRUE;
          }
        ?>
        

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
      <td class="delete_remarks"><a rel="tooltip" data-original-title="Delete Schedule" class="delete" href="<?php echo base_url(); ?>student/delete_schedule/<?php echo $subject['cfn']; ?>" onclick="return confirm('Are you sure you want to delete the selected subject (<?php echo $subject['cfn'] . '-' . $subject['CourseCode']; ?>).')"><i class="icon-remove"></i></a></td>
      <td>
        <?php echo $subject['cfn']; ?>    
      </td>
      <td><?php echo ($subject['subject_id'] != 0 ? $subject['CourseCode'] : $subject['sub_code']); ?></td>
            <td><?php echo ($subject['subject_id'] != 0 ? $subject['CourseDesc'] : $subject['sub_desc']) ; ?></td>
            
            <td><?php echo $subject['year_section']; ?></td>        
            <td><?php echo ($subject['subject_id'] != 0 ? $subject['Units'] : $subject['units']); ?></td>               
      <td>        
        <?php if ($subject['cfn'] == "A1172319" ): ?>
                01:00 PM - 07:00 PM
        <?php else: ?>           
            <?php $sched = array_unique_key_group($sched); ?>
            <?php $ctr =0; foreach($sched as $time ): ?>          
            <?php if(count($sched) == 1 || count($sched) == $ctr+1): ?>
            <?php echo $time; ?>          
            <?php else: ?>
            <?php echo $time . '/'; ?>          
            <?php endif;?>
            <?php $ctr++; endforeach; ?> 
            <?php   echo "/".implode('/ ',$SecondTime['time_c']) ?>    
            <?php endif ?>              
            </td>

      <td>  
        <?php if ($subject['cfn'] == "A1172319" ): ?>
            AUGUST 10-12,2017
        <?php else: ?>  
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
        <?php endif; ?>          
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
        <?php  echo $subject['faculty_name']; ?>            
      </td> -->
    </tr>
    </tbody>
    <?php $totalUnits += $subject['Units']; ?>
<?php endforeach;  ?>
    <tfoot>
    <tr>        
        <th colspan ="5" >Total Units: </th>
        <th width="7%" ><?php echo number_format($totalUnits,1); ?></th>
        <th colspan="4" ></th>        
    </tr>
    </tfoot>
</table>



<?php 

if ($totalUnits <= 29 && $WithNstp == TRUE) 
{
  $totalUnits -= 3;
}

if ($WithPE == TRUE) 
$totalUnits -= 2;

// if($_SESSION['student_info']['LengthOfStayBySem'] > 6 && $_SESSION['student_curriculum']['ProgramLevel'] == '3') 
// { $max_u = 28; }
// else
// { $max_u; }

?>

<?php if($totalUnits > $max_u): ?>
     <div class="alert alert-error">
        <a class="close" data-dismiss="alert">&times;</a>
        <strong>Error:
        You have reached the maximum units allowed for this semester. Remove one or more subject to continue. 
        </strong>
    </div>
<?php endif; ?>


<?php 

  // var_dump($max_u);
  // var_dump($max_units);

	$disabled = FALSE;
	$button_status = '';
	// var_dump($_SESSION['enrollment_trans']['IsControlled']);
	// var_dump($_SESSION['student_curriculum']['CollegeId']);

  if ($_SESSION['student_curriculum']['Controlled'] == '1' && $_SESSION['enrollment_trans']['IsControlled'] == 0) 
  {
      $disabled = TRUE;
      // $button_status = 'disabled="disabled"';
  }
	
	if($totalUnits > $max_u)
	{
		$disabled = TRUE;
		// $button_status = 'disabled="disabled"';
	}
	
	if ($disabled == FALSE)
	{
		echo '<a href="#myModalC" data-toggle="modal" class="btn btn-primary btn-large"><b>SAVE SCHEDULE</b> <i class="icon-ok-sign icon-white"></i> </a>';
	}

?>

<?php endif; ?>







<?php  if ($_SESSION['student_info']['LengthOfStayBySem'] == '1'): ?>
  <?php  if( ! (in_array($_SESSION['student_curriculum']['CollegeId'], array(11, 5)) && $_SESSION['student_curriculum']['Controlled'] == '1')): ?>
  <a id="block" href="<?php echo base_url(); ?>student/show_block_schedule/" class="btn btn-primary btn-large"><b>BLOCK SECTION</b> <i class="icon-list-alt icon-white"></i> </a>   
  <?php  endif ?>

<?php  endif ?>

<?php 
  if ($block_sched) 
  {
    echo anchor('student/show_block_schedule', '<b>BLOCK SECTION</b> <i class="icon-list-alt icon-white"></i>', array('class'=>'btn btn-primary btn-large', 'id'=>'block'));
  }
 ?>

<!-- 
  <?php /* BLOCK SECTION FOR K to 12 GOING TO COLLEGE ?> 

  <?php */ ?>  
-->
      

<div class="row">
  <div class="span8">
    <h2>Course Curriculum</h2> 
    <!-- <h4>Program: <?php echo $_SESSION['student_curriculum']['ProgramDesc']; if(!empty($_SESSION['student_curriculum']['MajorDesc'])) echo 'MAJOR IN ' . $_SESSION['student_curriculum']['MajorDesc'];  ?></h4> -->

    <h4>Curriculum: <?php echo $_SESSION['student_curriculum']['CurriculumDesc']; ?></h4>
  </div>
  <div class="span3">
    <a href="#" id="btn_show" class="btn btn-primary right btn-large" style="margin-right:-65px"><b>Hide Curriculum</b> <i class="icon-chevron-up icon-white"></i>
    </a>
  </div>
</div>
<br>
<?php
if(in_array($_SESSION['student_curriculum']['CollegeId'], array('6','11')) &&  $_SESSION['student_curriculum']['CurriculumId'] != 53)
{
        $stay = array(
        1=>'First Year - First Semester' ,
        2=>'First Year - Second Semester',
        3=>'First Year - Summer',
        4=>'Second Year - First Semester',
        5=>'Second Year - Second Semester',
        6=>'Second Year - Summer',
        7=>'Third Year - First Semester',
        8=>'Third Year - Second Semester',
        9=>'Third Year - Summer',
        10=>'Fourth Year - First Semester',
        11=>'Fourth Year - Second Semester',
        12=>'Fourth Year - Summer'
        );

}
else if($_SESSION['student_curriculum']['CurriculumId'] == 53)
{
        $stay = array(1=>'First Year - First Semester' ,
        2=>'First Year - Second Semester',
        3=>'First Year - Summer',
        4=>'Second Year - First Semester',
        5=>'Second Year - Second Semester',
        6=>'Second Year - Summer',
        7=>'Third Year - First Semester',
        8=>'Third Year - Second Semester',
        9=>'Fourth Year - First Semester',
        10=>'Fourth Year - Second Semester');
        
}
else if($_SESSION['student_curriculum']['CurriculumId'] == 55) # BACHELOR OF SCIENCE IN CIVIL ENGINEERING
{
	$stay = array(
        1  => 'First Year - First Semester' , 
        2  => 'First Year - Second Semester', 
        3  => 'Second Year - First Semester', 
        4  => 'Second Year - Second Semester', 
        5  => 'Third Year - First Semester', 
        6  => 'Third Year - Second Semester',
        7  => 'Fourth Year - First Semester', 
        8  => 'Fourth Year - Second Semester',
        9  => 'Fourth Year - Summer Semester', 
        10 => 'Fifth Year - First Semester', 
        11 => 'Fifth Year - Second Semester');
}
else if($_SESSION['student_curriculum']['CurriculumId'] == 66) # DIPLOMA IN CIVIL TECHNOLOGY (DCET)
{
        $stay = array(
        1  =>'First Year - First Semester' , 
        2  =>'First Year - Second Semester', 
        3  =>'Second Year - First Semester', 
        4  =>'Second Year - Second Semester', 
        5  =>'Second Year Summer', 
        6  =>'Third Year - First Semester', 
        7  =>'Third Year - Second Semester');
}
else if(in_array($_SESSION['student_curriculum']['CurriculumId'], array(135, 191, 214))) 
{
  # BACHELOR OF SCIENCE IN CONSTRUCTION ENGINEERING TECHNOLOGY
        $stay = array(
        1  => 'First Year - First Semester' , 
        2  => 'First Year - Second Semester', 
        3  => 'First Year - Summer', 
        4  => 'Second Year - First Semester', 
        5  => 'Second Year - Second Semester', 
        6  => 'Second Year - Summer', 
        7  => 'Third Year - First Semester', 
        8  => 'Third Year - Second Semester',
        9  => 'Third Year - Summer',
        10 => 'Fourth Year - First  Semester', 
        11 => 'Fourth Year - Second Semester');
}
else if(in_array($_SESSION['student_curriculum']['CurriculumId'], array(172,190)))
{
  # BACHELOR OF SCIENCE IN CIVIL ENGINEERING 2014
  
        $stay = array(
        1  => 'First Year - First Semester',
        2  => 'First Year - Second Semester',
        3  => 'Second Year - First Semester',
        4  => 'Second Year - Second Semester',
        5  => 'Third Year - First Semester',
        6  => 'Third Year - Second Semester',
        7  => 'Fourth Year - First Semester',
        8  => 'Fourth Year - Second Semester',
        9  => 'Fourth Year - Summer Semester',
        10 => 'Fifth Year - First Semester',
        11 => 'Fifth Year - Second Semester',
      );
}
else if($_SESSION['student_curriculum']['CurriculumId'] == 144)  
{
  # BACHELOR IN PERFORMING ARTS MAJOR IN THEATER ARTS(2014)

    $stay = array(      1  => 'First Year - First Semester' , 
                            2  => 'First Year - Second Semester',
                            3  => 'First Year - Summer Semester', 
                            4  => 'Second Year - First Semester', 
                            5  => 'Second Year - Second Semester', 
                            6  => 'Second Year - Summer Semester', 
                            7  => 'Third Year - First Semester', 
                            8  => 'Third Year - Second Semester',
                            9  => 'Fourth Year - First Semester', 
                            10 => 'Fourth Year - Second Semester');             
}
else if(in_array($_SESSION['student_curriculum']['CurriculumId'], array(189, 210)))  
{
    # BACHELOR IN PHYSICAL WELLNESS MAJOR IN SPORTS MANAGEMENT

    $stay = array(    1  => 'First Year - First Semester', 
                              2  => 'First Year - Second Semester', 
                              3  => 'Second Year - First Semester', 
                              4  => 'Second Year - Second Semester', 
                              5  => 'Second Year - Summer', 
                              6  => 'Third Year - First Semester', 
                              7  => 'Third Year - Second Semester',
                              8  => 'Third Year - Summer', 
                              9  => 'Fourth Year - First Semester', 
                              10  => 'Fourth Year - Second Semester');             
}
else
{
       $stay = array(1=>'First Year - First Semester' ,
        2=>'First Year - Second Semester',
        3=>'Second Year - First Semester',
        4=>'Second Year - Second Semester',
        5=>'Third Year - First Semester',
        6=>'Third Year - Second Semester',
        7=>'Fourth Year - First Semester',
        8=>'Fourth Year - Second Semester',
        9=>'Fifth Year - First Semester',
        10=>'Fifth Year - Second Semester');  
}

?>   
<div id="curriculum">
  <?php           
  foreach($stay as $key => $bySem)
  {
  $totalUnits = 0;
  if($_SESSION['student_curriculum']['NoOfSem'] >= $key) :
  ?>
    
  <h4><?php echo $bySem; ?></h4>
  <table class="table table-bordered table-condensed table-striped dth">
  <thead>
  <tr>
    <th width="13%">Course Code</th>
    <th width="42%">Course Description</th>
    <th width="5%">Units</th>        
    <th width="20%">Remarks</th>
    <th width="20%">Pre-Requisites</th>
  </tr>
  </thead>
  <tbody>
  <?php      
  foreach($_SESSION['curriculum_template'] as $row)
    {
  ?>
    <?php
    if($row['LengthOfStayBySem'] == $key):
    $totalUnits += $row['Units'];
    ?>
    
    <tr>
    <td style="text-align:left"><?php echo $row['CourseCode']; ?></td>
    <td style="text-align:left"><?php echo $row['CourseDesc']; ?></td>
    <td><?php echo $row['Units']; ?></td>        
    <td class="remarks">
    <?php 
      if($row['Remarks'] == 'CANNOT BE ENROLLED') 
      { 
        echo '<span class="label label-important" style="cursor: pointer;" rel="tooltip" data-original-title="'. $row['Message'] .'">' . $row['Remarks'] . '</span> <a  rel="tooltip" data-original-title="'. $row['Message'] .'" href="#"><i class="fa fa-exclamation-circle" style="font-size: 18px;"></i></a>'; 
      }
      else if($row['Remarks'] == 'TAKEN' || $row['Remarks'] == 'INC')
      {
        echo '<span class="label label-info">' . $row['Remarks'] . '</span>';
      }
      else if($row['Remarks'] == 'ENROLLED')
      {
        echo '<span class="label label-warning">' . $row['Remarks'] . '</span>'; 
      }
      else 
      {          
        echo '<a class="enroll" href="'. base_url() .'student/get_schedule/'. $row['CourseId'] . '/' . $_SESSION['student_curriculum']['CollegeId'] . '/' . $_SESSION['student_curriculum']['ProgramId'] . '/' . $_SESSION['student_curriculum']['MajorId'] .'"><span class="label label-success">' . $row['Remarks'] . '</span></a>';
      }
     ?></td>
    <td><?php echo word_wrap( str_replace(',', ', ', $row['PreRequisiteCourseCode']) , 25); ?></td>
    </tr>
    
    <?php
    endif;
    }
    ?>
    </tbody>
    <tfoot>
    <tr>    
    <th colspan ="2" >Total Units: </th>
    <th width="7%" ><?php echo number_format($totalUnits,1); ?></th>
    <th colspan="5" ></th>    
    </tr>
    </tfoot>
</table>

<?php
else:        
    break;
endif;
}
?>
</div>
 



<div class="modal hide fade" id="myModalC" style="width:600px">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>CONFIRM SELECTED SCHEDULE</h3>    
  </div>
  <div class="modal-body">
I confirm that the selected schedule are the ones I want/must enroll. I also understand that these are unchangeable without the process of <b>CHANGE OF MATRICULATION</b>
  </div>
  <div class="modal-footer">
    <a href="<?php echo base_url(); ?>student/confirm_schedule" id="btnConfirmSchedule"  class="btn btn-large btn-primary"><b>Yes</b></a>    
    <a href="#" class="btn btn-large" data-dismiss="modal"><b>No</b></a>    
  </div>
</div>


<?php echo form_open('student/save_schedule','id="cfn"'); ?>
  <div class="modal hide fade" id="myModal" style="width:600px">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">&times;</a>
      <h3>SELECT SCHEDULE</h3>
      <h3></h3>
    </div>
    <div class="modal-body">



    </div>
    <div class="modal-footer">
      <input type="submit" id="btn_submit" name="btn_submit" value="Submit Course" class="btn btn-primary btn-large" style="font-weight:bold">
      <a href="#" class="btn btn-large" data-dismiss="modal" style="font-weight:bold">Close</a>    
    </div>
  </div>
<?php echo form_close(); ?>

<?php echo form_open('student/save_block_schedule','id="block_sched"'); ?>    
<div class="modal hide fade" id="myModalB" style="width:600px">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>SELECT BLOCK SCHEDULE</h3>        
  </div>
  <div class="alert alert-block">        
    <strong>Warning:</strong>
    Selecting a block schedule will delete your currently selected subjects.
  </div>
  <div class="modal-body">
  

  </div>
  <div class="modal-footer">    
    <input type="submit" id="btn_submit_block" name="btn_submit_block" value="Submit Block Section" class="btn btn-primary btn-large" style="font-weight:bold">
    <a href="#" class="btn btn-large" data-dismiss="modal" style="font-weight:bold">Close</a>    
    
  </div>
</div>
<?php unset($_SESSION['error']); ?>
<?php unset($_SESSION['success']); ?>
<?php echo form_close(); ?>

<?php if ($_SESSION['student_curriculum']['CollegeId'] == 21): ?>
  <script type="text/javascript">
    
    $('.enroll').each(function()
    {
      $(this).removeAttr('href');
    })

  </script>
<?php endif ?>
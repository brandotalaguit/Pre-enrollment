<?php
function array_unique_key_group($array) {
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
?>

<?php if(!empty($priority_subjects)): ?>
<table class="table table-bordered table-condensed table-striped dth ltl" >
		<tr>
			<th width="2%"><i class="icon-file"></i></th>
			<th width="13%">CFN</th>
			<th width="10%">Course Code</th>
			<th width="20%">Course Description</th>
			<th width="5%">Section</th>
			<th width="5%">Units</th>
			<th width="15%">Time</th>
			<th width="10%">Days</th>
			<th width="10%">Room</th>
			<!-- <th width="10%">Faculty</th> -->
		</tr>
<?php  $course_code =''; foreach($priority_subjects as $keys => $subject): ?>	
<?php  $SecondTime = $this->M_addsched->get_second_time($subject['cfn']) ?>		
<?php $course_code = $subject['CourseCode']; ?>
<?php $sched=array(); ?>
<?php 
	if($subject['time_start_mon'] != '00:00:00' && $subject['time_end_mon'] != '00:00:00') 	{				 
	$mon = array('M/'. $subject['room_id_mon'] => date('h:i A',strtotime($subject['time_start_mon'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_mon'])));
$sched = array_merge($sched,$mon);
} 
?>				

<?php if($subject['time_start_tue'] != '00:00:00' && $subject['time_end_tue'] != '00:00:00') {
$tue = array('T/'. $subject['room_id_tue'] => date('h:i A',strtotime($subject['time_start_tue'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_tue'])));
$sched = array_merge($sched,$tue);						}  
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

		<?php if($subject['ClassSize'] >= $subject['class_size']): ?>	
		<tr class="alert alert-error">
		<?php else: ?>
		<tr>
		<?php endif;?>
			<td>

			<?php if($subject['ClassSize'] >= $subject['class_size']): ?>
			<i class="icon-ban-circle" title="Closed"></i>
			<?php else: ?>
			<input type="radio" name="subject" value="<?php echo $subject['cfn']; ?>" />
			<?php endif;?>
			</td>
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
        <?php   echo "/".implode('/',$SecondTime['day_c']) ?>                  
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
<?php endforeach;  ?>
</table>
<?php endif; ?>


<?php if(!empty($subjects)) : ?>
<?php
foreach($subjects as $subject)
{
    $course_code = $subject['CourseCode'];
    break;
}
?>


<h4>OTHER SCHEDULES FOR <?php if(!empty($course_code)) echo $course_code; ?> </h4>
<table class="table table-bordered table-condensed table-striped dth ltl" >
		<tr>
			<th width="2%"><i class="icon-file"></i></th>
			<th width="13%">CFN1</th>
			<th width="10%">Course Code</th>
			<th width="20%">Course Description</th>
			<th width="5%">Section</th>
			<th width="5%">Units</th>
			<th width="15%">Time</th>
			<th width="10%">Days</th>
			<th width="10%">Room</th>
			<!-- <th width="10%">Faculty</th> -->
		</tr>
<?php  foreach($subjects as $keys => $subject): ?>			
<?php   $SecondTime = $this->M_addsched->get_second_time($subject['cfn']) ?>
<?php $sched=array(); ?>
<?php 
	if($subject['time_start_mon'] != '00:00:00' && $subject['time_end_mon'] != '00:00:00') 	{				 
	$mon = array('M/'. $subject['room_id_mon'] => date('h:i A',strtotime($subject['time_start_mon'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_mon'])));
$sched = array_merge($sched,$mon);
} 
?>				

<?php if($subject['time_start_tue'] != '00:00:00' && $subject['time_end_tue'] != '00:00:00') {
$tue = array('T/'. $subject['room_id_tue'] => date('h:i A',strtotime($subject['time_start_tue'])) . ' - ' .  date('h:i A',strtotime($subject['time_end_tue'])));
$sched = array_merge($sched,$tue);						}  
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
        
		<?php if($subject['ClassSize'] >= $subject['class_size']): ?>	
		<tr class="alert alert-error">
		<?php else: ?>
		<tr>

		<?php endif;?>
			<td>

			<?php if($subject['ClassSize'] >= $subject['class_size']): ?>
			<i class="icon-ban-circle"></i>
			<?php else: ?>
			<input type="radio" name="subject" value="<?php echo $subject['cfn']; ?>" />
			<?php endif;?>
			</td>
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
            <?php // var_dump($this->M_addsched->get_second_time($subject['cfn'])) ?>    
           
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
                echo $da[0];
            }     
           $max_c++;               
            ?>            
          <?php endforeach; ?>              
        <?php  $ctrx++; endforeach; ?>   
        <?php   echo "/".implode('/ ',$SecondTime['day_c']) ?>
        <?php endif ?>                 
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
<?php endforeach;  ?>
</table>

<?php endif; ?>
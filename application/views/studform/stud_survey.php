
<span class="row">
	<span class="col-md-12">
	<b>Direction:</b>	 Read each statement and select the number on the scale that corresponds to your perception concerning the items below.
	</span>
</span>
	<span class="row">
	<span class="col-md-4">	1 -Not Important to me</span>
</span>

<span class="row">
	<span class="col-md-4">	2 -Important to me</span>
</span>

<span class="row">
	<span class="col-md-4">	3 -I would like a little assistance</span>
</span>

<span class="row">
	<span class="col-md-4">	4 -I would like a medium assistance</span>
</span>

<span class="row">
	<span class="col-md-4">	5 -I would like a lot of assistance</span>
</span>

<span class="row">
	<?php  
		// if (isset($category)) {
		// 	foreach ($category as $row) {
		// 		if($row->id==1)
		// 		{
		// 			echo "<label>".$row->category."</label>";

		// 		}
		// 	}
		// }
	 ?>
	<table class="table table-condensed mtable " >
	<?php //
		$ctr=1;
		if (isset($question)): 
			foreach ($question as $row):
				if($row->category==1):
				
					echo "<label>".$row->question."</label>";			
	?>				
	 	<tr>
	 		<td>
	 			<?php  echo $row->question; ?>
	 			<?php  echo form_hidden('Kmsid'.$ctr, $row->question_id); ?>
	 		</td>
	 		<?php  
	 			 for ($i=1; $i <6 ; $i++) { 
	 		?>
	 		<td class="tdw">
	 			<span class="radio">
				  <label>
				    <input type="radio" name="<?php  echo 'Kms'.$ctr ?>"  value="<?php  echo $i?>" ><?php  echo $i; ?>
				  </label>
				</span>
	 		</td>			 	
	 		<?php  } ?>
	 	</tr> 	

	
	<?php  $ctr++; endif; endforeach;  endif; ?>
	</table>

	<hr>

		<?php  
			 // if (isset($category)) {
			 // 	foreach ($category as $row) {
			 // 		if($row->id==2)
			 // 		{
			 // 			echo "<label>".$row->category."</label>";
			 // 		}
			 // 	}
			 // }

		 ?>
		<table class="table table-condensed mtable " >
		<?php 
			$ctr=1;
			 if (isset($question)): 
			 	foreach ($question as $row):
			 		if($row->category==2):
					
						 echo "<label>".$row->question."</label>";			
		?>				
		 	<tr>
		 		<td >
		 			<?php  echo $row->question; ?>
		 			<?php  echo form_hidden('GAWOid'.$ctr, $row->question_id); ?>
		 		</td>
		 		<?php  
		 			for ($i=1; $i <6 ; $i++) { 
		 		?>
		 		<td class="tdw">
		 			<span class="radio">
					  <label>
					    <input type="radio" name="<?php  echo 'GAWO'.$ctr ?>"  value="<?php  echo $i?>" ><?php  echo $i; ?>
					  </label>
					</span>
		 		</td>			 	
		 		<?php  } ?>
		 	</tr> 	

		
		<?php  $ctr++; endif; endforeach;  endif; ?>
		</table>

	<hr>

	<?php  
		//  if (isset($category)) {
		//  	foreach ($category as $row) {
		//  		if($row->id==3)
		//  		{
		//  			echo "<label>".$row->category."</label>";
		//  		}
		//  	}
		// }

	 ?>
	<table class="table table-condensed mtable " >
	<?php 
		$ctr=1;
		if (isset($question)): 
			foreach ($question as $row):
				if($row->category==3):
				
					 echo "<label>".$row->question."</label>";			
	?>				
	 	<tr>
	 		<td>
	 			<?php  echo $row->question; ?>
	 			<?php  echo form_hidden('FRid'.$ctr, $row->question_id); ?>
	 		</td>
	 		<?php 
	 			for ($i=1; $i <6 ; $i++) { 
	 		?>
	 		<td  class="tdw">
	 			<span class="radio">
				  <label>
				    <input type="radio" name="<?php  echo 'FR'.$ctr ?>"  value="<?php  echo $i?>" ><?php  echo $i; ?>
				  </label>
				</span>
				
	 		</td>			 	
	 		<?php   } ?>
	 	</tr> 	

	
	<?php  $ctr++; endif; endforeach;  endif; ?>
	</table>
</span>
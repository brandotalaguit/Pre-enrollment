<table class="table table-bordered table-condensed" style="white-space: nowrap;">
		<thead>
		<tr>
			<th>date</th>
			<th>booklet</th>
			<th>ornum</th>
			<th>lastname</th>
			<th>firstname</th>
			<th>initials</th>
			<th>newstudid</th>
			<th>payment</th>			
			<th>assessment</th>
			<th>balance</th>
			<th>pay_desc</th>
			<th>semester</th>
			<th>acadyr</th>
			<th>cashuser</th>
			<th>acctuser</th>
			<th>time_start</th>
			<th>time_end</th>
		</tr>
		</thead>

		<tbody>
			<?php foreach ($payment as $row): ?>				
			<tr>
				<td><?php echo $row['date'];?></td>
				<td><?php echo $row['booklet'];?></td>
				<td><?php echo $row['ornum'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['initials'];?></td>
				<td><?php echo $row['newstudid'];?></td>
				<td><?php echo $row['payment'];?></td>
				<td><?php echo $row['assessment'];?></td>
				<td>
				<?php 
				 $balance = ($row['assessment'] - $row['payment']);
				 echo $balance;
				 ?>
				</td>
				<td><?php echo $balance == 0 ? "Full Payment" : "First Payment";?></td>
				<td><?php echo $row['semester'];?></td>
				<td><?php echo $row['acadyr'];?></td>
				<td><?php echo $row['cashuser'];?></td>
				<td><?php echo $row['acctuser'];?></td>
				<td><?php echo $row['time_start'];?></td>
				<td><?php echo $row['time_end'];?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
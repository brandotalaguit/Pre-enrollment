<table class="table table-bordered table-condensed" style="white-space: nowrap;">
		<thead>
		<tr>
			<th>date_asses</th>
			<th>lastname</th>
			<th>firstname</th>
			<th>initials</th>
			<th>newstudid</th>
			<th>college</th>
			<th>program</th>
			<th>major</th>
			<th>yr_level</th>
			<th>residency</th>
			<th>tuitionfee</th>
			<th>scho_priv</th>
			<th>assess_des</th>
			<th>assessment</th>			
			<th>acct_user</th>
			<th>time_start</th>
			<th>time_end</th>
		</tr>
		</thead>

		<tbody>
			<?php foreach ($assessment as $row): ?>				
			<tr>				
				<td><?php echo $row['date_asses'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['initials'];?></td>
				<td><?php echo $row['newstudid'];?></td>
				<td><?php echo $row['college'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['program'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['major'];?></td>
				<td><?php echo $row['yr_level'];?></td>
				<td><?php echo $row['residency'];?></td>
				<td><?php echo $row['tuitionfee'];?></td>
				<td><?php echo $row['scho_priv'];?></td>
				<td><?php echo $row['assess_des'];?></td>
				<td><?php echo $row['assessment'];?></td>
				<td><?php echo $row['acct_user'];?></td>
				<td><?php echo $row['time_start'];?></td>
				<td><?php echo $row['time_end'];?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
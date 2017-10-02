<table class="table table-bordered table-condensed" style="white-space: nowrap;">
		<thead>
		<tr>
			<th>nametable</th>
			<th>offerby</th>
			<th>subcode</th>
			<th>subdes</th>
			<th>units</th>
			<th>section</th>
			<th>lastname</th>
			<th>firstname</th>
			<th>initials</th>
			<th>newstudid</th>
			<th>exclude</th>
			<th>date_log</th>
		</tr>
		</thead>

		<tbody>
			<?php foreach ($printmas as $row): ?>				
			<tr>
				<td><?php echo $row['nametable'];?></td>
				<td><?php echo $row['offerby'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['subcode'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['subdes'];?></td>
				<td><?php echo $row['units'];?></td>
				<td><?php echo $row['section'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['initials'];?></td>
				<td><?php echo $row['newstudid'];?></td>
				<td><?php echo $row['exclude'];?></td>
				<td><?php echo $row['date_log'];?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
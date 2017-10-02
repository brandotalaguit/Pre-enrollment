<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table class="table table-bordered table-condensed" style="white-space: nowrap;">
		<thead>
		<tr>
			<th>date_ncode</th>
			<th>date_print</th>
			<th>lastname</th>
			<th>firstname</th>
			<th>initials</th>
			<th>newstudid</th>
			<th>collegeId</th>
			<th>college</th>
			<th>programId</th>
			<th>program</th>
			<th>majorId</th>
			<th>major</th>
			<th>yr_level</th>
			<th>opt1</th>
			<th>opt2</th>
			<th>opt3</th>
			<th>opt_mkt</th>
			<th>opt_nonmkt</th>
			<th>tuitionfee</th>
			<th>scho_priv</th>
			<th>assess_des</th>
			<th>assessment</th>
			<th>street</th>
			<th>barangay</th>
			<th>city</th>
			<th>nstp</th>
			<th>lab</th>
			<th>guardian</th>
			<th>staff</th>
			<th>acct_user</th>
			<th>bday</th>
			<th>time_start</th>
			<th>time_end</th>
			<th>PaymentDate</th>
		</tr>
		</thead>

		<tbody>
			<?php foreach ($printsec as $row): ?>				
			<tr>
				<td><?php echo $row['date_ncode'];?></td>
				<td><?php echo $row['date_print'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['initials'];?></td>
				<td><?php echo $row['newstudid'];?></td>
				<td><?php echo $row['collegeId'];?></td>
				<td><?php echo $row['college'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['programId'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['program'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['majorId'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['major'];?></td>
				<td>
				<?php 
				$YearLevel = explode(" ",$this->M_enroll->get_year_level($row['CurriculumId'], $row['CollegeId'], $row['LengthOfStayBySem']));
				if($YearLevel[0] == "First")
				echo "1st " . $YearLevel[1];
				elseif($YearLevel[0] == "Second")
				echo "2nd " . $YearLevel[1];
				elseif($YearLevel[0] == "Third")
				echo "3rd " . $YearLevel[1];
				elseif($YearLevel[0] == "Fourth")
				echo "4th " . $YearLevel[1];
				elseif($YearLevel[0] == "Fifth")
				echo "5th " . $YearLevel[1];
				else
				echo $YearLevel[0] . $YearLevel[1];
				?>
				</td>
				<td><?php echo $row['opt1'];?></td>
				<td><?php echo $row['opt2'];?></td>
				<td><?php echo $row['opt3'];?></td>
				<td><?php echo $row['opt_mkt'];?></td>
				<td><?php echo $row['opt_nonmkt'];?></td>
				<td><?php echo $row['tuitionfee'];?></td>
				<td><?php echo $row['scho_priv'];?></td>
				<td><?php echo $row['assess_des'];?></td>
				<td><?php echo $row['assessment'];?></td>
				<td style="white-space: nowrap;"><?php echo $row['street'];?></td>
				<td><?php echo $row['barangay'];?></td>
				<td><?php echo $row['city'];?></td>
				<td><?php echo $row['nstp'];?></td>
				<td><?php echo $row['lab'];?></td>
				<td><?php echo $row['Guardian'];?></td>
				<td><?php echo $row['staff'];?></td>
				<td><?php echo $row['acct_user'];?></td>
				<td><?php echo $row['bday'];?></td>
				<td><?php echo $row['time_start'];?></td>
				<td><?php echo $row['time_end'];?></td>
				<td><?php echo $row['PaymentDate'];?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
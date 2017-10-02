<table class="table table-bordered table-condensed" style="white-space: nowrap;">
		<thead>
		<tr>
			<th>date</th>
			<th>newstudid</th>
			<th>lastname</th>
			<th>firstname</th>
			<th>initials</th>
			<th>college</th>
			<th>program</th>
			<th>major</th>
			<th>yr_level</th>
			<th>detour</th>
			<th>jfinex</th>
			<th>jma</th>
			<th>jpms</th>
			<th>jpia</th>
			<th>kafil</th>
			<th>mathsoc</th>
			<th>pesco</th>
			<th>pnsa</th>
			<th>polsci</th>
			<th>psychsoc</th>
			<th>sfop</th>
			<th>sms</th>
			<th>ssg</th>
			<th>sgp</th>
			<th>comsoc</th>
			<th>concen</th>
			<th>umakfilm</th>
			<th>spl</th>
			<th>ctm_1</th>
			<th>picecet</th>
			<th>biosci</th>
			<th>insurance</th>
			<th>nets</th>
			<th>ingles</th>
			<th>total</th>
			<th>assessedby</th>
			<th>paymentdate</th>
		</tr>
		</thead>

		<tbody>
			<?php foreach ($miscfee as $row): ?>				
			<tr>								
				<td><?php echo $row['date'];?></td>
				<td><?php echo $row['newstudid'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['initials'];?></td>
				<td><?php echo $row['college'];?></td>
				<td><?php echo $row['program'];?></td>
				<td><?php echo $row['major'];?></td>
				<td><?php echo $row['yr_level'];?></td>
				<td>
					<?php 
						$a1 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',3)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a1['amount'];
					?>
				</td>
				<td>
					<?php 
						$a2 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',5)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a2['amount'];
					?>
				</td>
				<td>
					<?php 
						$a3 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',6)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a3['amount'];
					?>
				</td>
				<td>
					<?php 
						$a4 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',8)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a4['amount'];
					?>
				</td>
				<td>
					<?php 
						$a5 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',7)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a5['amount'];
					?>
				</td>
				<td>
					<?php 
						$a6 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',9)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a6['amount'];
					?>
				</td>
				<td>
					<?php 
						$a7 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',10)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a7['amount'];
					?>
				</td>				
				<td>
					<?php 
						$a8 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',17)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a8['amount'];
					?>
				</td>
				<td>
					<?php 
						$a10 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',11)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a10['amount'];
					?>
				</td>
				<td>
					<?php 
						$a11 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',12)
								->get('tblassessmentinfo')
								->row_array();		
						echo $a11['amount'];
					?>
				</td>
				<td>
					<?php 
						$a12 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',13)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a12['amount'];
					?>
				</td>
				<td>
					<?php 
						$a13 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',14)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a13['amount'];
					?>
				</td>
				<td>
					<?php 
						$a14 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',15)
								->get('tblassessmentinfo')
								->row_array();
						echo $a14['amount'];
					?>
				</td>
				<td>
					<?php 
						$a9 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',24)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a9['amount'];
					?>
				</td>
				<td>
					<?php 
						$a15 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',25)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a15['amount'];
					?>
				</td>
				<td>
					<?php 
						$a16 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',1)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a16['amount'];
					?>
				</td>
				<td>
					<?php 
						$a17 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',2)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a17['amount'];
					?>
				</td>
				<td>
					<?php 
						$a18 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',23)
								->get('tblassessmentinfo')
								->row_array();
						echo $a18['amount'];
					?>
				</td>
				<td>
					<?php 
						$a19 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',18)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a19['amount'];
					?>
				</td>
				<td>
					<?php 
						$a20 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',4)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a20['amount'];
					?>
				</td>
				<td>
					<?php 
						$a21 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',28)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a21['amount'];
					?>
				</td>
				<td>
					<?php 
						$a22 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')							
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',29)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a22['amount'];
					?>
				</td>
				<td>
					<?php 
						$a23 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',31)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a23['amount'];
					?>
				</td>
				<td>
					<?php 
						$a24 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',32)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a24['amount'];
					?>
				</td>
				<td>
					<?php 
						$a25 = $this->db->select('SUM(amount) as amount',FALSE)
								->join('tblfees','tblassessmentinfo.feeid = tblfees.feeid','left')
								->join('tblassessmenttrans','tblassessmentinfo.assid = tblassessmenttrans.assid','left')
								->where('tblassessmenttrans.StudNo',$row['newstudid'])
								->where('tblassessmentinfo.feeid',33)
								->get('tblassessmentinfo')
								->row_array();								
						echo $a25['amount'];
					?>
				</td>
				<td>
					<?php 
						echo $a1['amount']+$a2['amount']+$a3['amount']+$a4['amount']+$a5['amount']+$a6['amount']+$a7['amount']+$a8['amount']+$a9['amount']+$a10['amount']+$a11['amount']+$a12['amount']+$a13['amount']+$a14['amount']+$a15['amount']+$a16['amount']+$a17['amount']+$a18['amount']+$a19['amount']+$a20['amount']+$a21['amount']+$a22['amount']+$a23['amount']+$a24['amount']+$a25['amount'];
					?>
				</td>
				<td><?php echo $row['assessedby'];?></td>
				<td><?php echo $row['PaymentDate'];?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
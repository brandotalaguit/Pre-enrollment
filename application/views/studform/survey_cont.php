
<label>HEALTH PROBLEMS  (Please choose from the list)</label>
<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]"   value="Physical Deformity"> Physical Deformity
		</label>
	</span>
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]"   value="Sexually Transmitted Disease" > Sexually Transmitted Disease
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]" value="Physical Disability">Physical Disability
		</label>					
	</span>
	<span class="col-md-5">
		<label class="checkbox-inline">
		  <input type="checkbox"  name="hp[]" values="Skin Problems"> Skin Problems
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]"  value= "Eye Problem"> Eye Problem
		</label>
	</span>
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]"   value="Sleeping Disorder"> Sleeping Disorder
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="hp[]"   value="Mouth/Teeth Problems"> Mouth/Teeth Problems
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" id="Disease"  > Disease					  
		</label>					
	</span>
	
</span>

<span class="row">				
	<span class="col-md-3 col-md-offset-6" id="others" hidden>					
		 <input type="text" name="hp[]"  class="form-control" > 				  
	</span>
	
</span>

<span class="row">
	<span class="col-md-5 ">Are you currently taking medication?</span>
	<span class="col-md-5">	
		<label class="radio-inline">
		  <input type="radio" name="hpq1"  value="1"> Yes
		</label>
		<label class="radio-inline">
		  <input type="radio" name="hpq1"  value="0"> No
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5 ">Have you previously taken medication?</span>
	<span class="col-md-5">	
		<label class="radio-inline">
		  <input type="radio" name="hpq2"  value="1" > Yes
		</label>
		<label class="radio-inline">
		  <input type="radio" name="hpq2"  value="0" > No
		</label>
	</span>
</span>

<span class="row">
	<label>GUIDANCE AND COUSENLING PROGRAM OF UMAK</label>
</span>

<span class="row">
	<span class="col-md-5 ">1. Have you ever been or are you now involved in counseling?</span>
	<span class="col-md-5">	
		<label class="radio-inline">
		  <input type="radio" name="gcp1"  value="1" <?php // if(isset($_POST['gcp1']) && $_POST['gcp1'] == "1")echo "checked"; ?>> Yes
		</label>
		<label class="radio-inline">
		  <input type="radio" name="gcp1"  value="0" <?php // if(isset($_POST['gcp1']) && $_POST['gcp1'] == "0")echo "checked"; ?>> No
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5 paddingTop">2. Before today, did you know about UMAK's Guidance and Counseling?</span>
	<span class="col-md-5">	
		<label class="radio-inline">
		  <input type="radio" name="gcp2" id="gc1"  value="1" <?php // if(isset($_POST['gcp2']) && $_POST['gcp2'] == "1")echo "checked"; ?>> Yes
		</label>
		<label class="radio-inline">
		  <input type="radio" name="gcp2" id="gc2"  value="0" <?php // if(isset($_POST['gcp2']) && $_POST['gcp2'] == "0")echo "checked"; ?>> No
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5 paddingTop">3. if Yes, how did you learn about our Guidance Center??</span>

	<span class="col-md-5" >	
		<span class="row">
			<span class="col-md-12 col-sm-12" style="padding:0">
				<label class="checkbox-inline  " style="padding-top:0">
				  <input type="checkbox" name="y[]" id="y1"   value="Teacher/Adviser referral" disabled>Teacher/Adviser referral
				</label>
				<label class="checkbox-inline" style="padding-top:0">
				  <input type="checkbox" name="y[]" id="y2"   value="Guidance advocate" disabled>Guidance advocate
				</label>
			</span>
		</span>

		<span class="row">
			<span class="col-md-12 col-sm-12" style="padding:0">
				<label class="checkbox-inline " style="paddingt-top:0">
				  <input type="checkbox" name="y[]" id="y3"  value="Schoolmate/s" disabled>Schoolmate/s
				</label>
				<label class="checkbox-inline " style="padding-top:0">
				  <input type="checkbox" name="y[]" id="y4"  value="By Myself" disabled>By Myself
				</label>
			</span>
		</span>			
	</span>
</span>
<span class="row">
	<label>PLEASE CHECK THE APPROPRIATE PROBLEMS THAT YOU EXPERIENCE</label>
</span>
<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Depression"> Depression
		</label>
	</span>
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox"  name="pce[]" value="Poor Academic Performance"> Poor Academic Performance
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Lack of Career Direction">Lack of Career Direction
		</label>					
	</span>
	<span class="col-md-5">
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]" value="Stress"> Stress
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Panic Attack"> Panic Attack
		</label>
	</span>
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Anxiety"> Anxiety
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]" value="Alcohol Abuse"> Alcohol Abuse
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Drug Abuse"> Drug Abuse
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Grief/Loss"> Grief/Loss
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]" value="Loneliness"> Loneliness
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox"  name="pce[]" value="Assertiveness"> Assertiveness
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Self-Condidence"> Self-Condidence
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]" value="Identity Crisis"> Identity Crisis
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Communication"> Communication
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Shyness"> Shyness
		</label>
	</span>

	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="ADD/ADHD/ODD"> ADD/ADHD/ODD
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="pce[]"  value="Homesickness"> Homesickness
		</label>
	</span>
	
</span>
<br>
<span class="row">

	<span class="col-md-5">
		<label>Abuse/Harassment</label>	
		<span class="row">
			<span class="col-md-12">
				<label class="checkbox-inline">
				  <input type="checkbox" name="ah[]"  value="Physical"> Physical
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="ah[]"  value="Verbal"> Verbal
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="ah[]"  value="Sexual"> Sexual
				</label>
			</span>
		</span>
		
	</span>
	
</span>

<br>
<span class="row">

	<span class="col-md-5">
		<label>Relationship Conflict</label>	
		<span class="row">
			<span class="col-md-12 col-sm-12">
				<label class="checkbox-inline">
				  <input type="checkbox" name="rc[]"  value="Dating "> Dating 
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="rc[]"  value="Friend"> Friend
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="rc[]" value="Sexuality"> Sexuality
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="rc[]" value="Room mate"> Room mate
				</label>
			</span>
		</span>
		
	</span>
	
</span>

<br>
<span class="row">

	<span class="col-md-5">
		<label>Rape</label>	
		<span class="row">
			<span class="col-md-12">
				<label class="checkbox-inline">
				  <input type="checkbox" name="r[]" value="Stranger"> Stranger 
				</label>

				<label class="checkbox-inline">
				  <input type="checkbox" name="r[]"  value="Acquaintace"> Acquaintace
				</label>

				
			</span>
		</span>
		
	</span>
	
</span>
<span class="row">
	<label>WHAT SERVICE YOU WOULD LIKE TO BE EXTENDED BY THE GUIDANCE AND COUNSELING CENTER TO YOU, PLEASE CHECK</label>
</span>
<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="service[]" value="Academic/Tutorial Lessons"> Academic/Tutorial Lessons
		</label>
	</span>
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="service[]" value="On-Line/Journal Counseling"> On-Line/Journal Counseling
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="service[]" value="Various Seminars/Training">Various Seminars/Training
		</label>					
	</span>
	<span class="col-md-5">
		<label class="checkbox-inline">
		  <input type="checkbox" name="service[]" value="Peer Monitoring Program"> Peer Monitoring Program
		</label>
	</span>
</span>

<span class="row">
	<span class="col-md-5">	
		<label class="checkbox-inline">
		  <input type="checkbox" name="service[]"  value="Psychological/Personality Assesment"> Psychological/Personality Assesment
		</label>
	</span>
	
</span>	

<span class="row">
	<button type="submit" class="btn btn-success">Submit</button>
</span>
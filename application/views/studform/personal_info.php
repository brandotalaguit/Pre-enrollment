
<div class="col-md-11">
	<div class="row">
		<div class="col-sm-3 form-group <?php  if(form_error('bday'))echo "has-error"; ?>">
			<label><strong>Date of Birth</strong> <i class="redasterisk">*</i></label>
    		<input type="date" class="form-control" id="birthdate" name="bday" value="<?php echo $this->input->post('bday') ?>">
		</div>	
		<div class="col-sm-3 form-group <?php if(form_error('bplace'))echo "has-error"; ?>">
			<label><strong>Place of Birth</strong></label>
      		<input type="text" class="form-control" name="bplace" value="<?php echo $this->input->post('bplace') ; ?>">
		</div>
		<div class="col-sm-3 form-group <?php if(form_error('age'))echo "has-error"; ?>">
			<label><strong>Age</strong></label>
      		<input type="text" class="form-control col-md-1" name="age" readonly value="" id="resultBday" value="<?php  echo $this->input->post('bplace'); ?>">
		</div>	
	</div>
	<div class="row">
		<div class="col-md-3 form-group <?php if(form_error('religion'))echo "has-error"; ?>">
	      <label><strong>Religion</strong> <i class="redasterisk">*</i></label>
	      <input type="text" class="form-control" name="religion" value="<?php echo $this->input->post('religion'); ?>">
	    </div>

		<div class="col-md-3 form-group <?php if(form_error('nickname'))echo "has-error"; ?>">
	      <label><strong>Nickname</strong></label>
	      <input type="text" class="form-control" name="nickname" value="<?php echo $this->input->post('nickname'); ?>">
	    </div>

		<div class="col-md-3 form-group <?php if(form_error('nationality'))echo "has-error"; ?>">
	      <label><strong>Nationality</strong></label>
	      <input type="text" class="form-control" name="nationality" value="<?php  $this->input->post('nationality'); ?>">
	    </div>
	</div>
	<div class="row">
		<!-- <label class="col-md-1 control-label"><strong>Address <i class="redasterisk">*</i></strong></label> -->
		<h4 class="sub-header">
			<span>Address <i class="redasterisk">*</i></span>
		</h4>
		<div class="col-md-3 form-group <?php if(form_error('addStreet'))echo "has-error"; ?>">
	      <lable><strong>Street</strong></lable>
	      <input type="text" class="form-control" name="addStreet" value="<?php echo $this->input->post('addStreet'); ?>" >
	    </div>
	    <div class="col-md-3 form-group <?php if(form_error('addBarangay'))echo "has-error"; ?>">
	      <lable><strong>Barangay</strong></lable>
	      <input type="text" class="form-control" name="addBarangay" value="<?php if(isset($_POST['addBarangay'])) echo $_POST['addBarangay']; ?>">
	    </div>
	    <div class="col-md-3 form-group <?php if(form_error('addCity'))echo "has-error"; ?>">
	      <lable><strong>City</strong></lable>
	      <input type="text" class="form-control" name="addCity" value="<?php if(isset($_POST['addCity'])) echo $_POST['addCity']; ?>">
	    </div>
	    <div class="col-md-1"></div>
	    <div class="col-md-9 <?php if(form_error('prov_address'))echo "has-error"; ?>">
	      <lable><strong>Provincial Address</strong></lable>
	      <input type="text" class="form-control col-md-12" name="prov_address" value="<?php if(isset($_POST['prov_address'])) echo $_POST['prov_address']; ?>">
	    </div>
	</div>
	<div class="row">
		<div class="col-md-5 control-group">
		  <label class="control-label" for="radios"><strong>Gender</strong></label>
		  <div class="controls">
		    <label class="radio inline" for="radios-0" style="margin-top:0">
		      <input type="radio" name="sex" id="radios-0" value="male" checked="checked">
		      <span>Male</span>
		    </label>
		    <label class="radio inline" for="radios-1">
		      <input type="radio" name="sex" id="radios-1" value="female">
		      <span>Female</span>
		    </label>
		    <label class="radio inline" for="radios-2">
		      <input type="radio" name="sex" id="radios-2" value="3">
		      <span>Sexual Preference</span>
		       <input type="text" class="form-control" id="sexpreferencetext" name="sexpreferencetext" value="<?php if(isset($_POST['sexpreferencetext']))echo  $_POST['sexpreferencetext']; ?>" readonly >
		    </label>
		  </div>
		</div>
		<div class="col-sm-3 form-group <?php  if(form_error('civil_status')) echo "has-error"; ?>">
			<label><strong>Civil Status</strong></label>
			<select class="form-control" name="civil_status" id="civil_status">
			  <option value="default" <?php  if(isset($_POST['civil_status']) && $_POST['civil_status'] == "default"){echo "selected";} ?>>- Select Status -</option>
			  <option value="Single" <?php  if(isset($_POST['civil_status']) && $_POST['civil_status'] == "Single"){echo "selected";} ?>>Single</option>
			  <option value="Married" <?php  if(isset($_POST['civil_status']) && $_POST['civil_status'] == "Married"){echo "selected";} ?>>Married</option>
			  <option value="Widow" <?php  if(isset($_POST['civil_status']) && $_POST['civil_status'] == "Widow"){echo "selected";} ?>>Widow</option>
			</select>
		</div>		
	</div>
	<div class="row">
	    <div class="col-md-4 form-group <?php  if(form_error('dialect'))echo "has-error"; ?>">
	      <lable><strong>Language/s or Dialect/s Spoken <i class="redasterisk">*</i></strong></lable>
	      <input type="text" class="form-control"  name="dialect" value="<?php  if(isset($_POST['dialect'])) echo $_POST['dialect']; ?>">
	    </div>
		<div class="col-md-3 form-group <?php  if(form_error('hobbies'))echo "has-error"; ?>">
	      <lable><strong>Hobbies/Interests <i class="redasterisk">*</i></strong></lable>
	      <input type="text" class="form-control"  name="hobbies" value="<?php  if(isset($_POST['hobbies'])) echo $_POST['hobbies']; ?>">
	    </div>
	    <div class="col-md-3 form-group <?php  if(form_error('talents'))echo "has-error"; ?>">
	      <lable><strong>Other Talents/Abilities <i class="redasterisk">*</i></strong></lable>
	      <input type="text" class="form-control"  name="talents" value="<?php  if(isset($_POST['talents'])) echo $_POST['talents']; ?>">
	    </div>
	</div>
	<div class="row togglers" id="Married" style="display: none;">
		<h4 class="sub-header">
			<span>If Married <i class="redasterisk">*</i></span>
		</h4>
		<div class="form-group col-md-7 <?php  if(form_error('spouse_name'))echo "has-error"; ?>">
			<label>Spouse Name(Last, First, Middle)</label>
	      	<input type="text" class="form-control col-sm-11" name="spouse_name" value="<?php  if(isset($_POST['spouse_name'])) echo $_POST['spouse_name']; ?>">
		</div>

		<div class="col-md-3 form-group <?php  if(form_error('marriagedate'))echo "has-error"; ?>">
			<label>Date of Marriage</label>
		      <input type="date" class="form-control" name="marriagedate" value="<?php  if(isset($_POST['marriagedate'])) echo $_POST['marriagedate']; ?>">
		</div>

		<div class="col-md-7 form-group <?php  if(form_error('marriageplace'))echo "has-error"; ?>">
		    <label>Place of Marriage</label>
		      <input type="text" class="form-control col-sm-11" name="marriageplace" value="<?php  if(isset($_POST['marriageplace'])) echo $_POST['marriageplace']; ?>">
		</div>

		<div class="col-md-3 form-group <?php  if(form_error('spouse_occupation'))echo "has-error"; ?>">
			<label>Spouse Occupation</label>
		    <input type="text" class="form-control" name="spouse_occupation" value="<?php  if(isset($_POST['spouse_occupation'])) echo $_POST['spouse_occupation']; ?>">
		</div>
		<div class="clearfix"></div>
		 <div class="col-md-4 form-group <?php  if(form_error('spouse_empname'))echo "has-error"; ?>">
		    <label>Employer's Name</label>
		    <input type="text" class="form-control col-sm-11" name="spouse_empname" value="<?php  if(isset($_POST['spouse_empname'])) echo $_POST['spouse_empname']; ?>">
		</div>

		<div class="col-md-3 form-group <?php  if(form_error('spouse_bday'))echo "has-error"; ?>">
			<label>Date of Birth</label>
		    <input type="date" class="form-control" name="spouse_bday" value="<?php  if(isset($_POST['spouse_bday'])) echo $_POST['spouse_bday']; ?>">
		</div>

		 <div class="col-md-3 form-group <?php  if(form_error('spouse_contact'))echo "has-error"; ?>">
		    <label>Contact Number</label>
		      <input type="number" class="form-control" name="spouse_contact" value="<?php  if(isset($_POST['spouse_contact'])) echo $_POST['spouse_contact']; ?>">
		</div>
		<div class="clearfix"></div>
		<div class="col-md-2 form-group <?php  if(form_error('no_child'))echo "has-error"; ?>">
			<label>No. of Children</label>
		      <input type="number" class="form-control no_child col-sm-6" name="no_child" min="0" value="<?php  if(isset($_POST['no_child'])) echo $_POST['no_child']; ?>">
		</div>
		<div class="col-md-9 form-group">
		    <label style="margin-top: 10px;">(Please list the Name/s, Age, Education or Occupation start with eldest)</label>
		</div>
		<div id="no_child_textbox">
		</div>
	</div>	
</div>

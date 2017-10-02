
<div class="table-responsive">
	<table class="table table-responsive">
        <thead>
          <tr>
            <th>Level</th>
            <th>Name of School</th>
            <th>Honors/Awards</th>
            <th>Year Graduated</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Kindergarten</td>
            <td <?php // if(form_error('kindernos'))echo "has-error"; ?>><input type="text" class="form-control" name="kindernos" value="<?php // if(isset($_POST['kindernos']))echo $_POST['kindernos'] ?>"></td>
            <td <?php // if(form_error('kinderhonor'))echo "has-error"; ?>><input type="text" class="form-control" name="kinderhonor" value="<?php // if(isset($_POST['kinderhonor']))echo $_POST['kinderhonor'] ?>"></td>
            <td <?php // if(form_error('kinderyeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="kinderyeargrad" value="<?php // if(isset($_POST['kinderyeargrad']))echo $_POST['kinderyeargrad'] ?>"></td>
          </tr>
          <tr>
            <td>Elementary</td>
            <td <?php // if(form_error('elemnos'))echo "has-error"; ?>><input type="text" class="form-control" name="elemnos" value="<?php // if(isset($_POST['elemnos']))echo $_POST['elemnos'] ?>"></td>
            <td <?php // if(form_error('elemhonor'))echo "has-error"; ?>><input type="text" class="form-control" name="elemhonor" value="<?php // if(isset($_POST['elemhonor']))echo $_POST['elemhonor'] ?>"></td>
            <td <?php // if(form_error('elemyeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="elemyeargrad" value="<?php // if(isset($_POST['elemyeargrad']))echo $_POST['elemyeargrad'] ?>"></td>
          </tr>
          <tr>
            <td>Secondary</td>
            <td <?php // if(form_error('secondarynos'))echo "has-error"; ?>><input type="text" class="form-control" name="secondarynos" value="<?php // if(isset($_POST['secondarynos']))echo $_POST['secondarynos'] ?>"></td>
            <td <?php // if(form_error('secondaryhonor'))echo "has-error"; ?>><input type="text" class="form-control" name="secondaryhonor" value="<?php // if(isset($_POST['secondaryhonor']))echo $_POST['secondaryhonor'] ?>"></td>
            <td <?php // if(form_error('secondaryyeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="secondaryyeargrad" value="<?php // if(isset($_POST['secondaryyeargrad']))echo $_POST['secondaryyeargrad'] ?>"></td>
          </tr>
          <tr> 
            <td>Senior Highschool</td>
            <td <?php // if(form_error('seniornos'))echo "has-error"; ?>><input type="text" class="form-control" name="seniornos" value="<?php // if(isset($_POST['seniornos']))echo $_POST['seniornos'] ?>"></td>
            <td <?php // if(form_error('seniorhonor'))echo "has-error"; ?>><input type="text" class="form-control" name="seniorhonor" value="<?php // if(isset($_POST['seniorhonor']))echo $_POST['seniorhonor'] ?>"></td>
            <td <?php // if(form_error('senioryeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="senioryeargrad" value="<?php // if(isset($_POST['senioryeargrad']))echo $_POST['senioryeargrad'] ?>"></td>
          </tr>
          <tr>
            <td>TESDA</td>
            <td <?php // if(form_error('tesdanos'))echo "has-error"; ?>><input type="text" class="form-control" name="tesdanos" value="<?php // if(isset($_POST['tesdanos']))echo $_POST['tesdanos'] ?>"></td>
            <td <?php // if(form_error('tesdahonor'))echo "has-error"; ?>><input type="text" class="form-control" name="tesdahonor" value="<?php // if(isset($_POST['tesdahonor']))echo $_POST['tesdahonor'] ?>"></td>
            <td <?php // if(form_error('tesdayeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="tesdayeargrad" value="<?php // if(isset($_POST['tesdayeargrad']))echo $_POST['tesdayeargrad'] ?>"></td>
          </tr>
          <tr>
            <td>College</td>
            <td <?php // if(form_error('collegenos'))echo "has-error"; ?>><input type="text" class="form-control" name="collegenos" value="<?php // if(isset($_POST['collegenos']))echo $_POST['collegenos'] ?>"></td>
            <td <?php // if(form_error('collegehonor'))echo "has-error"; ?>><input type="text" class="form-control" name="collegehonor" value="<?php // if(isset($_POST['collegehonor']))echo $_POST['tesdayeargrad'] ?>"></td>
            <td <?php // if(form_error('collegeyeargrad'))echo "has-error"; ?>><input type="text" class="form-control" name="collegeyeargrad" value="<?php // if(isset($_POST['collegeyeargrad']))echo $_POST['collegeyeargrad'] ?>"></td>
          </tr>
        </tbody>
    </table>
</div>	
<fieldset><legend><center>NATIONAL EXAMINATION TAKEN</center></legend></fieldset>
<div class="table-responsive">
		<table class="table table-responsive">
        <thead>
          <tr>
            <th>EXAM TAKEN</th>
            <th>School Year/Exam Date</th>
            <th>Testing Center</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>NCAE</td>
            <td <?php // if(form_error('ncaedate'))echo "has-error"; ?>><input type="text" class="form-control" name="ncaedate" value="<?php // if(isset($_POST['ncaedate']))echo $_POST['ncaedate'] ?>"></td>
            <td <?php // if(form_error('ncaetc'))echo "has-error"; ?>><input type="text" class="form-control" name="ncaetc" value="<?php // if(isset($_POST['ncaetc']))echo $_POST['ncaetc'] ?>"></td>
          </tr>
          <tr>
            <td>NAT</td>
            <td <?php // if(form_error('natdate'))echo "has-error"; ?>><input type="text" class="form-control" name="natdate" value="<?php // if(isset($_POST['natdate']))echo $_POST['natdate'] ?>"></td>
            <td <?php // if(form_error('nattc'))echo "has-error"; ?>><input type="text" class="form-control" name="nattc" value="<?php // if(isset($_POST['nattc']))echo $_POST['nattc'] ?>"></td>
          </tr>
          <tr>
            <td>NCI/NCII</td>
            <td <?php // if(form_error('nc2date'))echo "has-error"; ?>><input type="text" class="form-control" name="nc2date" value="<?php // if(isset($_POST['nc2date']))echo $_POST['nc2date'] ?>"></td>
            <td <?php // if(form_error('nc2tc'))echo "has-error"; ?>><input type="text" class="form-control" name="nc2tc" value="<?php // if(isset($_POST['nc2tc']))echo $_POST['nc2tc'] ?>"></td>
          </tr>
          <tr>
            <td>COURSE TAKEN/SPECIALIZATION</td>
            <td <?php // if(form_error('coursedate'))echo "has-error"; ?>><input type="text" class="form-control" name="coursedate" value="<?php // if(isset($_POST['coursedate']))echo $_POST['coursedate'] ?>"></td>
            <td <?php // if(form_error('coursetc'))echo "has-error"; ?>><input type="text" class="form-control" name="coursetc" value="<?php // if(isset($_POST['coursetc']))echo $_POST['coursetc'] ?>"></td>
          </tr>
        </tbody>
    </table>
</div>
<div class="form-group">
    <div class="col-md-11">
      	<label for="inputEmail3" class="col-md-6 control-label">Who financially supports your education?</label>
    </div>
</div>
<div class="form-group">
	<div class="col-md-offset-1 col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="bothparents" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "bothparents") echo "checked"; ?>>
			    	Both Parents
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="Father" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "Father") echo "checked"; ?>>
			    	Father
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="Mother" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "Mother") echo "checked"; ?>>
			    	Mother
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="Brother/Sister" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "Brother/Sister") echo "checked"; ?>>
			    	Brother/Sister
			  </label>
			</div>
	    </div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-offset-1 col-md-3">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="Relative/Non-relative" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "Relative/Non-relative") echo "checked"; ?>>
			    	Relative/Non-relative
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="financesupp" value="By Myself" <?php // if(isset($_POST['financesupp']) && $_POST['financesupp'] == "By Myself") echo "checked"; ?>>
			    	By Myself
			  </label>
			</div>
	    </div>
	</div>
</div>
<div class="clearfix"></div>
<div class="form-group">
	<label for="inputEmail3" class="col-md-3 control-label">Non-Academic Award/s</label>
	<div class="col-md-8">
      <input type="text" class="form-control" name="nonacadaward" value="<?php // if(isset($_POST['nonacadaward']))echo $_POST['nonacadaward']; ?>">
    </div>
</div>

<div class="form-group">
	<label for="inputEmail3" class="col-md-3 control-label">Favorite subject/s in high school</label>
	<div class="col-md-8">
      <input type="text" class="form-control"  name="favesubj" value="<?php // if(isset($_POST['favesubj']))echo $_POST['favesubj']; ?>">
    </div>
</div>

<div class="form-group">
	<label for="inputEmail3" class="col-md-3 control-label">Least like subject/s in high school</label>
	<div class="col-md-8">
      <input type="text" class="form-control" name="dislikesubj" value="<?php // if(isset($_POST['dislikesubj']))echo $_POST['dislikesubj']; ?>">
    </div>
</div>

<div class="form-group">
	<label for="inputEmail3" class="col-md-3 control-label">Organization memberships</label>
	<div class="col-md-8">
      <input type="text" class="form-control"   name="orgmembership" value="<?php // if(isset($_POST['orgmembership']))echo $_POST['orgmembership']; ?>">
    </div>
</div>

<div class="form-group">
	<label for="inputEmail3" class="col-md-5 control-label">Is your present elective your personal choice?</label>
	
    <div class="col-md-1">
		<div class="radio">
		  <label>
		    <input type="radio" name="electivechoice" class="electivechoice" value="electivechoiceyes" <?php // if(isset($_POST['electivechoice']) && $_POST['electivechoice'] == "electivechoiceyes")echo "checked"; ?>>
		    	Yes
		  </label>
		</div>
	</div>

	<div class="col-md-1">
		<div class="radio">
		  <label>
		    <input type="radio" name="electivechoice" class="electivechoice" value="electivechoiceno" <?php // if(isset($_POST['electivechoice']) && $_POST['electivechoice'] == "electivechoiceno")echo "checked"; ?>>
		    	No
		  </label>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="form-group">
	<label for="inputEmail3" class="col-md-4 control-label">
		If No, a. who influence you to take the elective?
	</label>
	<div class="col-md-8">
      <input type="text" class="form-control" id="choiceA" name="whoinfluence" disabled value="<?php // if(isset($_POST['whoinfluence']))echo $_POST['whoinfluence']; ?>">
    </div>
</div>

<div class="form-group">
	<label for="inputEmail3" class="col-md-4 control-label">
		b. What is your personal choice? Why?
	</label>
	<div class="col-md-8">
      <input type="text" class="form-control" id="choiceB" name="personalchoice" disabled value="<?php // if(isset($_POST['personalchoice']))echo $_POST['personalchoice']; ?>">
    </div>
</div>
<div class="clearfix"></div>

<fieldset><legend><center>Work Experience</center></legend></fieldset>

<div class="table-responsive">
		<table class="table table-responsive">
        <thead>
          <tr>
            <th>Name of Company/Establishment</th>
            <th>Position</th>
            <th>Year</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" class="form-control" name="w1noc" value="<?php // if(isset($_POST['w1noc']))echo $_POST['w1noc']; ?>"></td>
            <td><input type="text" class="form-control" name="w1position" value="<?php // if(isset($_POST['w1position']))echo $_POST['w1position']; ?>"></td>
            <td><input type="text" class="form-control" name="w1year" value="<?php // if(isset($_POST['w1year']))echo $_POST['w1year']; ?>"></td>
          </tr>
          <tr>
            <td><input type="text" class="form-control" name="w2noc" value="<?php // if(isset($_POST['w2noc']))echo $_POST['w2noc']; ?>"></td>
            <td><input type="text" class="form-control" name="w2position" value="<?php // if(isset($_POST['w2position']))echo $_POST['w2position']; ?>"></td>
            <td><input type="text" class="form-control" name="w2year" value="<?php // if(isset($_POST['w2year']))echo $_POST['w2year']; ?>"></td>
          </tr>
          <tr>
            <td><input type="text" class="form-control" name="w3noc" value="<?php // if(isset($_POST['w3noc']))echo $_POST['w3noc']; ?>"></td>
            <td><input type="text" class="form-control" name="w3position" value="<?php // if(isset($_POST['w3position']))echo $_POST['w3position']; ?>"></td>
            <td><input type="text" class="form-control" name="w3year" value="<?php // if(isset($_POST['w3year']))echo $_POST['w3year']; ?>"></td>
          </tr>
          <tr>
            <td><input type="text" class="form-control" name="w4noc" value="<?php // if(isset($_POST['w4noc']))echo $_POST['w4noc']; ?>"></td>
            <td><input type="text" class="form-control" name="w4position" value="<?php // if(isset($_POST['w4position']))echo $_POST['w4position']; ?>"></td>
            <td><input type="text" class="form-control" name="w4year" value="<?php // if(isset($_POST['w4year']))echo $_POST['w4year']; ?>"></td>
          </tr>
        </tbody>
    </table>
</div>

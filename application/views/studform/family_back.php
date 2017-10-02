
<div class="form-group col-md-11 <?php  if(form_error('fathername'))echo "has-error"; ?>">
	<label>Father's Name <i class="redasterisk">*</i> <i>(Last Name, Firstname, Middle Name)</i></label>
  	<input type="text" class="form-control col-sm-11" name="fathername" value="<?php  if(isset($_POST['fathername'])) echo $_POST['fathername']; ?>">
</div>
<div class="form-group col-md-1<?php  if(form_error('fatherage'))echo "has-error"; ?>">
	<label>Age <i class="redasterisk">*</i></label>
    <input type="text" class="form-control  col-md-3" name="fatherage" value="" value="<?php  if(isset($_POST['fatherage'])) echo $_POST['fatherage']; ?>">
</div>

<div class="col-md-3 form-group <?php  if(form_error('fathernationality'))echo "has-error"; ?>">
	<label>Nationality</label>
  	<input type="text" class="form-control" name="fathernationality" value="<?php  if(isset($_POST['fathernationality'])) echo $_POST['fathernationality']; ?>">
</div>
<div class="col-md-5 control-group">
	<label></label>
  <div class="controls">
    <label class="radio inline" for="radios-0">
	  <input type="radio" name="isfatherliving" value="1" <?php  if(isset($_POST['isfatherliving']) && $_POST['isfatherliving'] == "fatherliving") echo "checked" ?>>
      <span>Living</span>
    </label>
    <label class="radio inline" for="radios-1">
	    <input type="radio" name="isfatherliving" value="0" <?php  if(isset($_POST['isfatherliving']) && $_POST['isfatherliving'] == "fatherdeceased") echo "checked" ?>>
      <span>Deceased</span>
    </label>
  </div>
</div>
<div class="clearfix"></div>
<div class="form-group col-md-5 <?php  if(form_error('fatheroccupation'))echo "has-error"; ?>">
	<label>Occupation</label>
  	<input type="text" class="form-control" name="fatheroccupation" value="<?php  if(isset($_POST['fatheroccupation'])) echo $_POST['fatheroccupation']; ?>">
</div>

<div class="col-md-5 form-group <?php  if(form_error('fathereducattain'))echo "has-error"; ?>">
    <label>Educational Attainment</label>
     <input type="text" class="form-control"  name="fathereducattain" value="<?php  if(isset($_POST['fathereducattain'])) echo $_POST['fathereducattain']; ?>"> 
</div>
<div class="clearfix"></div>
<div class="form-group col-md-11 <?php  if(form_error('mothername'))echo "has-error"; ?>">
    <label>Mother's Name <i class="redasterisk">*</i> <i>(Last Name, Firstname, Middle Name)</i></label>
   	<input type="text" class="form-control col-sm-11"  name="mothername" value="<?php  if(isset($_POST['mothername'])) echo $_POST['mothername']; ?>">
</div>
<div class="clearfix"></div>
<div class="form-group col-md-1 <?php  if(form_error('motherage'))echo "has-error"; ?>">
	<label>Age</label>
    <input type="text" class="form-control col-sm-3" name="motherage" value="<?php  if(isset($_POST['motherage'])) echo $_POST['motherage']; ?>">
</div>

<div class="col-md-3 <?php  if(form_error('mothernationality'))echo "has-error"; ?>">
	<label>Nationality</label>
  	<input type="text" class="form-control"  name="mothernationality" value="<?php  if(isset($_POST['mothernationality'])) echo $_POST['mothernationality']; ?>">
</div>

<div class="col-md-2">
	<div class="radio">
	  <label>
	    <input type="radio" name="ismotherliving" value="1" <?php  if(isset($_POST['ismotherliving']) && $_POST['ismotherliving'] == "motherliving")echo "checked" ?>>
	    	Living
	  </label>
	</div>
</div>

<div class="col-md-2">
	<div class="radio">
	  <label>
	    <input type="radio" name="ismotherliving" value="0" <?php  if(isset($_POST['ismotherliving']) && $_POST['ismotherliving'] == "motherdeceased")echo "checked" ?>>
	    	Deceased
	  </label>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-5 form-group <?php  if(form_error('motheroccupation'))echo "has-error"; ?>">
	<label>Occupation</label>
    <input type="text" class="form-control"  name="motheroccupation" value="<?php  if(isset($_POST['motheroccupation'])) echo $_POST['motheroccupation']; ?>">
</div>

<div class="col-md-5 form-group <?php  if(form_error('mothereducattain'))echo "has-error"; ?>">
    <label>Educational Attainment</label>
      <input type="text" class="form-control" name="mothereducattain" value="<?php  if(isset($_POST['mothereducattain'])) echo $_POST['mothereducattain']; ?>">
</div>
<div class="clearfix"></div>
<div class="col-md-5">
	<div class="form-group">
		<label class="col-md-5 control-label">Status of Parents</label>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status" value="Maried and living together" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Maried and living together")echo "checked" ?>>
				    	Maried and living together
				  </label>
				</div>
		    </div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status" value="Maried and kiving together but one is working abroad" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Maried and kiving together but one is working abroadr")echo "checked" ?>>
				    	Maried and living together but one is working abroad
				  </label>
				</div>
		    </div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status" value="Both parents are working abroad" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Both parents are working abroad")echo "checked" ?>>
				    	Both parents are working abroad
				  </label>
				</div>
		    </div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status"  value="Living-in" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Living-in")echo "checked" ?>>
				    	Living-in
				  </label>
				</div>
		    </div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status"  value="Separated" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Separated")echo "checked" ?>>
				    	Separated
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<label></label>
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="separated" value="Father is with another family" <?php  if(isset($_POST['separated']) && $_POST['separated'] == "Father is with another family")echo "checked" ?>>
				    	Father is with another family
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<label></label>
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="separated" value="Mother is with another family" <?php  if(isset($_POST['separated']) && $_POST['separated'] == "Mother is with another family")echo "checked" ?>>
				    	Mother is with another family
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status" value="Annulled" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Annulled")echo "checked" ?>>
				    	Annulled
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="parent_status"  value="Widower/Widowed" <?php  if(isset($_POST['parent_status']) && $_POST['parent_status'] == "Widower/Widowed")echo "checked" ?>>
				    	Widower/Widowed
				  </label>
				</div>
		    </div>
		</div>
	</div> 
</div>
<div class="col-md-6">
	<div class="form-group">
		<label class="col-md-8 control-label">Econimic Status: Parent/s Monthyly Income (Php)</label>
	</div>

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="monthincome"  value="Php 50,000.00 and above" <?php  if(isset($_POST['monthincome']) && $_POST['monthincome'] == "Php 50,000.00 and above")echo "checked" ?>>
				    	Php 50,000.00 and above
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="monthincome" value="Php 40,000.00 and above" <?php  if(isset($_POST['monthincome']) && $_POST['monthincome'] == "Php 40,000.00 and above")echo "checked" ?>>
				    	Php 40,000.00 and above
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="monthincome" value="Php 30,000.00 and above" <?php  if(isset($_POST['monthincome']) && $_POST['monthincome'] == "Php 30,000.00 and above")echo "checked" ?>>
				    	Php 30,000.00 and above
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="monthincome" value="Php 20,000.00 and above" <?php  if(isset($_POST['monthincome']) && $_POST['monthincome'] == "Php 20,000.00 and above")echo "checked" ?>>
				    	Php 20,000.00 and above
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="monthincome" value="Php 20,000.00 and below" <?php  if(isset($_POST['monthincome']) && $_POST['monthincome'] == "Php 20,000.00 and below")echo "checked" ?>>
				    	Php 20,000.00 and below
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<div class="col-md-9">
		    <div class="col-md-12">
				  <label>
				    	House
				  </label>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<label></label>
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="isrented" value="Owned" <?php  if(isset($_POST['isrented']) && $_POST['isrented'] == "Owned")echo "checked" ?>>
				    	Owned
				  </label>
				</div>
		    </div>
		</div>
	</div> 

	<div class="form-group">
		<label></label>
		<div class="col-md-9">
		    <div class="col-md-12">
		      	<div class="radio">
				  <label>
				    <input type="radio" name="isrented"  value="Rented" <?php  if(isset($_POST['isrented']) && $_POST['isrented'] == "Rented")echo "checked" ?>>
				    	Rented
				  </label>
				</div>
		    </div>
		</div>
	</div> 
</div>
<div class="clearfix"></div>
<div class="form-group">
    <div class="col-md-8">
      	<label class="col-md-4 control-label">Do you live with your:</label>
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
	<label></label>
	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="Parents" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "Parents")echo "checked" ?>>
			    	Parents
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="Father only" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "Father only")echo "checked" ?>>
			    	Father only
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="Mother only" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "Mother only")echo "checked" ?>>
			    	Mother only
			  </label>
			</div>
	    </div>
	</div>
</div>
<div class="form-group">
	<label></label>
	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="Guardian" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "Guardian")echo "checked" ?>>
			    	Guardian
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="relative" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "relative")echo "checked" ?>>
			    	Relative
			  </label>
			</div>
	    </div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="livingwith" class="livewith" value="others" <?php  if(isset($_POST['livingwith']) && $_POST['livingwith'] == "others")echo "checked" ?>>
			    	Others
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-5">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="text" class="form-control" id="livingwithotherstext"  name="livingwithotherstext" disabled="true"  value="<?php  if(isset($_POST['livingwithotherstext']))echo $_POST['livingwithotherstext'] ?>">
			  </label>
			</div>
	    </div>
	</div>
</div>
<div class="form-group">
    <div class="col-md-11">
      	<label>Place:</label>
    </div>
</div>
<div class="form-group">
	<label></label>
	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="place" class="residency" value="makati" <?php  if(isset($_POST['place']) && $_POST['place'] == "makati")echo "checked" ?>>
			    	Makati
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-3">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="place" class="residency" value="nonmakati" <?php  if(isset($_POST['place']) && $_POST['place'] == "nonmakati")echo "checked" ?>>
			    	Outside Makati pls. specify
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-5">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="text" class="form-control" id="residencytext" name="residencytext" disabled value="" value="<?php  if(isset($_POST['residencytext']))echo $_POST['residencytext'] ?>">
			  </label>
			</div>
	    </div>
	</div>
</div>
<div class="form-group">
    <div class="col-md-11">
      	<label class="col-md-5 control-label">How many siblings you have:</label>
    </div>
</div> 
<div class="form-group">
	<div class="col-md-offset-1 col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="siblings" value="onesiblings" <?php  if(isset($_POST['siblings']) && $_POST['siblings'] == "onesiblings")echo "checked" ?>>
			    	One
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="siblings" value="twosiblings" <?php  if(isset($_POST['siblings']) && $_POST['siblings'] == "twosiblings")echo "checked" ?>>
			    	Two
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="siblings" value="threesiblings" <?php  if(isset($_POST['siblings']) && $_POST['siblings'] == "threesiblings")echo "checked" ?>>
			    	Three
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-3">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="siblings" value="moresiblings" <?php  if(isset($_POST['siblings']) && $_POST['siblings'] == "moresiblings")echo "checked" ?>>
			    	More than three
			  </label>
			</div>
	    </div>
	</div>
</div>
<div class="form-group">
    <div class="col-md-11">
      	<label>Birth Rank:</label>
    </div>
</div>
<div class="form-group">
	<div class="col-md-offset-1 col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="birthrank" value="Only Child" <?php  if(isset($_POST['birthrank']) && $_POST['birthrank'] == "Only Child")echo "checked" ?>>
			    	Only Child
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-1">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="birthrank" value="Eldest" <?php  if(isset($_POST['birthrank']) && $_POST['birthrank'] == "Eldest")echo "checked" ?>> 
			    	Eldest
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="birthrank" value="Middle Child" <?php  if(isset($_POST['birthrank']) && $_POST['birthrank'] == "Middle Child")echo "checked" ?>>
			    	Middle Child
			  </label>
			</div>
	    </div>
	</div>

	<div class="col-md-2">
	    <div class="col-md-12">
	      	<div class="radio">
			  <label>
			    <input type="radio" name="birthrank" value="Youngest Child" <?php  if(isset($_POST['birthrank']) && $_POST['birthrank'] == "Youngest Child")echo "checked" ?>>
			    	Youngest Child
			  </label>
			</div>
	    </div>
	</div>
</div>

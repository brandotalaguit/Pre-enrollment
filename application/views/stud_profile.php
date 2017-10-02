<div class="container">
	<div class="col-md-11">
		<div class="alert alert-info">
			<strong>
				Note:<br>
				- All fields with (<i class="redasterisk">*</i> ) are required to fill up <br>
		    	- If field is not applicable type (N/A)
		    </strong>
		</div>
		<?php echo form_open() ?>
		<div class="panel panel-primary">
			<div class="panel-body">
				<div role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#personalinfo" aria-controls="personalinfo" role="tab" data-toggle="tab">Personal Info</a>
						</li>
						<li role="presentation">
							<a href="#familybackground" aria-controls="familybackground" role="tab" data-toggle="tab">Family Background</a>
						</li>
						<li role="presentation">
							<a href="#educbackground" aria-controls="educbackground" role="tab" data-toggle="tab">Educational Background</a>
						</li>
						<li role="presentation">
							<a href="#survey" aria-controls="survey" role="tab" data-toggle="tab">Student Survey</a>
						</li>
						<li role="presentation">
							<a href="#survey_2" aria-controls="survey_2" role="tab" data-toggle="tab">Survey Continuation</a>
						</li>
					</ul>
				
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="personalinfo">
							<?php echo $this->load->view('studform/personal_info'); ?>

						</div>
						<div role="tabpanel" class="tab-pane" id="familybackground">
							<?php echo $this->load->view('studform/family_back'); ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="educbackground">
							<?php echo $this->load->view('studform/educ_back'); ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="survey">
							<?php echo $this->load->view('studform/stud_survey'); ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="survey_2">
							<?php echo $this->load->view('studform/survey_cont'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close() ?>
	</div>
</div>
<script>
	// var elem = document.getElementById("civilstat");
	// elem.onchange = function(){
	//     var hiddenDiv = document.getElementById("Married");
	//     hiddenDiv.style.display = (this.value == "") ? "none":"block";
	// };

	$('#civil_status').change(function(){
		statValue = $(this).find("option:selected").val()

		if (statValue != 'Single' ) 
			$('#Married').removeAttr('style');
		else
			$('#Married').attr('style','display:none');	
	});

</script>

 <script>
	$(document).ready(function(){
		var rchildno = Number($(".no_child").val());
		$("#no_child_textbox").empty();
		for(var i=0;i<rchildno;i++){
    		var x = i+1;
        	$("#no_child_textbox").append("<span class='form-group'><label class='col-md-3 control-label'>"+x+"</label><span class='col-md-8'><input type='text' class='form-control' name='child"+x+"'></span></span>");
    	}

	    $(".no_child").change(function(){
	    	var childno = Number($(".no_child").val());
	    	$("#no_child_textbox").empty();
	    	for(var i=0;i<childno;i++){
	    		var x = i+1;
	        	$("#no_child_textbox").append("<span class='form-group'><label class='col-md-3 control-label'>"+x+"</label><span class='col-md-8'><input type='text' class='form-control' name='child"+x+"'></span></span>");
	    	}
	    });
	});
</script>


<script>
	$(document).ready(function(){

	    $("input[name='sex']").click(function () {
	    	var isChecked = $(this);
	    	console.log(isChecked.val());
			if (isChecked.val()==3) { 
		        $('#sexpreferencetext').removeAttr('readonly');
		    }else{ 
		        $('#sexpreferencetext').attr('readonly',true);
		    }
		});
	});
</script>

<script type="text/javascript">
	$(function(){

    $('#gc1').click(function(){
        
        $('#y1').removeAttr('disabled');
        $('#y2').removeAttr('disabled');
        $('#y3').removeAttr('disabled');
        $('#y4').removeAttr('disabled');
    });

    $('#gc2').click(function(){
       
        $('#y1').attr('disabled',true);
        $('#y2').attr('disabled',true);
        $('#y3').attr('disabled',true);
        $('#y4').attr('disabled',true);
        $('#y1').removeAttr('checked');
        $('#y2').removeAttr('checked');
        $('#y3').removeAttr('checked');
        $('#y4').removeAttr('checked');

    });

    });

    $(document).ready(function($) {
	      $("#Disease").click(function(){
	               if ($("#Disease").is(':checked')) {               
	                    $('#others').attr("hidden", false);               
	                 }               
	               else if ($('#Disease').not(':checked')) {      
	                                          
	                $('#others').val('');
	                $('#others').attr("hidden", true);                            
	                }           
	 }); });
</script>

<script>
	$(document).ready(function(){
	    $(".livewith").change(function () {
	    	var isChecked = $('.livewith:checked');
			if (isChecked.val()=="others") { 
		        $('#livingwithotherstext').removeAttr('disabled');
		    }else{ 
		        $('#livingwithotherstext').attr('disabled',true);
		    }
		});
	});
</script>


<script>
	$(document).ready(function(){
	    $(".residency").change(function () {
	    	var isMakati = $('.residency:checked');
			if (isMakati.val()=="nonmakati") { 
		        $('#residencytext').removeAttr('disabled');
		    }else{ 
		        $('#residencytext').attr('disabled',true);
		    }
		});
	});
</script>


<script>
	$(document).ready(function(){
	    $(".electivechoice").change(function () {
	    	var isPersonalChoice = $('.electivechoice:checked');
			if (isPersonalChoice.val()=="electivechoiceno") { 
		        $('#choiceA').removeAttr('disabled');
		        $('#choiceB').removeAttr('disabled');
		    }else{ 
		        $('#choiceA').attr('disabled',true);
		        $('#choiceB').attr('disabled',true);
		    }
		});
	});
</script>

<!-- script for bday -->
<script>
	$(document).ready(function(){
	    $("#birthdate").change(function () {
	    	 var Bdate = $('#birthdate').val();
	    	 var Bday = +new Date(Bdate);
	    	 Q4A = ~~ ((Date.now() - Bday) / (31557600000));
	    	 $('#resultBday').val(Q4A)
		});
	});
</script>

<!-- script tooltip -->
<script>
	$(function(){
		$('a[title]').tooltip();
		});
</script> 
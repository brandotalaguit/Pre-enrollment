<link href="<?php echo base_url(); ?>assets/css/chosen.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-modal.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-tooltip.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function () {
       $('select').chosen();
    });
</script>
<style type="text/css">
    .chzn-container{
        vertical-align: middle;
    }
</style>

<div class="page-header">
    <h2>
        <img src="<?php echo base_url();?>assets/img/icon_scholarship.png" class="thumnails"> SCHOLARSHIP APPLICATION
    </h2>
</div>
<?php echo form_open(base_url() . 'assessment/MacesScholar', array('class' => 'form-horizontal')); ?>
<?php if(validation_errors()) : ?>
<div class="alert alert-block alert-error">
    <a class="close" data-dismiss="modal">x</a>
    <h3 class="alert-header">Something went wrong in the following field(s)</h3>
    <p>
        <?php echo validation_errors(); ?>
    </p>
</div>
<?php endif;  ?>
<div class="span12">
    <div class="control-group">
        <label class="control-label" for="student_id">Search Student Id</label>
        <div class="controls">
            <input type="text" tabindex="1" class="input-medium search-query" name="student_id" id="student_id" value="<?php echo $this->input->post('student_id');?>">
            <select class="span5" name="scholarship_grant" data-placeholder="-- Scholarship Grant --" tabindex="2">
                <option value=""></option>
                <?php foreach($scholarship as $row): ?>
                <option value="<?php echo $row['ScholarshipId']; ?>" <?php echo $row['ScholarshipId'] == $this->input->post('scholarship_grant') ? "selected" : "";?> ><?php echo $row['ScholarshipDesc']; ?></option>
                <?php endforeach; ?>
            </select>            
            <button class="btn btn-primary" name="btn_search" value="Go">
                <strong>Go</strong>
                <i class="icon icon-arrow-right icon-white"></i>
            </button>
        </div>
    </div>
</div>


<div class="span12">
    <table class="table table-bordered table-striped" style="width:95%">
        <thead class="alert alert-info">
            <tr>
                <th>Name</th>
                <td><?php echo empty($student_info) ? "&nbsp;" : $student_info['Lname'] . ", " . $student_info['Fname'] . " " . $student_info['Mname'];?></td>
                <th>Student No.</th>
                <td><?php echo empty($student_info) ? "&nbsp;" : $student_info['StudNo']; ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>College</th>
                <td><?php echo !empty($student_info) == FALSE ? "&nbsp;" : $student_curriculum['CollegeDesc']; ?>&nbsp;</td>
                <th>Gender</th>
                <td><?php echo !empty($student_info) == FALSE ? "&nbsp;" : $student_info['Gender'] == 'M'? 'Male' : 'Female'; ?>&nbsp;</td>
            </tr>
            <tr>
                <th>Program/Major</th>
                <td colspan="3"><?php echo !empty($student_info) == FALSE ? "&nbsp;" : $student_curriculum['ProgramDesc'] . " " . $student_curriculum['MajorDesc'];?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo !empty($student_info) == FALSE ? "&nbsp;" : $student_info['AddressStreet'] . " " . $student_info['AddressBarangay'] . " " . $student_info['AddressCity']; ?></td>
                <th>Guardian</th>
                <td><?php echo !empty($student_info) == FALSE ? "&nbsp;" : $student_info['Guardian'];?></td>
            </tr>
        <thead class="alert-info">
            <tr>
                <th>Scholarship</th>
                <td colspan="3"><?php echo empty($scholar) ? "&nbsp;" : $scholar['ScholarshipDesc']; ?></td>
            </tr>
        </thead>
        </tbody>
    </table>
    <?php if (!empty($student_info) != FALSE) : ?>
        <div class="span8 offset5">
            <a href="" class="btn btn-large">
                Clear / Refresh
            </a>
            <button class="btn btn-large btn-danger" name="btn_remove" value="remove">
                <i class="icon-remove icon-white"></i> 
                Remove Scholarship
            </button>
            <button class="btn btn-large btn-success" name="btn_update" value="grant">
                <i class="icon-ok icon-white"></i> 
                Grant Scholarship
            </button>
        </div>
    <?php endif; ?>
<?php echo form_close(); ?>
</div>

<div class="footer">
    <p><br />Page rendered in {elapsed_time} seconds</p>
</div>


<!-- <img src="<?php echo base_url(); ?>assets/img/icon_scholarship.png" />
<h2>Application for Scholarship</h2>
<span></span>
<?php echo form_open('assessment/'); ?>
<label for="student_id" rel=""><h5>Search Student ID:</h5></label>
<p class="clearfix">
<input type="text" name="student_id" id="student_id" size="40"  />
</p>
<input type="submit" name="btn_search" value="Search" style="margin-top:0px" />
<?php echo form_close(); ?>
<?php if(isset($success) && $success): ?>
     <div class="success_message">
     <h5>Success:</h5>
     <p>You have successfully grant scholarship to student.</p>
     </div>
<?php endif; ?>

<?php if(isset($success) && !$success): ?>
     <div class="error_message">
     <h5>Error:</h5>
     <p>Unable to changed the scholarship grant. Scholarship Grant is still the same. Please try again.</p>
     </div>
<?php endif; ?>
<?php $key=0; $id=0; $scholarshipdesc=''; ?>
<?php foreach($scholarkey as $scholar) {
	$key = $scholar['ScholarshipId'];
	$scholarshipdesc = 'SCHOLARSHIP : '.$scholar['ScholarshipDesc'];
	$id = $scholar['StudNo'];
      } ?>
<h5>Apply Scholarship Grant for A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc'] . ' ' . $scholarshipdesc; ?></h5>
<?php echo form_open('assessment/'); ?>
<table id="scholarship" width="99%">
    <tr>
        <th width="15%">Student No</th>
        <th width="25%">Name</th>
        <th width="10%">College</th>
        <th width="25%">Program/Major</th>
        <th width="24%">Scholarship</th>
    </tr>
    <?php if(isset($stud_info)): ?>
    <?php if(!empty($stud_info)): ?>
    <tr>
        <td><?php echo $stud_info['StudNo']; ?></td>
        <td><?php echo $stud_info['Lname'] . ' ' . $stud_info['Fname'] . ' ' . $stud_info['Mname']; ?></td>
        <td><?php echo $stud_info['CollegeCode']; ?></td>
        <td><?php echo $stud_info['ProgramDesc'] . '/' . $stud_info['MajorDesc']; ?></td>
        <td>
        <select name="scholarship_grant">
        <?php foreach($scholarship as $row): ?>
                <option value="<?php echo $row['ScholarshipId']; ?>"><?php echo $row['ScholarshipDesc']; ?></option>
        <?php endforeach; ?>
        </select>
        </td>
    </tr>
    <?php else: ?>
    <tr>
    <td colspan="5"><h4> No Record Found For Student No. <?php echo $search_student_id; ?></h4></td>
    </tr>
    <?php endif; ?>
    <?php endif; ?>        
</table>
<?php if(!empty($stud_info)): ?>
<input type="hidden" name="student_id" value="<?php echo $stud_info['StudNo']; ?>" />
<input type="submit" name="btn_update" value="Add Scholarship" />
<?php endif; ?>    
<?php echo form_close(); ?> -->
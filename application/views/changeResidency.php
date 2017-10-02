<link href="<?php echo base_url(); ?>assets/css/chosen.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-modal.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-tooltip.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function () {
       <?php if($this->input->post('btn_search') AND empty($student_scholarship) == TRUE ):?>
       $('#scholarship_grant').chosen({allow_single_deselect: true});
       <?php endif; ?>
       $('select').chosen();
       <?php 
        if($status == 'Updated') 
            echo "$('#message').modal();";
       ?>
       $('#btn_remove').tooltip();
    });
</script>
<style type="text/css">
    .chzn-container{
        vertical-align: middle;
    }
</style>
<div id="message" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h3 class="alert-header">DATA SAVE</h3>
    </div>
    <div class="modal-body alert-block">

        <h3>
            Data has been successfully <strong>SAVE</strong>.
        </h3>

    </div>
    <div class="modal-footer">
        <a id="ok" href="<?php echo base_url()?>assessment/changeOfResidency" class="btn btn-danger btn-large">Close</a>
    </div>
</div>
<div class="page-header">
    <h2>
        <img src="<?php echo base_url();?>assets/img/icon_home.png" class="thumnails"> CHANGE OF RESIDENCY
    </h2>
</div>
<?php echo form_open(base_url() . 'assessment/changeOfResidency', array('class' => 'form-horizontal')); ?>
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
            <input type="hidden" name="hId" value="<?php echo $this->input->post('student_id');?>">
            <button class="btn btn-primary" name="btn_search" tabindex="2" value="Go">
                <strong>Go</strong>
                <i class="icon icon-arrow-right icon-white"></i>
            </button>
            <div class="span6 pull-right">
            <strong>Scholarship</strong> 
                    <select class="span4" name="scholarship_grant" id="scholarship_grant" data-placeholder="-- Choose Scholarship Grant --" tabindex="5">
                        <option value=""></option>
                        <?php $label = ''; ?>
                        <?php foreach($scholarship as $row): ?>
                            <?php if($label != $row['DiscountPercentage']) : $label = $row['DiscountPercentage']; ?>
                                    <optgroup label="<?php echo $row['DiscountPercentage'] == '0.50' ? 'Partial' : 'Full'; ?> Scholarship">
                            <?php endif; ?>
                            <option value="<?php echo $row['ScholarshipId']; ?>" <?php if( empty($student_scholarship) == FALSE ) echo $row['ScholarshipId'] == $student_scholarship['ScholarshipId'] ? "selected" : "";?> ><?php echo $row['ScholarshipDesc']; ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                    <?php if( empty($student_scholarship) == FALSE ) : //print_r($student_scholarship);?>
                    <button class="btn btn-small btn-danger" name="btn_remove" id="btn_remove" value="remove" title="Remove Scholarship" rel="tooltip" data-original-title="Remove Scholarship">
                        <i class="icon-remove icon-white"></i> 
                    </button>
                    <?php endif; ?>
            </div>
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
                <th>Residency</th>
                <th>
                    <select data-placeholder="-- Set Residency --" tabindex="3" name="residency" class="span4">
                        <option value=""></option>
                        <?php 
                            if (empty($student_info) == FALSE) :
                        ?>
                            <option value="1" <?php echo $oldResidency == TRUE ? "selected" : "";?> >Makati Residence</option>
                            <option value="0" <?php echo $oldResidency == FALSE ? "selected" : "";?> >Non Makati Residence</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </th>
                <th>Mode of Payment</th>
                <th>
                    <select data-placeholder="-- Mode of Payment --" tabindex="4" name="paymode">
                        <option value=""></option>
                        <?php 
                            if (empty($student_info) == FALSE ) :
                        ?>
                            <option <?php echo !empty($PayMode) ? ($PayMode['PayMode'] == "PROMISSORY" ? "selected" : "") : ""; ?> value="PROMISSORY">PROMISSORY NOTE</option>
                            <option <?php echo !empty($PayMode) ? ($PayMode['PayMode'] == "CASH" ? "selected" : "") : ""; ?> value="CASH">CASH</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </th>
            </tr>
        </thead>
        </tbody>
    </table>
    <?php if (!empty($student_info) != FALSE) : ?>
            <div class="offset9">
                <a href="" class="btn btn-warning btn-large">
                    Clear
                </a>
                <button class="btn btn-large btn-success" name="btn_update" value="grant">
                    <i class="icon-ok icon-white"></i> 
                    Save
                </button>
            </div>
    <?php endif; ?>
<?php echo form_close(); ?>
</div>

<div class="footer">
    <p><br />Page rendered in {elapsed_time} seconds</p>
</div>
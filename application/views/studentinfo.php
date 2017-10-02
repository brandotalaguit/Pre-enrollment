<?php $file_pic = 'assets/student_pics/' . $_SESSION['student_info']['StudNo'] . '.JPG'; ?>
<?php if(!file_exists($file_pic)): ?>
    <?php if($_SESSION['student_info']['Gender'] == 'F'): ?>	
    <img src="<?php echo base_url(); ?>assets/img/blank_woman.jpg" width="80"id="student_pic">
    <?php else: ?>	 
    <img src="<?php echo base_url(); ?>assets/img/blank_man.jpg" width="80"id="student_pic">
  <?php endif; ?>
<?php else: ?>
    <img src="<?php echo base_url() . $file_pic; ?>" width="100" id="student_pic">
<?php endif; ?>

<?php if ($this->session->flashdata('error_edit')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error_edit')?></div>  
<?php endif ?>
<h2>Student Information</h2> 
<h5><button type="button" class="btn btn-info pull-right" id="editinfo" style="margin-top: -20px;margin-right: 100px;">Edit Information</button></h5>

<h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>
<table class="table table-bordered table-condensed table-striped dth" style="margin-bottom:5px">
    <tr>
        <th width="15%">College</th>
        <td width="35%"><?php echo strtoupper($_SESSION['student_curriculum']['CollegeDesc']); ?></td>
        <th width="15%">Academic Year</th>
        <td width="35%"><?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
    </tr>
    <tr>
        <th>Program/Major</th>
        <td colspan="3"><?php echo $_SESSION['student_curriculum']['ProgramDesc']; if(!empty($_SESSION['student_curriculum']['MajorDesc'])) echo 'MAJOR IN ' . $_SESSION['student_curriculum']['MajorDesc'];  ?></td>              
    </tr>
    <tr class="edithide">
        <th>Name</th>
        <td><?php echo $_SESSION['student_info']['Fname'] . ' ' . $_SESSION['student_info']['Mname'] . ' ' . $_SESSION['student_info']['Lname']; ?></td>
        <th>Student No.</th>
        <td><?php echo strtoupper($_SESSION['student_info']['StudNo']); ?></td>
    </tr>
    <tr class="edithide">
        <th>Address</th>
        <td><?php echo strtoupper($_SESSION['student_info']['AddressStreet']) . ', ' . strtoupper($_SESSION['student_info']['AddressBarangay']) . ', ' . strtoupper($_SESSION['student_info']['AddressCity']); ?></td>
        <th>Gender</th>
        <td><?php if($_SESSION['student_info']['Gender'] == 'F') echo 'FEMALE'; else { echo 'MALE'; } ?></td>
    </tr>
    <tr class="edithide">
        <th>Guardian</th>
        <td><?php echo strtoupper($_SESSION['student_info']['Guardian']) ?></td>
        <th>Date of Birth</th>
        <td><?php echo date('F d, Y',strtotime($_SESSION['student_info']['BirthDay'])); ?></td>
    </tr>
</table>

<?php echo form_open(base_url('student/edit_student_info')) ?>
<?php echo form_hidden('StudNo',$_SESSION['student_info']['StudNo']) ?>
<table class="table table-bordered table-condensed table-striped dth" id="show_editinfo" hidden style="margin-bottom:5px">
    <tr >
        <th>Student No.</th>
        <td><?php echo strtoupper($_SESSION['student_info']['StudNo']); ?></td>
    </tr>
    <tr>
        <th width="15%">Name</th>
        <td width="40%" colspan="2"><input type="text" name="Fname" value="<?php echo $_SESSION['student_info']['Fname']; ?>" class='col-sm-10'></td>
        <td width="30%" colspan="3"><input type="text" name="Mname" value="<?php echo $_SESSION['student_info']['Mname']; ?>" class='col-sm-10'></td>
        <td width="15%"><input type="text" name="Lname" value="<?php echo $_SESSION['student_info']['Lname']; ?>"></td>
    </tr>
    <tr>
        <th>Address</th>
        <td colspan="2"><input type="text" name="AddressStreet" value="<?php echo strtoupper($_SESSION['student_info']['AddressStreet']); ?>" class='col-sm-10'></td>
        <td colspan="3"><input type="text" name="AddressBarangay" value="<?php echo strtoupper($_SESSION['student_info']['AddressBarangay']); ?>" class='col-sm-10'></td>
        <td><input type="text" name="AddressCity" value="<?php echo strtoupper($_SESSION['student_info']['AddressCity']); ?>"></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td>
          <?php 
          $female='';
          $male='';
            if($_SESSION['student_info']['Gender'] == 'F') {
                  $female = 'checked';
            }
            else { $female = ' '; } 
            ?>
            <?php 
            if($_SESSION['student_info']['Gender'] == 'M') {
                  $male = 'checked'; 
            }
            else { $male =' '; } 
            ?>
          <label class="radio-inline">
            <input type="radio" name="Gender" id="inlineRadio1" value="F" <?php echo $female; ?>> FEMALE
          </label>
          <label class="radio-inline">
            <input type="radio" name="Gender" id="inlineRadio2" value="M" <?php echo $male; ?>> MALE
          </label>
        </td>
        <th width="15%">Guardian</th>
        <td colspan="2"><input type="text" name="Guardian" value="<?php echo strtoupper($_SESSION['student_info']['Guardian']) ?>"></td>
        <th>Date of Birth</th>
        <td><input type="date" name="BirthDay" value="<?php echo date(($_SESSION['student_info']['BirthDay'])); ?>"></td>
    </tr>
    <tr>
        <td colspan="7">
            <center>
                <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </div>
                <div class="col-xs-5">
                    <button type="button" class="btn btn-danger btn-block" id="close_editinfo">Close</button>
                </div>
            </center>
        </td>
    </tr>
</table>
<?php echo form_close() ?>


<script type="text/javascript">
    $('#editinfo').click(function(){
        $('#show_editinfo').removeAttr('hidden');
        $('.edithide').attr('hidden','hidden');
    })

    $('#close_editinfo').click(function(){
        $('#show_editinfo').attr('hidden','hidden');
        $('.edithide').removeAttr('hidden');
    })

</script>
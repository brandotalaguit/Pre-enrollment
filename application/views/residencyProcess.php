<h2>
    <img src="<?php echo base_url();?>assets/img/icon_home.png" class="right"> Change of Residency Procedure 
</h2>
<p>
    <strong>
        A student who claims to be a resident must attach any of the following:
    </strong>
</p>
<div class="row">
    <div class="span8">        
            
            <img src="<?php echo base_url();?>assets/img/id_card.png" class="thumnails pull-right" width="80">
            <ol>
                <li>Accomplished <?php echo anchor(base_url()."assets/pdf/RV Form.pdf","Residency Verification Form <i class='icon icon-download'></i>"); ?></li>
                <li>Vote's ID or latest Voter's Certification if student is 18 yrs. old and above</li>
                <li>SK Voter's ID if student is below 18 yrs. old.</li>
                <li>Voter's ID or latest Voter's Certification of parents or a brother or a sister.
                    <ul>
                        <li>The student and her/his sibling's Birth Certificate are required to verify the truthfulness of the relationship</li>
                        <li>If the guardian is a married sister, student must present the sister's birth and marriage certificate.</li>
                    </ul>
                </li>
            </ol>        
            <div class="alert alert-danger">
                <i class="icon icon-warning-sign"></i> No attachments required for <strong>Non Makati Residents</strong>
            </div>
            <div class="badge">
                <strong>Should there be a change in residency; the student is required to present necessary documents.</strong>
            </div>
    </div>
    <div class="span3 alert alert-success">
        <img src="<?php echo base_url();?>assets/img/icon-download.png" class="thumnails pull-right" width="80">
        <strong>Download</strong> <i class="icon icon-download"> </i>
        <ul>
            <li><?php echo anchor(base_url()."assets/pdf/RV Form.pdf","Residency Verification Form"); ?></li>
            <li><?php echo anchor("http://get.adobe.com/reader/","Adobe Acrobat Reader Installer",array('target' => '_blank')); ?></li>
        </ul>
    </div>
</div>

<?php $this->load->view('scholarProcess'); ?>

<a href="<?php echo base_url(); ?>index.php/student/encoded_subjects_assessment" class="btn btn-success"><b>NEXT</b> <i class="icon icon-ok icon-white"></i></a>
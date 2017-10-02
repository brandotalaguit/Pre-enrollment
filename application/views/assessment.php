<div class="row">
<div class="span7">    
<?php
//A1110599
$SubTotal = 0.00;
$TuitionFee = 10000.00;
$Exemption = $AssDetails3 ? $AssDetails3['ScholarshipDesc'] : '';
$CityHall = ($TuitionFee - $student_tokenfee['Amount']);

if ( ! empty($student_tokenfee['IsPerUnit'])) 
{
  $TuitionFee = $student_tokenfee['Amount'];
  $CityHall = 0.00;
}

$Discount = $AssDetails3 ? $student_tokenfee['Amount'] * $AssDetails3['DiscountPercentage'] : 0;
$TokenFee = $TuitionFee - $CityHall - $Discount;


?>
<table class="table table-bordered table-striped dth">
    <thead class="alert alert-info">
    <tr>
        <th style="text-align:center;">MISCELLANEOUS FEE(S)</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody class="table-condensed">

    <!-- start misc fee -->
    <?php if ($_SESSION['sy_sem']['SemId'] != 3): ?>
        
        <?php foreach ($student_assessment as $misc): ?>
        <tr>
            <td style="text-align:right; padding-right:45px;"><?php echo $misc['FeeDesc']; ?></td>
            <td><?php echo nf($misc['Amount']); ?></td>
        </tr>
        <?php $SubTotal += $misc['Amount']; ?>
        <?php endforeach ?>

        <tr>
            <th style="text-align:right; padding-right:45px;font-size:16px">Sub-Total</th>
            <th style="font-size:16px"><?php echo nf($SubTotal); ?></th>
        </tr>
    <?php endif ?>
    <!-- end of misc fee -->

        <?php if ( ! empty($nstp_subject)): ?>
        <tr>
            <td style="text-align:right; padding-right:45px;">NSTP Fee</td>
            <td>100.00</td>
        </tr>
        <tr>
            <th style="text-align:right; padding-right:45px;font-size:16px">Sub-Total</th>
            <th style="font-size:16px"><strong>100.00</strong></th>
        </tr>
        <?php endif ?>
    
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <thead>
            <tr>
                <th style="text-align:center;">TUITION FEE</th>
                <th style="background-color:white;color:#333;font-weight:bold;font-size:18px;"><?php echo nf($TuitionFee); ?></th>
            </tr>
        </thead>
        
        <tr>
            <td style="text-align:right; padding-right:45px;">Less: SCHOLARSHIP/PRIVILEGE From Makati City Government</td>
            <td><?php echo "( ". nf($CityHall) ." )"; ?></td>
        </tr>

        <?php if($Discount > 0): ?>
        <tr>
            <td style="text-align:right; padding-right:45px;"><?php echo "Less: Scholarship ".$Exemption; ?></td>
            <td><?php echo "( ". nf($Discount)." )"; ?></td>
        </tr>
        <?php endif; ?>

        
        <tr>
            <th style="text-align:right; padding-right:45px;font-size:18px">Token Fee</th>
            <th style="font-size:18px" ><?php echo nf($TokenFee); ?></th>
        </tr>
        
</tbody>
</table>

<p class='lead'>
    <!-- Only payments on designated dates are accepted. Please strictly follow the schedule.
  Otherwise you will pay on the last day of scheduled payment -->
  &nbsp;
</p>

</div>
<div class="span45">
    <!-- <img src="<?php echo base_url();?>assets/img/icon_assess.png" class="right">
    <h2>Reminders</h2>
    <span>Please read.</span>
    <br><br>
    <p class="alert alert-success">Be sure that you have taken and passed the pre-requisite course/s before enrolling the advanced course/s, otherwise, it will not be given credit.
    </p>
    <p class="alert alert-error">
    Only graduating students are allowed to have an overload, provided it will not exceed 28 units.
    </p>
    -->
    <h2>
    <img src="<?php echo base_url();?>assets/img/icon_home.png" class="right"> Change of Residency Procedure 
    </h2>
    <p>
        <strong>
            A student who claims to be a resident must attach any of the following:
        </strong>
    </p> 
         
                
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
                    <strong>Should there be a change in residency; <BR>the student is required to present necessary documents.</strong>
                </div>
       
        <br>
        
    <br/>
<h2>
    <img src="<?php echo base_url();?>assets/img/icon_scholarship.png" class="right"> Scholarship Requirements
</h2>
<p>
    <strong>
        Basic Requirements: 
    </strong>
</p>

            <ul>
                <li>Accomplished <?php echo /*anchor(base_url()."assets/pdf/MACES From 2011.pdf",*/("MACES Form (for new applicant)<i class='icon icon-download'></i>"); ?>, <?php echo /*anchor(base_url()."assets/pdf/MACES From 2011.pdf",*/("MACES Form (for continuing applicant) <i class='icon icon-download'></i>"); ?></li>
                <li><?php echo anchor(base_url()."assets/pdf/RV Form.pdf","Residency Verification Form <i class='icon icon-download'></i>"); ?></li>
                <li>1 x 1 ID Picture(for new scholar applicant)</li>
                <li>Encoded Subjects and Assessment</li>
            </ul>
        
        <div class="alert alert-info">
            <p><strong>Other Requirements:</strong></p>
                <ul>
                    <li>Base on kind of <?php echo anchor(base_url()."assets/pdf/scholarship.pdf","Scholarship",array('target' => '_blank')); ?></li>
                </ul>
        </div>
<!--         <div>
            <iframe src="<?php echo base_url() . "assets/pdf/scholarship.pdf"; ?>"></iframe>
-->   
</div></div>
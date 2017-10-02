<div class="row">
<div class="span7">    
<?php
$SubTotal = 0.00;

$tuition_fee = $assessment['no_units'] * $tuition['rate_per_unit'];
$rle_aff_fee = $assessment['no_rle_hours'] * $tuition['rle_rate_per_hour'];
$lab_fee = $assessment['no_lab_units'] * $tuition['lab_rate_per_unit'];
$misc_fee = $tuition['misc_fee'];
$total_fees = $tuition_fee + $rle_aff_fee + $lab_fee + $misc_fee;
?>

<div class="alert alert-info text-center">
    <h4>
        UNOFFICIAL ASSESSMENT
        <br><small>DO NOT PRINT THIS PAGE</small>
    </h4>
</div>

<table class="table table-bordered table-striped table-condensed dth">
    <thead>
        <tr>
            <td colspan='2'><small><strong><?php echo $tuition['description'] ?></strong></small></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="40%" class="assessment_td">No. of Units</td>
            <td width="60%"><?php echo $assessment['no_units'] ?></td>
        </tr>
        <tr>
            <td class="assessment_td">Rate per Unit</td>
            <td><?php echo $tuition['rate_per_unit'] ?></td>
        </tr>
        <thead>
        <tr>
            <th>Tuition Fee</th>
            <th><?php echo nf($assessment['no_units'] * $tuition['rate_per_unit']) ?></th>
        </tr>
        </thead>

        <tr>
            <td class="assessment_td">Miscellaneous Fees</td>
            <td><?php echo nf($tuition['misc_fee']) ?></td>
        </tr>

        <thead>
        <tr style='font-size:18px; font-weight: bold;'>
            <td>Total Fees</td>
            <td><?php echo nf($total_fees) ?></td>
        </tr>
        </thead>

    </tbody>
</table>

<?php if (count($student_assessment)): ?>
            <table class="table table-bordered table-striped dth">
                <thead class="alert alert-info">
                <tr>
                    <th style="text-align:center;">STUDENT ORGANIZATION FEE(S)</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody class="table-condensed">

                    <?php foreach ($student_assessment as $misc): ?>
                    <tr>
                        <td class="assessment_td"><?php echo $misc['FeeDesc']; ?></td>
                        <td><?php echo nf($misc['Amount']); ?></td>
                    </tr>
                    <?php $SubTotal += $misc['Amount']; ?>
                    <?php endforeach ?>

                    <tr>
                        <th class="assessment_td" style="font-size:16px">Sub-Total</th>
                        <th style="font-size:16px"><?php echo nf($SubTotal); ?></th>
                    </tr>
            </tbody>
            </table>
            
<?php endif ?>


</div>
<div class="span45">

    <div class="row-fluid">
        <!-- Please print this advising slip and go to your payment scheduled. -->
        <?php if ( empty($assessment['assessed_by'])): ?>
            <div class="alert alert-danger" style='width:85%'>
                <p class='lead'>Next step:<br/>
                Your application is <strong>WAITING</strong> for the approval at the Accounting Office. 
                <!-- Processing time of your application will start on June 05, 2015 at 3:00 PM. -->
                Try to access your account 1 to 2 hours after the processing time.
                <!-- <br>Try to visit this page after a while.         -->
                </p>
            </div>
        <?php endif ?>

    </div>


    <h2>
        <img src="<?php echo base_url();?>assets/img/icon_scholarship.png" class="right"> Scholarship Requirements
    </h2>
    <p>
        <strong>
            Basic Requirements: 
        </strong>
    </p>

            <ul>
                <li>Accomplished <?php echo anchor(base_url()."assets/pdf/MACES From 2011.pdf","MACES Form (for new applicant)<i class='icon icon-download'></i>"); ?>, <?php echo anchor(base_url()."assets/pdf/MACES From 2011.pdf","MACES Form (for continuing applicant) <i class='icon icon-download'></i>"); ?></li>
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

</div>

</div><!-- end row -->

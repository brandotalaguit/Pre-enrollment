<div class="row">
<div class="span7">    
<?php
//A1110599
$SubTotal = 0.00;

// dump($assessment);
// dump($tuition);

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
            <td class="assessment_td">No. of Hours</td>
            <td><?php echo $assessment['no_rle_hours'] ?></td>
        </tr>
        <tr>
            <td class="assessment_td">Rate per Hour</td>
            <td><?php echo $tuition['rle_rate_per_hour'] ?></td>
        </tr>
        <thead>
        <tr>
            <th>RLE and Affiliation Fee</th>
            <th><?php echo nf($assessment['no_rle_hours'] * $tuition['rle_rate_per_hour']) ?></th>
        </tr>
        </thead>

        <tr>
            <td class="assessment_td">No. of Units</td>
            <td><?php echo $assessment['no_lab_units'] ?></td>
        </tr>
        <tr>
            <td class="assessment_td">Rate per Unit</td>
            <td><?php echo $tuition['lab_rate_per_unit'] ?></td>
        </tr>
        <thead>
        <tr>
            <th>Laboratory Fee</th>
            <th><?php echo nf($assessment['no_lab_units'] * $tuition['lab_rate_per_unit']) ?></th>
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

<?php if (count($student_assessment) && $_SESSION['sy_sem']['SemId'] != 3): ?>
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

                    <?php if ( ! empty($nstp_subject)): ?>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>NSTP Fee</td>
                        <td>100.00</td>
                    </tr>
                    <tr>
                        <td>Sub-Total</td>
                        <td><strong>100.00</strong></td>
                    </tr>
                    <?php endif ?>
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

    <?php if ( ! empty($assessment['payment_scheme'])) { ?>
        
              <div class="alert alert-info" style='width:80%'>
                  
                    <?php if ($assessment['assessed_by'] == 0) { /* ?>
                    <a href="#myModalS" class='btn btn-small btn-default right' data-toggle="modal"><strong>Change payment scheme</strong></a>
                    <?php */ } ?>

                  <h4>PAYMENT SCHEME</h4>

                  <hr>
                  <?php if ($assessment['payment_scheme'] == 1): ?>
                      <strong>Full Payment</strong>
                      <p>Grand Total <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
                      <p>Less: 10% Discount <u class='pull-right'>(<strong><?php echo nf($tuition_fee * 0.10) ?></strong>)</u></p>
                      <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees - ($tuition_fee * 0.10)) ?></strong></u></p>
                      
                  <?php endif ?>

                  <?php if ($assessment['payment_scheme'] == 2): ?>
                      <strong>Installment</strong>
                      <p>First Payment (30% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.30) ?></strong></u></p>
                      <p>Balance (Divided into 4 months) <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.30)) ?></strong></u></p>
                      <p>Total Monthly Fees <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.30))/4) ?></strong></u></p>
                      <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
                  <?php endif ?>

                  <?php if ($assessment['payment_scheme'] == 3): ?>
                      <p>First Payment (10% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.10) ?></strong></u></p>
                      <p>Remaining Balance <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.10)) ?></strong></u></p>
                      <p>Balance plus 5% interest <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
                      <p>Total Monthly Fees <u class='pull-right'><strong><?php echo  nf((($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05))/4) ?></strong></u></p>
                      <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
                  <?php endif ?>
              </div>

    <?php } ?>


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

</div></div>

<?php 
    echo form_open('student/coahs_payment_method','id="coahs_payment_method"');
    echo form_hidden('base_url', base_url());
    echo form_hidden('stud_tuition_id', $assessment['stud_tuition_id']);
?> 
<div class="modal hide fade" id="myModalS" style="width:600px;">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>SELECT PAYMENT SCHEME</h3>
  </div>
  <div class="modal-body" style='max-height:500px;'>

      <div class="row-fluid">
        <div class="alert alert-danger">
            
            <h4>PAYMENT SCHEME</h4>
            <label class="radio">
                <input type="radio" name="payment_scheme" value="1" <?php $assessment['payment_scheme'] == '1' ? $check = TRUE : $check = FALSE; echo set_radio('payment_scheme', '1', $check);?>>
                <span class='badge badge-important'>A</span>
                <strong>Full Payment</strong>
                <p>Grand Total <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
                <p>Less: 10% Discount <u class='pull-right'>(<strong><?php echo nf($tuition_fee * 0.10) ?></strong>)</u></p>
                <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees - ($tuition_fee * 0.10)) ?></strong></u></p>
            </label>

            <label class="radio">
                <input type="radio" name="payment_scheme" value="2" <?php $assessment['payment_scheme'] == '2' ? $check = TRUE : $check = FALSE; echo set_radio('payment_scheme', '2', $check);?>>
                <span class='badge badge-important'>B</span>
                <strong>Installment</strong>
                <p>First Payment (30% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.30) ?></strong></u></p>
                <p>Balance (Divided into 4 months) <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.30)) ?></strong></u></p>
                <p>Total Monthly Fee <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.30))/4) ?></strong></u></p>
                <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees) ?></strong></u></p>
            </label>

            <label class="radio">
                <input type="radio" name="payment_scheme" value="3" <?php $assessment['payment_scheme'] == '3' ? $check = TRUE : $check = FALSE; echo set_radio('payment_scheme', '3', $check);?>>
                <span class='badge badge-important'>C</span>
                <p>First Payment (10% of Total Fees) <u class='pull-right'><strong><?php echo  nf($total_fees * 0.10) ?></strong></u></p>
                <p>Remaining Balance <u class='pull-right'><strong><?php echo  nf($total_fees - ($total_fees * 0.10)) ?></strong></u></p>
                <p>Balance plus 5% interest <u class='pull-right'><strong><?php echo  nf(($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
                <p>Total Monthly Fee <u class='pull-right'><strong><?php echo  nf((($total_fees - ($total_fees * 0.10)) + (($total_fees - ($total_fees * 0.10)) * 0.05))/4) ?></strong></u></p>
                <p>Total Fees <u class='pull-right'><strong><?php echo nf($total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05)) ?></strong></u></p>
            </label>
        </div>

      </div>

  </div>
  <div class="modal-footer">
  

    <input type="submit" id="btn_submit_coahs_payment_method" name="btn_submit_coahs_payment_method" value="Submit" class="btn btn-primary btn-large" style="font-weight:bold">
    
    <a href="#" class="btn btn-large" data-dismiss="modal" style="font-weight:bold">Close</a>
  </div>
    
</div>
<?php echo form_close(); ?>

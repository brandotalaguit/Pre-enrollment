<div class="row">
<div class="span7">    
    <!-- <pre>
        <?php //print_r($student_assessment) ?>
        <?php //print_r($student_tokenfee) ?>
    </pre> -->
<?php

$SubTotal = 0.00;
$TuitionFee = TUITION_FEE;
$Exemption = $AssDetails3 ? $AssDetails3['ScholarshipDesc'] : '';
// $CityHall = ($TuitionFee - $AssDetails4[0]['Amount']); //$_SESSION['student_info']['IsMakatiResident'] == 1 ? 9000.00 : 7000.00;
$CityHall = ($TuitionFee - $student_tokenfee['Amount']);
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

<p class='lead'>Next step:<br/>
    Please print this advising slip and go to your payment scheduled.

</div>
<div class="span45">

    <h2> Reminders </h2>
    
    <p>
        <strong>
            For those student who applied for scholarship and changed their residency. Please proceed to the Accounting Office (Admin. Building Ground Floor).
        </strong>
    </p> 
         
    <p>
        The courses that you have just selected will <strong><span class='underline'>ONLY BE VALID for 3 DAYS</span></strong>. Non-payment of the assessment will
        automatically <strong><span class='underline'>REMOVE</span></strong> the enrolled courses. Please pay on or before 
        <span class="lead underline"><?php echo date('F d, Y', strtotime($_SESSION['enrollment_trans']['PaymentDate'])) ?></span>
        at any <strong>LANDBANK</strong> branch nearest you. Thank you for complying.
    </p>   

    <?php 
        echo form_open('student/landbank_payment_method','id="landbank_payment_method"');
        echo form_hidden('base_url', base_url());
    ?> 
    <div class='alert alert-success' style='width:85%'>
    <?php 
        /**
         * Start Token Fee
         */
     ?>

    <?php if ($TokenFee > 0) : ?>
                <p>
                    <strong>
                        Before printing, please click on the TOKEN FEE payment options below:
                    </strong>
                </p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>PARTIAL PAYMENT</th>
                            <th>FULL PAYMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='span8'>

                                <?php
                                /**
                                 * Partial Payment 
                                 */
                                 ?>

                                <?php if ($TokenFee <= ONE_THOUSAND): ?>

                                                    <div class="row-fluid">
                                                        <?php if ($TokenFee > FIVE_HUNDRED): ?>

                                                            <label class="radio inline span5">
                                                                <input type="radio" name="partialpayment" value="<?php echo FIVE_HUNDRED; ?>">Php <?php echo FIVE_HUNDRED; ?>
                                                            </label>

                                                        <?php endif ?>



                                                        <?php if ($TokenFee == ONE_THOUSAND): ?>

                                                            <label class="radio inline span5">
                                                                <input type="radio" name="partialpayment" value="<?php echo SEVEN_HUNDRED; ?>">Php <?php echo SEVEN_HUNDRED; ?>
                                                            </label>

                                                        <?php endif ?>
                                                    </div>

                                <?php else: ?>

                                                    <div class="row-fluid">
                                                        <label class="radio inline span5">
                                                            <input type="radio" name="partialpayment" value="<?php echo FIVE_HUNDRED; ?>">Php <?php echo FIVE_HUNDRED; ?>
                                                        </label>
                                                        <label class="radio inline span5">
                                                            <input type="radio" name="partialpayment" value="<?php echo SEVEN_HUNDRED; ?>">Php <?php echo SEVEN_HUNDRED; ?>
                                                        </label>
                                                    </div>

                                                    <?php if ($TokenFee == THREE_THOUSAND): ?>
                                                        
                                                        <div class="row-fluid">
                                                            <label class="radio inline span5">
                                                                <input type="radio" name="partialpayment" value="<?php echo ONE_THOUSAND_FIVE; ?>">Php <?php echo ONE_THOUSAND_FIVE; ?>
                                                            </label>
                                                            <label class="radio inline span5">
                                                                <input type="radio" name="partialpayment" value="<?php echo TWO_THOUSAND; ?>">Php <?php echo TWO_THOUSAND; ?>
                                                            </label>
                                                        </div>

                                                        <label class="radio inline span2">
                                                            <input type="radio" name="partialpayment" value="<?php echo TWO_THOUSAND_FIVE; ?>">Php <?php echo TWO_THOUSAND_FIVE; ?>
                                                        </label>

                                                    <?php endif ?>


                                <?php endif ?>

                                <?php 
                                /**
                                  * End Partial Payment
                                  */ 
                                ?>

                            </td>
                            <td class='span4'>
                                <?php 
                                /**
                                 * Full Payment
                                 */
                                 ?>

                                <?php if ($TokenFee <= ONE_THOUSAND): ?>

                                    <?php if ($TokenFee == ONE_THOUSAND): ?>
                                        <label class="radio inline">
                                            <input type="radio" name="partialpayment" value="<?php echo ONE_THOUSAND; ?>">Php <?php echo ONE_THOUSAND; ?>
                                        </label>
                                    <?php else: ?>

                                                <?php if ($TokenFee >= FIVE_HUNDRED): ?>
                                                    <label class="radio inline">
                                                        <input type="radio" name="partialpayment" value="<?php echo FIVE_HUNDRED; ?>">Php <?php echo FIVE_HUNDRED; ?>
                                                    </label>
                                                <?php endif ?>

                                    <?php endif ?>

                                
                                <?php else: ?>
                                
                                    <?php if ($TokenFee == THREE_THOUSAND): ?>
                                        <label class="radio inline">
                                            <input type="radio" name="partialpayment" value="<?php echo THREE_THOUSAND; ?>">Php <?php echo THREE_THOUSAND; ?>
                                        </label>
                                    <?php else: ?>
                                        <label class="radio inline">
                                            <input type="radio" name="partialpayment" value="<?php echo ONE_THOUSAND_FIVE; ?>">Php <?php echo ONE_THOUSAND_FIVE; ?>
                                        </label>
                                    <?php endif ?>
                                
                                <?php endif ?>

                                <?php 
                                /**
                                 * End Full Payment
                                 */
                                 ?>
                            </td>


                        </tr>
                    </tbody>
                </table>
    
    <?php endif ?>    
    
    <?php 
    /**
     * End Token Fee 
     */
     ?>
     </div><!-- end of div.well-->
<!-- 
    <p class='alert alert-danger' style='width:85%'>
        *There will be a minimal fee of Php 30.00 for every transaction at Landbank (two deposit slips will only be charged Php 30.00 if it is submitted at the same time).
    </p>

    <p class='alert alert-danger' style='width:85%'>
        *There will be a minimal fee of Php 10.00 for every transaction ("Online payment").
    </p>

 -->    <p>
        <a href="#myModalL" class='btn btn-large btn-warning' data-toggle="modal"><strong>SELECT YOUR PAYMENT METHOD HERE</strong></a>
    </p>


    <div class="modal hide fade" id="myModalL" style="width:600px">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>SELECT PAYMENT METHOD</h3>
      </div>
      <div class="modal-body">

          <div class="row-fluid">
            <label class="radio">
              <input type="radio" name="methodpayment" value="<?php echo LANDBANK_ATM; ?>">
              <strong>ONLINE PAYMENT (via ATM account)</strong>
              <p class="muted">
                  You will be redirected to Landbank of the Philippine site.
              </p>
            </label>
            <p class='alert alert-success'>
                <strong>* </strong> There will be a minimal fee of Php 10.00 for every transaction ("Online payment").
            </p>
            <hr>
            <label class="radio">
              <input type="radio" name="methodpayment" value="<?php echo LANDBANK_OTC; ?>">
              <strong>OVER-THE-COUNTER (Landbank branch)</strong>
            </label>
            <p class='alert alert-success'>
                <strong>* </strong> There will be a minimal fee of Php 30.00 for every transaction at Landbank (two deposit slips will only be charged Php 30.00 if it is submitted at the same time).
            </p>

          </div>

      </div>
      <div class="modal-footer">
      

        <input type="submit" id="btn_submit_payment_method" name="btn_submit_payment_method" value="Submit" class="btn btn-primary btn-large" style="font-weight:bold">
        
        <a href="#" class="btn btn-large" data-dismiss="modal" style="font-weight:bold">Close</a>
      </div>
        <p class='alert alert-info' style="margin-bottom:0px; border-radius: 0px;">
            By clicking the "Submit" you accept the <?php echo anchor(base_url(), 'General Conditions of Use', ['target' => '_blank']); ?>.
        </p>
    </div>
    <?php echo form_close(); ?>


</div></div>

<?php 
    // print_r($AssDetails1);   #Student Org
    // print_r($AssDetails2);   #Additional
    // print_r($AssDetails3);   #Scholarship
    // print_r($AssDetails4);   #Tuition Fee
 ?>


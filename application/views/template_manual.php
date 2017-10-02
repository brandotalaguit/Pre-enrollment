<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $site_title; ?><?php if(isset($page_title)) echo $page_title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <link rel="shortcut icon" href="<?php echo $site_icon; ?>">        
        
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="all">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css" media="all">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" media="all">    
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.fancybox.pack.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/disable.js" ></script>  
    <script>
    $(function()
    {
        $('.fancy-box').fancybox();
    });
    </script>
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]-->
    <style>
    #main img {padding-left:5px;margin-bottom:20px}
    #main p {padding-left:5px;margin-bottom:10px}
    #main h3 {padding-left:5px}
    </style>
</head>
<body>
<div class="container"> 
    <header>      
            <div class="row">
              <div class="span6 offset3">
                <img src="<?php echo base_url(); ?>assets/img/umak_logo.png" />
                <h1>University of Makati</h1>
                <h2>Online Encoding and Assessment User Manual</h2>   
              </div>
              <div class="span6">
              
              </div>                
            </div>
    </header>
    <div role="main" id="main" style="padding:0;margin-top:20px">          
        
            <h3>Step 1: LOGIN</h3>
            <p>            
            Enter your Student Id and Password then click the Submit button.
            </p>
            
            <a href="<?php echo base_url(); ?>assets/screenshots/0.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            
            <img src="<?php echo base_url(); ?>assets/screenshots/0.JPG" width="450" />
            </a>
            
            <p>            
            <strong>NOTE:</strong> You can see your password at your online/onsite printed Report of Grades.
            </p>

            <h3>Step 2:  ENCODING (SELECT THE SUBJECTS TO BE ENROLLED)</h3>
            <p>Check your curriculum to see what subjects you need to enroll. </p>
            <ul>
            <li>    
            Subjects with <span class="label label-info">TAKEN</span> remarks are considered PASSED.<br/>
            <li>
            Subjects with <span class="label label-info">INC</span> remarks are considered INCOMPLETE.<br/>
            <li>
            Subjects with <span class="label label-success">CAN BE ENROLLED</span> remarks are the subjects that you can enroll.<br/>
            <li>
            Subjects with <span class="label label-important">CANNOT BE ENROLLED</span> are the subjects that you cannot enroll because you have not<br/> taken/passed the pre-requisites or the subject is not offered. Just scroll your mouse pointer on the black exclamation mark beside the label CANNOT BE ENROLLED to identify the reason.
            </ul>
            <a href="<?php echo base_url(); ?>assets/screenshots/1.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/1.JPG" width="450" />
            </a>
            <a href="<?php echo base_url(); ?>assets/screenshots/2.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/2.JPG" width="450" />
            </a>
            
            <p>
            Click the <span class="label label-success">CAN BE ENROLLED</span> remarks to open the schedule window. Click the Submit Course button to save the selected schedule. If the course is labelled in red, it is already full and cannot be selected. 
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/3.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/3.JPG" width="450" />
            </a>
            <p>
            After you have saved your selected schedule, the web application will display your current schedule. 
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/4.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/4.JPG" width="450" />
            </a>

            <p>
            If you want to enroll on a block section schedule, you need to click the block section button below the selected schedule. However, you still need to add a section for PE and NSTP since it is not part of your block section.
            </p>
            <p class="alert alert-info">    
            <strong>Note:</strong> Selecting a block schedule will delete your previously chosen schedule.
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/5.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/5.JPG" width="450" />
            </a>
            <p>
            If you want to delete an existing schedule, click the <strong>X</strong> button on the left side of the selected schedule. A window will open to confirm your deletion.
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/10.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/10.JPG" width="450" />
            </a>
            <h3>Step 3: CONFIRMATION OF SELECTED SCHEDULE</h3>
            <p>
            To proceed with online enrollment, click the SAVE SCHEDULE button. Make sure you selected all the subjects you want to enroll. These subjects are unchangeable without the process of <b>CHANGE OF MATRICULATION</b>. <br/>
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/9.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/9.JPG" width="450" />
            </a>
           <!--  <h3>STEP 4: APPLICATION FOR CHANGE OF RESIDENCY AND SCHOLARSHIP</h3>
            <p>
            The web application will display the procedures on how to apply for change of residency and scholarship. Click the NEXT button to proceed.
            </p>
            <a href="<?php echo base_url(); ?>assets/screenshots/14.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/14.JPG" width="450" />
            </a> -->
            <h3>STEP 4: VIEWING AND PRINTING OF ENCODED SUBJECTS AND ASSESSMENT</h3>
            <p>
            The web application will display your encoded subjects and assessment. <b>For COAHS students, after saving, you have to select a payment scheme and wait for the approval of the accounting office before you could print your advising slip</b>.
            </p>
            
            
            <a href="<?php echo base_url(); ?>assets/screenshots/15.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/15.JPG" width="450" />
            </a>
            <a href="<?php echo base_url(); ?>assets/screenshots/16.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/16.JPG" width="450" />
            </a>
            

            <p>To print, click the View Printer Friendly Version button on the lower right side of the Reminders area.</p>
            <a href="<?php echo base_url(); ?>assets/screenshots/17.JPG" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/17.JPG" width="450" />
            </a>
            <a href="<?php echo base_url(); ?>assets/screenshots/18.JPG" class="
            fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/screenshots/18.JPG" width="450" />
            </a>
            <h4 class="alert alert-success">NOTE: Don’t forget to bring your printed Encoded Subjects and Assessment/Advising Slip.
            </h4>
           <h3>STEP 5: ASSESSMENT AT ACCOUNTING OFFICE (If Advised)
            </h3>
            <a href="<?php echo base_url(); ?>assets/img/assessment.jpg" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/img/assessment.jpg" width="450" />
            </a>	
            <h3>STEP 6: PAYMENT OF FEES</h3>
            <p>
            Schedule for payment is specified at your Printer Friendly version of Encoded Subjects and Assessment. You are allowed to pay the amount due only at the University of Makati CASH Office on the printed date of payment.
            </p>
            <p>
            PAYMENT of TOKEN & MISCELLANEOUS FEES: Go to the CASH Office<br/>
            </p>
            <a href="<?php echo base_url(); ?>assets/img/payment.jpg" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/img/payment.jpg" width="450" />
            </a>
            <h3>STEP 7: AFTER PAYMENT OF BOTH MISCELLANEOUS AND TOKEN FEE, LOG-IN AGAIN AT UMAK.EDU.PH/OLEA AND PRINT YOUR COR (for 1st Year students, printing of COR is at the Registrar's Office).
            </h3>
            <a href="<?php echo base_url(); ?>assets/img/printing.jpg" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/img/printing.jpg" width="450" />
            </a>
            <a href="<?php echo base_url(); ?>assets/img/end.jpg" class="fancy-box" data-fancybox-group="gallery" title="">
            <img src="<?php echo base_url(); ?>assets/img/end.jpg" width="450" />
            </a>
        </div>
    
<footer>
    <div class="row">
        <div class="span7">
        <img src="<?php echo base_url(); ?>assets/img/itc.png" width="70" style="float:left;margin:0px 5px" >
    <p>Copyright © 2013. All Rights Reserved. University of Makati Online Encoding and Assessment Beta Version. Coded by UMak ITC Department.</p>
        </div>
        <div class="span5">
    <p>This website is tested and supported in major modern browsers like Opera, Chrome, Safari, Internet Explorer 8+, and Firefox.</p>
        </div>
    </div>
</footer> 

</div>
</body>
</html>    
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $site_title; ?><?php if(isset($page_title)) echo $page_title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <link rel="shortcut icon" href="<?php echo base_url() . $site_icon; ?>">                
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slider-style.css">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>
    <script>    
    window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'> alert('Hello');  \x3C/script>")
    </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/lofslidernews.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>
      
    <?php if (ENVIRONMENT == 'production'): ?>
    <script src="<?php echo base_url(); ?>assets/js/disable.js" ></script>  
    <?php endif ?>
    
    <script type="text/javascript">

     $(document).ready( function(){ 
        // buttons for next and previous item            
        var buttons = { previous:$('#jslidernews1 .button-previous') ,
                next:$('#jslidernews1 .button-next') };     

         $('#jslidernews1').lofJSidernews( { interval : 6000,

                          direction   : 'opacitys', 
                          easing      : 'easeInOutExpo',
                          duration    : 1200,
                          auto      : true,
                          maxItemDisplay  : 4,
                          navPosition     : 'horizontal', // horizontal
                          navigatorHeight : 32,
                          navigatorWidth  : 80,
                          mainWidth   : 940,
                          buttons     : buttons } );  
      });
    </script>
    <!--[if lte IE 7]>
    <script>
        alert('Youre using a lower version of Microsoft Internet Explorer. To use this application you must upgrade to a higher version of Microsoft Internet Explorer');
        window.location = "https://windows.microsoft.com/en-us/internet-explorer/products/ie/home"
    </script>    
    <![endif]-->    
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="https://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]-->    
</head>
<body>
<div class="container"> 
<header>	  
        <div class="row">
          <div class="span6">
        		<img src="<?php echo base_url(); ?>assets/img/umak_logo.png" />
            <h1>University of Makati</h1>
            <h2>Online Encoding and Assessment Beta Version</h2>	  
          </div>
          <div class="span6">
            <div class="navbar">
              <div class="navbar-inner-blue">
            <div class="container logout">       
            <img src="<?php echo base_url(); ?>assets/img/icon_manual.png">
            <a class="brand" href="<?php echo base_url(); ?>site/manual" style="color:#fff;font-size:15px" target="_blank">View Online Encoding and Assessment User Manual</a>                                                    
            </div>
          </div>
          </div>      
          </div>
        </div>

</header>
<div class="banner">
  <div id="jslidernews1" class="lof-slidecontent" style="width:940px; height:350px;">
  <div class="preload"><div></div></div>
         <!-- MAIN CONTENT --> 
              <div class="main-slider-content" style="width:940px; height:350px;">
                <ul class="sliders-wrap-inner">
                    <li>
                          <img src="<?php echo base_url(); ?>assets/img/front.jpg" title="Newsflash 2" >           
                          <div class="slider-description">                            
                            <h2>Online Encoding and Assessment Procedure</h2>                            
                         </div>
                    </li> 
                    <li>
                          <img src="<?php echo base_url(); ?>assets/img/go_online.jpg" title="Newsflash 2" >           
                          <div class="slider-description">                            
                            <h2>Go Online</h2>
                            <span>
                            https://umak.edu.ph/olea
                            </span>
                            <br><br>
                            <p>For shifters, returnees, or culled students (those who did not meet the required GWA’s), please
                            proceed to the Office of the Registrar (on-site)
                            </p>
                         </div>
                    </li> 
                    <li>
                      <img src="<?php echo base_url(); ?>assets/img/select_schedule.jpg" title="Newsflash 5" >            
                        <div class="slider-description">                          
                           <h2>Choose a course you wish to enroll from the curriculum.</h2>
                            <span>Reminders:</span> 
                            <p>
                            Only students who passed the prerequisite/s are allowed to enroll to advanced courses.
                            </p>
                            <p>
                            Please follow the total number of allowable load per unit
                            </p>
                         </div>
                    </li>
	<li>
                      <img src="<?php echo base_url(); ?>assets/img/printing_encoded.jpg" title="Newsflash 5" >            
                        <div class="slider-description">                           
                           <h2>Print your Encoded Subjects and Assessment (Advising Slip)</h2>
                            <span>Reminders:</span> 
                            <p>
                            Students are only allowed to pay their assessment on the scheduled payment date at the CASH Office  
                            </p>
                            <p>
                            Don’t forget to bring 
                            your printed Advising Slip.

                            </p>
                         </div>
                    </li>
                    
                    <li>
                      <img src="<?php echo base_url(); ?>assets/img/maces.jpg" title="Newsflash 5" >            
                        <div class="slider-description">
                           
                           <h2>Scholarship</h2>
                            <p>Download (on-line) or secure on-site MACES Scholarship Form then proceed to MACES (on-site) for approval
                            </p>
                         </div>
                    </li> 
	<li>
                      <img src="<?php echo base_url(); ?>assets/img/assessment.jpg" title="Newsflash 5" >            
                        <div class="slider-description">                          
                            <h2>
                            Assessment/Change of Residency
                            </h2>
                            <p>
                            For students who have Change of Residency,
                            (From Non-Makati to Makati)
                            </p>
                            <p>Download Residency Form (on -line) and proceed to the Accounting Office (on-site) for approval
                            </p>
                         </div>
                    </li> 
                    
                    <li>
                      <img src="<?php echo base_url(); ?>assets/img/payment.jpg" title="Newsflash 3" >            
                        <div class="slider-description">
                          
                            <h2>Payment</h2>
                            <p>Student pays the Token and other fees at the Cashier’s Office (on-site)
                            </p>
                            <p>                            
                            For students who have computer laboratory courses, please proceed to the Cash Office (on-site) for payment of Laboratory fee.
                            </p>  
                         </div>
                    </li> 
                   <li>
                      <img src="<?php echo base_url(); ?>assets/img/printing.jpg" title="Newsflash 1" >           
                         <div class="slider-description">                           
                            <h2>Printing of C.O.R.</h2>
                            <p>After payment, log-in again at umak.edu.ph/olea and print your Certificate of Registration (COR)
                            </p>
                         </div>
                    </li> 
                   
                                        
                    
                    
                    <li>
                      <img src="<?php echo base_url(); ?>assets/img/end.jpg" title="Newsflash 5" >            
                        <div class="slider-description">                           
                           <h2>
                          Student receives his/her copy of the Official Certificate of Registration
                          (COR)
                          </h2>                            
                         </div>
                    </li>
                  </ul>   
            </div>
       <!-- END MAIN CONTENT --> 
           <!-- NAVIGATOR -->
           
            <div class="navigator-content">    
                  <h2 class="pull-left" style="color:#fff;padding:0 5px;font-size:27px">STEP</h2>              
                  <div class="button-previous">Previous</div>
                  <div class="navigator-wrapper">
                        
                        <ul class="navigator-wrap-inner">
                           <li><h1>1</h1></li>
                           <li><h1>2</h1></li>
                           <li><h1>3</h1></li>
                           <li><h1>4</h1></li>
                           <li><h1>5</h1></li>                           
                           <li><h1>6</h1></li>                           
                           <li><h1>7</h1></li>                           
                           <li><h1>8</h1></li>                           
                           <li><h1>9</h1></li>                           
                        </ul>
                  </div>
                  <div  class="button-next">Next</div>
             </div> 
          <!-- END OF NAVIGATOR -->
          <!-- BUTTON PLAY-STOP -->
          <div class="button-control"><span></span></div>
           <!-- END OF BUTTON PLAY-STOP -->
          
 </div> 

            
</div>


<div role="main" id="main_home">	
    <div class="row">
        <div class="span4" id="login">
        <?php echo form_open('/','id="login"'); ?>        
        <img src="<?php echo base_url(); ?>assets/img/icon_login.png" class="right"/>
        <h2>Login</h2>
        <span>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></span>        
        
        <p class="alert alert-info">
        Please provide your login credentials to start using your account. Your Student ID and Password are case-sensitive, so please enter them carefully. 
        </p>


        <?php if(isset($closed) && $closed): ?>
        <p class="alert alert-error">
          <b>
         <?php if ($system_maintenance == TRUE): echo $system_message; ?>
        <?php else: ?>
          <?php if ($limit_reached == FALSE): ?>
             Online Encoding and Assessment is now closed. Please see the Office of the Registrar.
          <?php endif ?>
         </b>
          <?php endif ?>
        </p>
        <?php endif; ?>

        <?php if(isset($open) && $open): ?>
        <p class="alert alert-error">
        <b>
        Online Encoding and Assessment is still closed. Please check the Registration Schedule.</b>
        </p>
        <?php endif; ?>


        <?php if(isset($no_error) && $no_error == FALSE): ?>
        <div class="alert alert-block alert-error" style="margin:5px 5px" >
              <a class="close" data-dismiss="alert">×</a>
              <h4 class="alert-heading">Access Denied!</h4>
              <?php echo validation_errors('',''); ?>
        </div>
        <?php endif; ?>

        <?php if($limit_reached == TRUE): ?>
        <div class="alert alert-block alert-error" style="margin:5px 5px" >
              <a class="close" data-dismiss="alert">×</a>
              <h4 class="alert-heading">Access Denied!</h4>
              <!-- <p>The system can only accommodate 1000 users at a time. Please visit this page again later.</p> -->
              <p>Maximum user has been reached. Please visit this page again later.</p>
        </div>
        <?php endif; ?>

        
        <?php if((isset($closed) && $closed) || (isset($open) && $open)): ?>
        <img src="<?php echo base_url(); ?>assets/img/login.png" />
        <?php else: ?>
        
        <label for="student_id">Student ID</label>
        <input type="text" name="student_id" class="span3" placeholder="Type your student id" <?php if($closed || $open) echo 'disabled'; ?>>
        <label for="password">Password <i class=""></i></label>
        <input type="password" name="password" class="span3" placeholder="Type your password" <?php if($closed || $open) echo 'disabled'; ?>>

        <p>                
        <button type="submit" value="Submit" id="btn_submit" name="btn_submit" class="btn btn-primary" <?php if($closed || $open) echo 'disabled'; ?>><b>Submit</b> <i class="icon-user icon-white"></i></button>
        </p>

        
        <img src="<?php echo base_url(); ?>assets/img/icon_forgotpassword.png" class="right"/>
        <p class="alert alert-success">
        For your online enrollment password, please access your <a href="https://umak.edu.ph/olrog">online report of grades</a>. 
        </p>
        
        <?php echo form_close(); ?>        
        <?php endif; ?>

       <div style="background:#006080;color:#fff;border:1px solid #006080;padding-left:5px" >
        <h3>&nbsp;Contact Us</h3>
        <p>If you have questions and inquiries regarding online enrollment, please feel free to contact us.<br/><br/>
        <!--<strong>Telephone No: 8831872 - 73 Local 230</strong> <br/>-->
        <strong>Email: itc_support@umak.edu.ph </strong><br/>
        </p>
        </div>	

        
        </div>       
        <div class="span8"> 

          <img src="<?php echo base_url(); ?>assets/img/icon_enrollmentschedule.png" class="right"/>
          <h2>Registration Schedule</h2>
          <span><?php echo $_SESSION['sy_sem']['SemDesc']; ?>, Academic Year <?php echo $_SESSION['sy_sem']['SyDesc']; ?></span>

    <?php if ($system_maintenance == TRUE): ?>
      <div class="row-fluid">
        <div class="row-fluid">
          <h3>ANNOUCEMENT:</h3>                
          <h4 style="color:red"><?php echo $system_message ?></h4>      
        </div>    
      </div>    
    
      <hr>
    <?php endif ?>
          

    <div class="row-fluid">
      <div class="row-fluid">
        <h3>ONLINE ENROLLMENT</h3>                
        <h4 style="color:red">Announcement: Due to technical requirements, ONLINE PAYMENT is postponed until further notice.</h4>      

      </div>    
    </div>

    
    <div class="row-fluid">
      <div class="row-fluid">
          <?php $this->load->view('annoucement/registration_sched_117')?>
      </div>
    </div>
    
    <hr><br>

          <div class="row">
            <div class="span4">
              <img src="<?php echo base_url(); ?>assets/img/icon_home.png" class="right"/>
              <h2>Change of Residency</h2>
              <p>
              <span>A student who claims to be a resident must attach any of the following: </span> 
              </p>
              <ol>
                  <li>Accomplished <?php echo anchor(base_url()."assets/pdf/RV Form.pdf","Residency Verification Form <i class='icon icon-download'></i>",'target="_blank"'); ?></li>
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
                <strong>Should there be a change in residency; the student <br/> is required to present necessary documents.</strong>
            </div>
              
          </div>                                  
          <div class="span4">
              <img src="<?php echo base_url(); ?>assets/img/icon_scholarship.png" class="right"/>
              <h2>Scholarship</h2>
              <p><span>Basic Requirements:</span></p>                  
              <ul>
                  <li>Accomplished <?php echo /*anchor(base_url('../assets/pdf/ScholarshipApplicationForm_NEWSCHOLAR.pdf'),*/"MACES Form (for new applicant)<i class='icon icon-download'></i>"/*,'target="_blank"')*/; ?>, <?php echo /*anchor(base_url('../assets/pdf/ScholarshipApplicationForm_CONTINUINGSCHOLAR.pdf'), */"MACES Form (for continuing applicant) <i class='icon icon-download'></i>"/*,'target="_blank"')*/; ?></li>
                  <li><?php echo anchor(base_url()."assets/pdf/RV Form.pdf","Residency Verification Form <i class='icon icon-download'></i>",'target="_blank"'); ?></li>
                  <li>1 x 1 ID Picture(for new scholar applicant)</li>
                  <li>Encoded Subjects and Assessment</li>
              </ul>
        
              
              <p><strong>Other Requirements:</strong></p>
              <?php echo anchor(base_url()."assets/pdf/scholarship.pdf","Click here for additional requirements for other scholarships.",array('target' => '_blank')); ?>
          
          </div>        
        </div>    
      </div>
    </div>
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
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $site_title; ?><?php if(isset($page_title)) echo $page_title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <link rel="shortcut icon" href="<?php echo $site_icon; ?>">        
        
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>
    <script src="<?php echo base_url(); ?>assets/js/disable.js" ></script>  
    <script>    
    window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'> alert('Hello');  \x3C/script>")
    </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>    
    <script>
    $(function(){
      $('.remarks').tooltip({
        selector: "a[rel=tooltip]"
      });
    });
    </script>
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]-->
</head>
<body>
<div class="container"> 
<header>	
		<div class="row">
      <div class="span6">
      <img src="<?php echo base_url(); ?>assets/img/umak_logo.png" />
      <h1>University of Makati</h1>
      <h2>Online Enrollment Beta Version</h2>
      </div>
      
      <div class="span6" id="navigation">          
          <div class="navbar">
          <div class="navbar-inner-blue">
            <div class="container logout">       
            <a class="brand" href="#" style="color:#fff">   Welcome!                                           
              <?php  echo $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Lname']; ?></a>
              <a href="<?php echo base_url();?>assessment/logout" class="right">              
              <img src="<?php echo base_url(); ?>assets/img/icon_logout_s.png">            
              </a>                  
            </div>
          </div>
          </div>      
      </div>
      
    </div> 
	
</header>
<div role="main" id="main">	   
      <img src="<?php echo base_url(); ?>assets/employee_pics/<?php echo strtoupper($_SESSION['user_info']['EmpId']); ?>.JPG" width="100"  id="student_pic"/> 
      <h2><?php echo $_SESSION['user_info']['Designation'];?></h2> 
      <h5>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></h5>
      <table class="table table-bordered table-condensed table-striped dth">
          <tr>
              <th width="15%">Office</th>
              <td width="35%"><?php echo strtoupper($_SESSION['user_info']['Office']); ?></td>
              <th width="15%">Academic Year</th>
              <td width="35%"><?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></td>
          </tr>
          <tr>
              <th>Name</th>
              <td><?php echo $_SESSION['user_info']['Fname'] . ' ' . $_SESSION['user_info']['Mname'] . ' ' . $_SESSION['user_info']['Lname']; ?></td>
              <th>Employee No.</th>
              <td><?php echo strtoupper($_SESSION['user_info']['EmpId']); ?></td>
          </tr>
      </table>

  <div class="content">
      <?php $this->load->view($main_content); ?>
  </div>

</div>

<footer>
    <div class="row">
        <div class="span7">
        <img src="<?php echo base_url(); ?>assets/img/itc.png" width="70" style="float:left;margin:0px 5px" >
    <p>Copyright © 2013. All Rights Reserved. University of Makati Online Enrollment Beta Version. Coded by UMak ITC Department.</p>
        </div>
        <div class="span5">
    <p>This website is tested and supported in major modern browsers like Opera, Chrome, Safari, Internet Explorer 8+, and Firefox.</p>
        </div>
    </div>
</footer>
</div>
</body>
</html>
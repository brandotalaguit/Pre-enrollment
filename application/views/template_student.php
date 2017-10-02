<?php
function array_unique_key_group($array) {
if(!is_array($array))
    return false;

$temp = array_unique($array);
foreach($array as $key => $val) {
    $i = array_search($val,$temp);
    if(!empty($i) && $key != $i) {
        $temp[$i.','.$key] = $temp[$i];
        unset($temp[$i]);
    }
}
return $temp;
}
?>
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/new_custom.css">
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>
      
    <?php if (ENVIRONMENT == 'production'): ?>
    <script src="<?php echo base_url(); ?>assets/js/disable.js" ></script>  
    <?php endif ?>
    
    <script>    
    window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'> alert('Hello');  \x3C/script>")
    </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
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
      <h2>Online Encoding and Assessment Beta Version</h2>
      </div>
      
      <div class="span6" id="navigation">          
          <div class="navbar">
          <div class="navbar-inner-blue">
            <div class="container logout">       
            <a class="brand" href="#" style="color:#fff">Welcome!               
              <?php if($_SESSION['student_info']['Gender'] == 'F') echo 'Ms.'; else { echo 'Mr.'; } ?>
              
              <?php  echo $_SESSION['student_info']['Lname']; ?></a>
              <a href="<?php echo base_url();?>student/logout" class="right">              
              <img src="<?php echo base_url(); ?>assets/img/icon_logout_s.png">            
              </a>                  
            </div>
          </div>
          </div>      
      </div>
      
	  </div> 
</header>

<div role="main" id="main">	   
  <?php $this->load->view('studentinfo'); ?>
  
  <?php $this->load->view($main_content); ?>
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

<script type="'text/javascript'">

</script>
</html>

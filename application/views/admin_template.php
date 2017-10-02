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
    <script>    
    window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'> alert('Hello');  \x3C/script>")
    </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>
    <!--[if lte IE 7]>
    <script>
        alert('Youre using a lower version of Microsoft Internet Explorer. To use this application you must upgrade to a higher version of Microsoft Internet Explorer');
        window.location = "http://windows.microsoft.com/en-us/internet-explorer/products/ie/home"
    </script>    
    <![endif]-->    
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]--> 
</head>
<body>
<div class="container"> 
    <header style="margin:0 250px">      
        
            <img src="<?php echo base_url(); ?>assets/img/umak_logo.png" />
            <h1>University of Makati</h1>
            <h2>Online Enrollment Beta Version</h2>   
        
    </header>
    <div id="admin_main" role="main"  style="margin:0 200px;padding:5px 5px">        
        <img src="<?php echo base_url(); ?>assets/img/icon_login.png" class="pull-right"/>
        <h2>Administrator Login</h2>
        <span>A.Y. <?php echo $_SESSION['sy_sem']['SyDesc'] . ' - ' . $_SESSION['sy_sem']['SemDesc']; ?></span>
        <p>Please provide your login credentials to start using your account. Your Username and Password are case-sensitive, so please enter them carefully. </p>
        <?php echo form_open('site/admin'); ?>
        <?php if(isset($no_error) && $no_error == FALSE): ?>
        <div class="alert alert-error">
        <h5>Error:</h5>
        <?php echo validation_errors('<p>','</p>'); ?>
        </div>
        <?php endif; ?>
        <label for="user_name"><b>Username</b></label>
        <input type="text" size="40" name="user_name" id="user_name">
        <label for="admin_password"><b>Password</b></label>
        <input type="password" size="40" name="admin_password" id="admin_password">
        <p>
        <button type="submit" name ="btn_login" value="Login" class="btn btn-primary">Login <i class="icon-white icon-user"></i></button>
        </p>
        <?php echo form_close(); ?>
        
    </div>
    <footer style="margin:0 200px">
        
                <img src="<?php echo base_url(); ?>assets/img/itc.png" width="70" style="float:left;margin:-1px 5px" >    
                <p>Copyright &copy; <?php echo date('Y'); ?>. All Rights Reserved. University of Makati Online Enrollment Beta Version. Coded by UMak ITC Department.
                <br/>
                </p>
        
    </footer>
</div>
</body>
</html>
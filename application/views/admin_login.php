<img src="<?php echo base_url(); ?>assets/img/icon_login.png" />
<h2>Administrator Login</h2>
<span>A.Y. 2011-2012 2nd Semester</span>
<p>Please provide your login credentials to start using your account. Your Username and Password are case-sensitive, so please enter them carefully. </p>
<?php echo form_open('site/admin'); ?>
<?php if(isset($no_error) && $no_error == FALSE): ?>
<div class="error_message" style="width:520px">
<h5>Error:</h5>
<?php echo validation_errors('<p>','</p>'); ?>
</div>
<?php endif; ?>
<label for="user_name">Username</label>
<input type="text" size="40" name="user_name" id="user_name">
<label for="admin_password">Password</label>
<input type="password" size="40" name="admin_password" id="admin_password">
<input type="submit" name ="btn_login" value="Login">
<?php echo form_close(); ?>
<?php 
	// header("Content-type: image/png");
    // $this->load->library('ciqrcode');

    // $params['data'] = 'http://www.umak.edu.ph/olea_development/';
    // $params['size'] = 2;
    // $data['img_params'] = $this->ciqrcode->generate($params);
    // echo '<img src="'.base_url().'tes.png" />';

	include( APPPATH . 'third_party/phpqrcode/phpqrcode.php'); 
    $data['img_params'] = QRcode::png('http://www.umak.edu.ph/olea_development/');    

	$url = 'http://www.umak.edu.ph/olea_development/qr_code/' . $_SESSION['student_id'];
	echo "<img src='qr_img.php?d=$url&e=H&s=2' />";
?>
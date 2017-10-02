<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('pagination');		
		
		$admin_default_m = array('user_m', 'tuition_m', 'misc_m', 'tuition_misc_m', 'assessment_m');

		$this->load->model($admin_default_m);
		// $this->load->model('activity_m');
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		// Login Check 
		$exception_uris = array(
			'site/login',
			'site/logout'
		);

		if (in_array(uri_string(), $exception_uris) == FALSE) 
		{
			if ($this->user_m->loggedin() == FALSE) 
			{
				redirect(site_url('site/login'));
			}
		}

		$attribute = array('role' => 'form', 'class' => 'form-horizontal');
		$this->data['form_url'] = form_open(NULL, $attribute);

		$this->data['counter'] = $this->uri->segment(3, 0);
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/controllers/Admin_Controller.php */
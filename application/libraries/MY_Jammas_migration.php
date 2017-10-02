<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Jammas_migration extends CI_Controller 
{

	protected $tablename = '';
	protected $fields = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->library('migration');
		$this->load->dbforge();
	}


	public function up()
	{
		$this->dbforge->add_column($this->tablename, $this->fields);
	}

	public function down()
	{
		if ($this->db->field_exists($this->fields, $this->tablename))
		$this->dbforge->drop_column($this->tablename, $this->fields);
	}

}

/* End of file MY_Migration.php */
/* Location: ./application/libraries/MY_Jammas_migration.php */
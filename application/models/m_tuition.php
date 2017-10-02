<?php
/**
* Filename: m_tuition.php
* Author: Brando Talaguit (ITC Developer)
* Date: 11/04/2015 07:20 PM
*/
class m_tuition extends MY_Model
{
	protected $table_name = "tbltuitions";
	protected $primary_key = "tuition_id";
	protected $primary_filter = "intval";
	protected $order_by = "tuition_id";
	
	protected $protected_attribute = array();

	public $rules = array();

	function __construct()
	{
		parent::__construct();
	}


}

/*Location: ./application/models/MY_Model.php*/

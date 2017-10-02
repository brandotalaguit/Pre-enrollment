<?php
class M_Guidance_National_Exam extends MY_Model
{
        if (ENVIRONMENT == 'production')  
         protected $table_name = "umakunil_guidance.tblnat";
        else
         protected $table_name = "umaktest_guidance.tblnat";
	
	protected $primary_key = "id";
	
	protected $order_by = "studno";

        protected $soft_delete = FALSE;
	
	protected $protected_attribute = array();

	public $rules = array();

	function __construct()
	{
		parent::__construct();
	}


}

/*Location: ./application/models/MY_Model.php*/

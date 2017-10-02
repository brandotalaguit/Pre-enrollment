<?php
class M_Studentinfo extends MY_Model
{
  protected $table_name = "tblstudinfo";
  
  protected $primary_key = "studno";
  
  protected $order_by = "Lname,Fname";

  protected $primary_filter = "strtoupper";

  protected $soft_delete = FALSE;
  
  protected $protected_attribute = array();

  public $rules = array(
        'Lname' => array('field' => 'Lname', 'label' => 'Lastname', 'rules' => 'trim|required|xss_clean'),
        'Fname' => array('field' => 'Fname', 'label' => 'Firstname', 'rules' => 'trim|required|xss_clean'),
        'Mname' => array('field' => 'Mname', 'label' => 'Middlename', 'rules' => 'trim|required|xss_clean'),
        'AddressStreet' => array('field' => 'AddressStreet', 'label' => 'Street', 'rules' => 'trim|required|xss_clean'),
        'AddressBarangay' => array('field' => 'AddressBarangay', 'label' => 'Barangay', 'rules' => 'trim|required|xss_clean'),
        'AddressCity' => array('field' => 'AddressCity', 'label' => 'City', 'rules' => 'trim|required|xss_clean'),
        'Gender' => array('field' => 'Gender', 'label' => 'Gender', 'rules' => 'trim|required|xss_clean'),
        'BirthDay' => array('field' => 'BirthDay', 'label' => 'Birthday', 'rules' => 'trim|required|xss_clean'),
    );

  
  function __construct()
  {
    parent::__construct();

  }
         
  
  function get_new()
  {
    $student = new stdClass();

    $student->Lname = "";
    $student->Fname = "";
    $student->Mname = "";
    $student->AddressStreet = "";
    $student->AddressBarangay = "";
    $student->AddressCity = "";
    $student->Gender = "";
    $student->BirthDay = "";
 
    return $student;
  }    



}
/*Location: ./application/models/MY_Model.php*/

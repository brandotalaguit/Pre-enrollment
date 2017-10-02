<?php
class M_Guidance_Student extends MY_Model
{
  
  protected $primary_key = "studno";
  
  protected $order_by = "lname,fname";

  protected $soft_delete = FALSE;
  
  protected $protected_attribute = array();

  public $rules = array(
        'lname' => array('field' => 'lname', 'label' => 'Lastname', 'rules' => 'trim|required|xss_clean'),
        'fname' => array('field' => 'fname', 'label' => 'Firstname', 'rules' => 'trim|required|xss_clean'),
        'mname' => array('field' => 'mname', 'label' => 'Middlename', 'rules' => 'trim|required|xss_clean'),
        'addStreet' => array('field' => 'addStreet', 'label' => 'Street', 'rules' => 'trim|required|xss_clean'),
        'addBarangay' => array('field' => 'addBarangay', 'label' => 'Barangay', 'rules' => 'trim|required|xss_clean'),
        'addCity' => array('field' => 'addCity', 'label' => 'City', 'rules' => 'trim|required|xss_clean'),
        'prov_address' => array('field' => 'prov_address', 'label' => 'Provincial Address', 'rules' => 'trim|xss_clean'),
        'religion' => array('field' => 'religion', 'label' => 'Religion', 'rules' => 'trim|required|xss_clean'),
        'nickname' => array('field' => 'nickname', 'label' => 'Nickname', 'rules' => 'trim|required|xss_clean'),
        'nationality' => array('field' => 'nationality', 'label' => 'Nationality', 'rules' => 'trim|required|xss_clean'),
        'bday' => array('field' => 'bday', 'label' => 'Birthday', 'rules' => 'trim|required|xss_clean'),
        'bplace' => array('field' => 'bplace', 'label' => 'Birth Place', 'rules' => 'trim|required|xss_clean'),
        'age' => array('field' => 'age', 'label' => 'Age', 'rules' => 'trim|required|xss_clean'),
        'civil_status' => array('field' => 'civil_status', 'label' => 'Civil Status', 'rules' => 'trim|required|xss_clean'),
        'sex' => array('field' => 'sex', 'label' => 'Gender', 'rules' => 'trim|required|xss_clean'),
        'dialect' => array('field' => 'dialect', 'label' => 'Dialect', 'rules' => 'trim|required|xss_clean'),
        'hobbies' => array('field' => 'hobbies', 'label' => 'Hobbies', 'rules' => 'trim|required|xss_clean'),
        'talents' => array('field' => 'talents', 'label' => 'Talents', 'rules' => 'trim|required|xss_clean'),
        'fathername' => array('field' => 'fathername', 'label' => 'Father Name', 'rules' => 'trim|required|xss_clean'),
        'fatherage' => array('field' => 'fatherage', 'label' => 'Father Age', 'rules' => 'trim|required|xss_clean'),
        'fathernationality' => array('field' => 'fathernationality', 'label' => 'Father Nationality', 'rules' => 'trim|required|xss_clean'),
        'isfatherliving' => array('field' => 'isfatherliving', 'label' => 'Father Living', 'rules' => 'trim|required|xss_clean'),
        'fatheroccupation' => array('field' => 'fatheroccupation', 'label' => 'Father Occupation', 'rules' => 'trim|required|xss_clean'),
        'faherteducattain' => array('field' => 'faherteducattain', 'label' => 'Father Education', 'rules' => 'trim|required|xss_clean'),
        'mothername' => array('field' => 'mothername', 'label' => 'Mother Name', 'rules' => 'trim|required|xss_clean'),
        'motherage' => array('field' => 'motherage', 'label' => 'Mother Age', 'rules' => 'trim|required|xss_clean'),
        'mothernationality' => array('field' => 'mothernationality', 'label' => 'Mother Nationality', 'rules' => 'trim|required|xss_clean'),
        'motheroccupation' => array('field' => 'motheroccupation', 'label' => 'Mother Occupation', 'rules' => 'trim|required|xss_clean'),
        'mothereducattain' => array('field' => 'mothereducattain', 'label' => 'Mother Education', 'rules' => 'trim|required|xss_clean'),
        'ismotherliving' => array('field' => 'ismotherliving', 'label' => 'Mother Living', 'rules' => 'trim|required|xss_clean'),
    );

  public $table_name = "";
  function __construct()
  {
    if(ENVIRONMENT == 'production')  
     $this->table_name = "umakunil_guidance.tblstudentinfo";
    else
     $this->table_name = "umaktest_guidance.tblstudentinfo";
    parent::__construct();
  }
         
  
  function get_new()
  {
    $student = new stdClass();

    $student->lname = "";
    $student->fname = "";
    $student->mname = "";
    $student->addstreet = "";
    $student->addBarangay = "";
    $student->addCity = "";
    $student->prov_address = "";
    $student->religion = "";
    $student->nickname = "";
    $student->nationality = "";
    $student->bday = "";
    $student->bplace = "";
    $student->age = "";
    $student->civil_status = "";
    $student->contact_no = "";
    $student->sex = "";
    $student->dialect = "";
    $student->hobbies = "";
    $student->talent = "";
    $student->spouse_name = "";
    $student->marriagedate = "";
    $student->marriageplace = "";
    $student->spouse_occupation = "";
    $student->spouse_empname = "";
    $student->spouse_bday = "";
    $student->spouse_contact = "";
    $student->fathername = "";
    $student->fatherage = "";
    $student->fathernationality = "";
    $student->isfatherliving = "";
    $student->fatheroccupation = "";
    $student->fathereducattain = "";
    $student->mothername = "";
    $student->motherage = "";
    $student->mothernationality = "";
    $student->ismotherliving = "";
    $student->motheroccupation = "";
    $student->mothereducattain = "";
    $student->parent_status = "";
    $student->parent_income = "";
    $student->house = "";
    $student->livingwith = "";
    $student->place = "";
    $student->sibling = "";
    $student->no_sibling = "";
    $student->birth_rank = "";
    $student->educ_support = "";
    $student->non_acad_award = "";
    $student->subjlike = "";
    $student->subdislike = "";
    $student->org_membership = "";
    $student->electivechoice = "";
    $student->influence_by = "";
    $student->personal_choice = "";
    $student->yr_level = "";
    $student->college_level = "";
    return $student;
  }    



}
/*Location: ./application/models/MY_Model.php*/

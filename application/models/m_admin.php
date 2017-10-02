<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_user_info($username)
    {
        $this->db->where('Username',$username);
        $query = $this->db->get('tbladminaccount');
        $row = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
        }
        $this->db->close();
        return $row;
    }

    function update_logged_in($username)
    {
        $this->load->helper('date');
        $timestamp = now();
        $timezone = 'UP8';
        $last_logged = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone)); 
        $data = array('LastLoggedIn' => $last_logged, 'IsLoggedIn' => '1');
        $this->db->where('Username',$username);
        $this->db->update('tbladminaccount',$data);
    }


    function update_logged_out($username)
    {
        $data = array('IsLoggedIn' => '0');
        $this->db->where('Username',$username);
        $this->db->update('tbladminaccount',$data);
    }


}
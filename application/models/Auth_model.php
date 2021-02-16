<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function tambahDataUser()
    {
        $query = "INSERT INTO master.vuser 
                  (vuser, passwd, full_name, passwd_auth,  email)
                  VALUES
                  (" . $this->db->escape($_POST['username']) . "," .
            $this->db->escape(strtoupper(md5($_POST['password']))) . "," .
            $this->db->escape($_POST['fullname']) . "," .
            $this->db->escape(strtoupper(md5($_POST['password']))) . "," .
            $this->db->escape($_POST['email']) . ")";


        $this->db->query($query);


        return $this->db->affected_rows();;
    }
}

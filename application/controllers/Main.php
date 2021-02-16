<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
    }


    public function index()
    {

        $role_id = $this->session->userdata('role');

        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();

        $data['curlx'] = $this->uri->segment(1);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(1)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('main/index', $data);
        $this->load->view('templates/footer');
    }
}

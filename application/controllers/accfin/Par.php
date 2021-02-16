<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Par extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Par_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        //$data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('finance/v_par', $data);
        $this->load->view('templates/footer');
    }


    public function getPar()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Par_model->getPar();
        echo json_encode($data);
    }
}

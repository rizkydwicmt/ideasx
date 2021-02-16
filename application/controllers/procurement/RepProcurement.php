<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RepProcurement extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('RepProcurement_model');
        $this->load->model('DataMaster_model');
    }

    public function aplist()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(3);

        // var_dump($data['curlx']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(3)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('procurement/v_aplist', $data);
        $this->load->view('templates/footer');
    }


    public function getApList()
    {

        $this->output->set_content_type('application/json');
        $data = $this->RepProcurement_model->getAp();
        echo json_encode($data);
    }

    public function getApListDetail()
    {
        $idr = $this->input->post("idd", true);
        $this->output->set_content_type('application/json');
        $data = $this->RepProcurement_model->getApListDetail($idr);
        echo json_encode($data);
    }
}

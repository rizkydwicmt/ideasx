<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Balance_model');
        //$this->load->model('DataMaster_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        if ($role_id == 'admin') {

            $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        } elseif ($role_id == 'user') {
            $data['user'] = $this->db->get_where('master.vuser', ['vuser' => $this->session->userdata('username')])->row_array();
        }

        $data['curlx'] = $this->uri->segment(4);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        //$data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];

        // var_dump($data['curlx']);
        // die;


        // $this->load->view('templates/header', $data);
        // $this->load->view('templates/topbar', $data);
        // $this->load->view('templates/sidebar', $data);
        if ($data['curlx'] == 'Breport') {
            $this->load->view('accounting/v_nsaldo_full', $data);
        } elseif ($data['curlx'] == 'Bbesar') {
            $data['coa'] = $this->Nsaldo_model->getCoa();
            $this->load->view('accounting/v_plost', $data);
        }
        $this->load->view('templates/footer');
    }


    public function getCoa()
    {
        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getCoa();
        echo json_encode($data);
    }


    public function getNsaldo()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Nsaldo_model->getNsaldo();
        echo json_encode($data);
    }

    public function getMBukuBesar($f)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Nsaldo_model->getMBukuBesar($f);
        echo json_encode($data);
    }

    public function getDBukuBesar($d)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Nsaldo_model->getDBukuBesar($d);
        echo json_encode($data);
    }

    public function getJkontrol()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Nsaldo_model->getJkontrol();
        echo json_encode($data);
    }
}

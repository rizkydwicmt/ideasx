<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posting extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Posting_model');
        $this->load->model('DataMaster_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {
        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(4);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];

        // var_dump($data['curlx']);
        // die;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        if ($data['curlx'] == 'Sales') {
            $this->load->view('admin/v_post_sales', $data);
        } elseif ($data['curlx'] == 'Accfin') {
            $this->load->view('admin/v_post_accfin', $data);
        } elseif ($data['curlx'] == 'Procurement') {
            $this->load->view('admin/v_post_procurement', $data);
        }

        $this->load->view('templates/footer');
    }


    public function getSettlement($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getSettlement($idx);
        echo json_encode($data);
    }



    public function postSettlement($p)
    {
        $input = $this->Posting_model->postSettlement($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function getPayment($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getPayment($idx);
        echo json_encode($data);
    }



    public function postPayment($p)
    {
        $input = $this->Posting_model->postPayment($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function getMemorial($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getMemorial($idx);
        echo json_encode($data);
    }



    public function postMemorial($p)
    {
        $input = $this->Posting_model->postMemorial($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function getAr($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getAr($idx);
        echo json_encode($data);
    }



    public function postAr($p)
    {
        $input = $this->Posting_model->postAr($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function getPr($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getPr($idx);
        echo json_encode($data);
    }



    public function postPr($p)
    {
        $input = $this->Posting_model->postPr($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function getPo($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getPo($idx);
        echo json_encode($data);
    }



    public function postPo($p)
    {
        $input = $this->Posting_model->postPo($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function getAp($idx)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Posting_model->getAp($idx);
        echo json_encode($data);
    }



    public function postAp($p)
    {
        $input = $this->Posting_model->postAp($p);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }
}

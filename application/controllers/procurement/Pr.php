<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        // $this->load->library('encrypt');
        $this->load->model('Pr_model');
        $this->load->model('DataMaster_model');
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        $data['curlx'] = $this->uri->segment(2);


        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];;

        $ds = $this->session->userdata('pr');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('pr');
        } else {
            $data['dtnow'] = "today";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('procurement/v_pr', $data);
        $this->load->view('templates/footer');
    }


    public function getPr()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Pr_model->getPr();
        echo json_encode($data);
    }


    public function getPrMaster()
    {
        $idx = $this->input->post("idx", true);

        $data = $this->Pr_model->getPrMaster($idx);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getPrDetail()
    {
        $idj = $this->input->post("idx", true);
        $data = $this->Pr_model->getPrDetail($idj);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function fetchPrDetail($idp)
    {

        $data = $this->Pr_model->fetchPrDetail($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function fetchItem($idccproject)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Pr_model->getItem($idccproject);

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function fetchDeliveryPlace()
    {

        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getDeliveryPlace();
        echo json_encode($data);
    }

    public function loadPr()
    {
        $datax = $this->session->userdata('pr');

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Purchase Requisition [PR]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Purchase Requisition [PR]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('procurement/i_pr', $data);
    }


    public function newPr()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('pr', $data);
            echo json_encode(['success' => true]);
            //redirect(base_url() . 'procurement/Pr/loadPr/' . $data);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editPr()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('pr', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function insertPr()
    {
        $input = $this->Pr_model->savePr();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function updatePr($id)
    {

        $input = $this->Pr_model->editPr($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyPr()
    {
        $id = $this->input->post("id", true);
        $input = $this->Pr_model->deletePr($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    //$data['project'] = $this->DataMaster_model->getProject();

    public function getCCProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Pr_model->getCCProject();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Pr_model->getUnit();
        echo json_encode($vdata);
    }

    public function getRekanan()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Pr_model->getRekanan();
        echo json_encode($vdata);
    }
}

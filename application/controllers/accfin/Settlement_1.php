<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settlement extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Settlement_model');
        $this->load->model('DataMaster_model');
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
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];

        $data['vendor'] = $this->Settlement_model->getSupplier();
        $data['coa'] = $this->Settlement_model->getCoa();

        $data['Currency'] = $this->DataMaster_model->getCurrency();
        $data['project'] = $this->DataMaster_model->getCcproject();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);

        if (($data['notrans']) == '406') {
            $this->load->view('finance/v_settlement', $data);
        } elseif (($data['notrans']) == '407') {
            $this->load->view('finance/v_reimbursement', $data);
        }

        $this->load->view('templates/footer');
    }


    public function getSettlement($no_trans)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->getSettlement($no_trans);
        echo json_encode($data);
    }

    public function getSettlementDetail()
    {
        $idj = $this->input->post("idd", true);

        $data = $this->Settlement_model->getSettlementDetail($idj);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getDetailSettlement($idp)
    {

        $data = $this->Settlement_model->getDetailSettlement($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function fetchCaNumber($id)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->fetchCaNumber($id);
        echo json_encode($data);
    }



    public function fetchCoaNumber($idcp)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->getCoaNumberEasyui($idcp);
        echo json_encode($data);
    }

    public function fetchItem()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->getItem();
        echo json_encode($data);
    }


    public function insertSettlement($no_trans)
    {

        $input = $this->Settlement_model->saveSettlement($no_trans);

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateSettlement($id)
    {
        $input = $this->Settlement_model->editSettlement($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroySettlement()
    {
        $id = $this->input->post("id", true);
        $input = $this->Settlement_model->deleteSettlement($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

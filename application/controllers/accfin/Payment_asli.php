<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Payment_model');
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

        $data['vendor'] = $this->Payment_model->getRekanan();

        $data['Currency'] = $this->DataMaster_model->getCurrency();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);

        if (($data['notrans']) == '401') {
            $data['coa_m'] = $this->DataMaster_model->getKasBankAcc('KAS');
            $this->load->view('finance/v_cd', $data);
        } elseif (($data['notrans']) == '402') {
            $data['coa_m'] = $this->DataMaster_model->getKasBankAcc('KAS');
            $this->load->view('finance/v_cr', $data);
        } elseif (($data['notrans']) == '403') {
            $data['coa_m'] = $this->DataMaster_model->getKasBankAcc('BANK');
            $this->load->view('finance/v_bd', $data);
        } elseif (($data['notrans']) == '404') {
            $data['coa_m'] = $this->DataMaster_model->getKasBankAcc('BANK');
            $this->load->view('finance/v_br', $data);
        }

        $this->load->view('templates/footer');
    }


    public function getPayment($no_trans)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getPayment($no_trans);
        echo json_encode($data);
    }

    public function getPaymentDetail()
    {
        $idp = $this->input->post("idd", true);
        $data = $this->Payment_model->getPaymentDetail($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getDetailPayment($idp)
    {

        $data = $this->Payment_model->getDetailPayment($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }



    public function fetchCoaNumber()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getCoaNumber();
        echo json_encode($data);
    }

    public function fetchCcproData()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getCcproData();
        echo json_encode($data);
    }

    public function fetchItem($kdr)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getNoReff($kdr);
        echo json_encode($data);
    }


    public function insertPayment($no_trans)
    {

        $input = $this->Payment_model->savePayment($no_trans);

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function updatePayment($id)
    {
        $input = $this->Payment_model->editPayment($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyPayment()
    {
        $id = $this->input->post("id", true);
        $input = $this->Payment_model->deletePayment($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

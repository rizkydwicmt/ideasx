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

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $xurl = $this->uri->segment(4);
        // var_dump(strtolower($xurl));
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $xurl])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];
        $data['curlx'] = $xurl;


        $ds = $this->session->userdata(strtolower($xurl));
        // var_dump($ds);
        // die;
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata(strtolower($xurl));
        } else {
            $data['dtnow'] = "today";
        }


        $data['vendor'] = $this->Payment_model->getRekanan();
        $data['Currency'] = $this->DataMaster_model->getCurrency();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);

        if ((strtoupper($xurl)) == 'CD') {
            $this->load->view('finance/v_cd', $data);
        } elseif ((strtoupper($xurl)) == 'CR') {
            $this->load->view('finance/v_cr', $data);
        } elseif ((strtoupper($xurl)) == 'BD') {
            $this->load->view('finance/v_bd', $data);
        } elseif ((strtoupper($xurl)) == 'BR') {
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


    public function getDataMaster()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT 
                a.id_payment, 
                a.no_payment, 
                to_char(a.dt_payment,'dd-mm-yyyy') as dt_payment,
                a.id_cc_project,
                a.kd_rekanan,
                a.nominal,
                a.id_curr,
                a.kurs,
                a.id_rek_gl,
                a.remarks,
                a.an,
                a.bank,
                a.no_cek_bg_tt,
                a.jns_ttbg
            from accfin.payment a
            WHERE a.id_payment = " . $idx . ";";

        $xQuot = $this->db->query($q)->result_array();
        // var_dump($xQuot);
        // die;
        if ($xQuot) {
            echo json_encode($xQuot);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getDataDetail()
    {
        $idp = $this->input->post("idx", true);
        $data = $this->Payment_model->getPaymentDetail($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }





    public function loadPayment($x)
    {
        // var_dump($x);
        // die;
        $this->load->view('templates/i_topbar');
        if ($x == 'cd') {
            $this->load->view('finance/i_cd');
        } elseif ($x == 'cr') {
            $this->load->view('finance/i_cr');
        } elseif ($x == 'bd') {
            $this->load->view('finance/i_bd');
        } elseif ($x == 'br') {
            $this->load->view('finance/i_br');
        }
    }

    public function newPayment()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['caption'] = 'New ' . $this->input->post("vcap", true);
        $data['idTrans'] = $this->input->post("idTrans", true);
        $data['mode'] = 'add';
        $data['idx'] = '0';
        $data['urlx'] = $this->input->post("urlx", true);


        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata(strtolower($data['urlx']), $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editPayment()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['caption'] = 'Edit ' . $this->input->post("vcap", true);
        $data['idTrans'] = $this->input->post("idTrans", true);
        $data['mode'] = 'edit';
        $data['idx'] = $this->input->post("id", true);
        $data['urlx'] = $this->input->post("urlx", true);


        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata(strtolower($data['urlx']), $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertPayment()
    {

        $input = $this->Payment_model->savePayment();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function updatePayment()
    {
        $input = $this->Payment_model->editPayment();
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

    public function getRekanan()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getRekanan();
        echo json_encode($data);
    }

    public function getCoaMaster($r)
    {

        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getKasBankAcc($r);
        echo json_encode($data);
    }



    public function getCoaDetail()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getCoaDetail();
        echo json_encode($data);
    }

    public function getCcProject()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getCcproData();
        echo json_encode($data);
    }

    public function getNoReff($kdr)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Payment_model->getNoReff($kdr);
        echo json_encode($data);
    }
}

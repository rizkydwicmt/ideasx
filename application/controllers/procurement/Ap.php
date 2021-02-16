<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ap extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Ap_model');
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
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] =  $noTrans['menu_name'];

        // var_dump($data['curlx']);
        // die;


        $data['vendor'] = $this->DataMaster_model->getSupplier();
        $data['Currency'] = $this->DataMaster_model->getCurrency();
        $data['ccpro'] = $this->DataMaster_model->getCcproject();
        $data['coa_ap'] = $this->Ap_model->getCoa_ap('ap');
        $data['coa_vat'] = $this->Ap_model->getCoa_ap('vat');
        $data['coa_wht'] = $this->Ap_model->getCoa_ap('wht');
        $data['coa_dp'] = $this->Ap_model->getCoa_ap('dp');
        $data['coa_debet'] = $this->Ap_model->getCoa_ap('debet');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        if (($data['notrans']) == '120') {
            $this->load->view('procurement/v_ap', $data);
        } elseif (($data['notrans']) == '121') {
            $this->load->view('procurement/v_apnpo', $data);
        }
        $this->load->view('templates/footer');
    }


    public function getAp($id_trans)
    {

        $this->output->set_content_type('application/json');
        $data = $this->Ap_model->getAp($id_trans);
        echo json_encode($data);
    }


    public function insertAp()
    {
        $input = $this->Ap_model->saveAp();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateAp($id)
    {
        $input = $this->Ap_model->editAp($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyAp()
    {
        $id = $this->input->post("id", true);
        $input = $this->Ap_model->deleteAp($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getPoData()
    {
        $idj = $this->input->post("idd", true);

        $data = $this->Ap_model->getPoData($idj);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getApDetail()
    {
        $idj = $this->input->post("idd", true);

        $data = $this->Ap_model->getApDetail($idj);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function fetchApDetail($idp)
    {

        $data = $this->Ap_model->fetchApDetail($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function fetchItem()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Ap_model->getItem();
        echo json_encode($data);
    }
}

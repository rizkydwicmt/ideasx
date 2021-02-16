<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Po_model');
        $this->load->model('DataMaster_model');
        $this->load->helper('url');
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

        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];;
        // $data['j_po'] = $jpo;

        // $data['vendor'] = $this->DataMaster_model->getSupplier();
        // $data['Currency'] = $this->DataMaster_model->getCurrency();
        // $data['coa'] = $this->DataMaster_model->getCoa();
        // $data['project'] = $this->DataMaster_model->getProject();
        // $data['payment'] = $this->DataMaster_model->getPaymentTerm();
        // $data['delivery_terms'] = $this->DataMaster_model->getDeliveryTerm();
        // $data['vuser'] = $this->DataMaster_model->getVuser();


        $ds = $this->session->userdata('po');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('po');
        } else {
            $data['dtnow'] = "today";
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('procurement/v_po', $data);
        //$this->load->view('procurement/v_po_asli', $data);
        $this->load->view('templates/footer');
    }





    public function getPo()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Po_model->getPo();
        echo json_encode($data);
    }

    public function getPoMaster()
    {
        $idx = $this->input->post("idx", true);
        $data = $this->Po_model->getPoMaster($idx);
        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getPoDetail()
    {
        $idj = $this->input->post("idx", true);

        $data = $this->Po_model->getPoDetail($idj);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function fetchPoDetail($idp)
    {

        $data = $this->Po_model->fetchPoDetail($idp);

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }



    public function loadPo()
    {
        //var_dump($dtx);

        //$datax = $this->input->post("data", true);
        $datax = $this->session->userdata('po');
        // var_dump($datax['m']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Purchase Order [PO]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Purchase Order [PO]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('procurement/i_po', $data);
    }


    public function newPo()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('po', $data);
            echo json_encode(['success' => true]);
            //redirect(base_url() . 'procurement/Pr/loadPr/' . $data);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editPo()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('po', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function insertPo()
    {

        $input = $this->Po_model->savePo();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updatePo()
    {
        $input = $this->Po_model->editPo();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyPo()
    {
        $id = $this->input->post("id", true);
        $input = $this->Po_model->deletePo($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function cetakPo($id)
    {
        $data['mpo'] = $this->Po_model->getMPOCetak($id);
        $data['dpo'] = $this->Po_model->getDPOCetak($id);
        $data['p'] = $this->DataMaster_model->getPerusahaan();
        $this->load->view('procurement/r_po', $data);
    }


    public function getItem($idcp)
    {
        // var_dump($idcp);
        // die;

        $this->output->set_content_type('application/json');
        $data = $this->Po_model->getItem($idcp);
        echo json_encode($data);
    }

    public function fetchDeliveryPlace()
    {

        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getDeliveryPlace();
        echo json_encode($data);
    }


    public function getCCProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Po_model->getCCProject();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Po_model->getUnit();
        echo json_encode($vdata);
    }

    public function getSupplier()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getSupplier();
        echo json_encode($vdata);
    }


    public function getPaymentTerm()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getPaymentTerm();
        echo json_encode($vdata);
    }
    //data['vuser'] = $this->DataMaster_model->getVuser();

    public function getVuser()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getVuser();
        echo json_encode($vdata);
    }
}

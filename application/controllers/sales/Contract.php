<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Contract extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };


        $this->load->model('Contract_model');
        $this->load->model('DataMaster_model');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->helper('tegar_num');
    }

    public function index()
    {

        // if ($role_id == 'admin') {
        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];

        $ds = $this->session->userdata('con');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('con');
        } else {
            $data['dtnow'] = "today";
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sales/v_contract', $data);
        $this->load->view('templates/footer');
    }


    public function getContract()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Contract_model->getContract();
        echo json_encode($data);
    }


    public function getContractDetail($idx)
    {
        $data = $this->Contract_model->getContractDetail($idx);
        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getMasterData()
    {
        $idx = $this->input->post("id", true);

        $q = "SELECT
                id_so, 
                so_number, 
                no_qt,
                to_char(dt_so,'dd-mm-yyyy') as dt_so,
                to_char(dt_finish,'dd-mm-yyyy') as dt_finish,
                kd_rekanan,
                cust_po_number,
                id_cc_project,
                sub_total,
                vat_num,
                total,
                sub_total_hpp,
                vat_num_hpp,
                total_hpp,
                vat_str,
                cara_bayar,
                category as id_cat_project,
                remarks,
                id_rek_gl,
                manager,
                lokasi
            from sales.so
            WHERE id_so = " . $idx . ";";

        $xQry = $this->db->query($q)->result_array();

        // var_dump($idx);
        // die;

        if ($xQry) {
            echo json_encode($xQry);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDetailData()
    {
        $idx = $this->input->post("id", true);


        $query = "SELECT a.id_so,
                         a.id_so_detail,
                         a.kd_pi,
                         a.kd_item,
                         a.descriptions,
                         a.kd_satuan,
                         a.qty,
                         a.unit_price,
                         a.sub_total,
                         a.hpp_price,
                         a.hpp_sub_total,
                         a.margin_psn
                    FROM sales.so_detail a
                    WHERE a.id_so= " . $idx . "";


        $data = $this->db->query($query)->result_array();

        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getContractRemarks($idd)
    {
        $data = $this->Contract_model->getQRemarks($idd);
        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function loadContract()
    {
        //var_dump($dtx);

        //$datax = $this->input->post("data", true);
        $datax = $this->session->userdata('con');
        // var_dump($datax['m']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Contract Assignment';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Contract Assignment';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('sales/i_contract', $data);
    }


    public function newContract()
    {;
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('con', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editContract()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';

        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('con', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function crevContract($datax)
    {
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];

        $i = strrpos($datax, 'x');
        $dtx = substr($datax, $i + 1);
        $idx = substr($datax, 0, $i);
        $data['dtx'] = $dtx;
        $data['idx'] = $idx;

        $data['mode'] =  'rev';
        $data['caption'] = 'Revision Contract';

        $this->load->view('sales/i_contract', $data);
    }

    public function insertContract()
    {
        $input = $this->Contract_model->saveContract();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function updateContract()
    {
        $input = $this->Contract_model->editContract();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function destroyContract()
    {
        $id = $this->input->post("id", true);
        $input = $this->Contract_model->deleteContract($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function cetakContract($id)
    {


        $data['m'] = $this->Contract_model->getMCetak($id);
        $data['d'] = $this->Contract_model->getDCetak($id);
        $data['r'] = $this->Contract_model->getRCetak($id);
        $data['p'] = $this->DataMaster_model->getPerusahaan();

        $this->load->view('sales/r_quot', $data);
    }


    //look data
    public function getItem()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getItem();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getUnit();
        echo json_encode($vdata);
    }

    public function getProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getProject();
        echo json_encode($vdata);
    }


    public function getQuotation()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getQuotation();
        echo json_encode($vdata);
    }

    public function getCustomer()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getCustomer();
        echo json_encode($vdata);
    }


    public function getManager()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getManager();
        echo json_encode($vdata);
    }



    public function getResumeValue()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getResumeValue();
        if ($vdata) {
            echo json_encode($vdata);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function  getDetailQuotsheet()
    {

        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getDetailQuotsheet();
        if ($vdata) {
            echo json_encode($vdata);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function  getCatProject()
    {

        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getCatProject();
        if ($vdata) {
            echo json_encode($vdata);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function  getProfitCenter()
    {

        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getProfitCenter();
        if ($vdata) {
            echo json_encode($vdata);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function  getDQuotation()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Contract_model->getDQuotation();
        if ($vdata) {
            echo json_encode($vdata);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    //------------------------------IMPORT contract pdf ----------------------------------------

    public function uploadContract($filename)
    {
        $data = array(); // Buat variabel $data sebagai array
        //$data['sheet'] = [];

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php

            $upload = $this->Contract_model->upload_file($filename);
            // var_dump($this->filename);
            // die;

            if ($upload['result'] == "success") {
                echo json_encode(array('success' => true));
            } else { // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }

        // $upload = array();

        // if ($upload) {
        //     echo json_encode($resultx);
        // } else {
        //     echo json_encode(array('errorMsg' => 'Some errors occured.'));
        // }
    }

    /// ---------------------------- end of pdf-----------------------------------





} ///0-0-0000

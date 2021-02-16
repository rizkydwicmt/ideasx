<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Ar_model');
        $this->load->model('DataMaster_model');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->helper('tegar_num');
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
        $data['tittle'] = $noTrans['menu_name'];


        $ds = $this->session->userdata('ar');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('qse');
        } else {
            $data['dtnow'] = "today";
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sales/v_ar', $data);
        $this->load->view('templates/footer');
    }


    public function getAr()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Ar_model->getAr();
        echo json_encode($data);
    }


    public function getArDetail($idx)
    {
        $data = $this->Ar_model->getArDetail($idx);
        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);


        $q = "SELECT 
                a.id_sales_invoice, 
                a.no_sales_invoice, 
                to_char(a.dt_sales_invoice,'dd-mm-yyyy') as dt_sales_invoice,
                a.kd_rekanan,
                a.no_kontrak,
                to_char(a.dt_contract,'dd-mm-yyyy') as dt_contract,
                a.cust_po_number,
                a.no_berita_acara,
                to_char(a.dt_berita_acara,'dd-mm-yyyy') as dt_berita_acara,
                to_char(a.due_date,'dd-mm-yyyy') as due_date,
                a.no_acc,
                a.bank_transfer,
                a.vat_str,
                a.sub_total,
                a.disc,
                a.dpp,
                a.pph_psn,
                a.pph_rp,
                a.vat_num,
                a.total,
                a.dp_termin,
                a.remarks,
                a.id_rek_gl,
                a.id_cc_project,
                p.nilai as nilai_kontrak
            FROM sales.sales_invoice a
            LEFT JOIN master.mcc_project p ON p.id_cc_project=a.id_cc_project
            WHERE a.id_sales_invoice = " . $idx . ";";

        $xQuot = $this->db->query($q)->result_array();
        if ($xQuot) {
            echo json_encode($xQuot);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getDetailData()
    {
        $idx = $this->input->post("idx", true);

        $query = "SELECT    a.id_sales_invoice, 
                            a.id_sales_invoice_detail, 
                            a.id_rek_gl, 
                            a.remarks,
                            a.id_unit as kd_satuan,
                            a.qty::numeric(9,2) as qty,
                            a.qty_unit,
                            a.unit_price,
                            (((a.qty/100)*a.unit_price)+(a.qty_unit*a.unit_price))::numeric(17,2) as sub_total
                    FROM sales.sales_invoice_detail a
                    WHERE a.id_sales_invoice=" . $idx . "
                    ORDER BY a.id_sales_invoice_detail ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        $this->output->set_content_type('application/json');
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }




    public function loadAr()
    {
        $datax = $this->session->userdata('ar');
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];
        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Sales Invoice';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Sales Invoice';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('sales/i_ar', $data);
    }


    public function newAr()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('ar', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editAr()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('ar', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertAr()
    {

        $input = $this->Ar_model->saveAr();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateAr()
    {
        $input = $this->Ar_model->editAr();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyAr()
    {
        $id = $this->input->post("id", true);
        $input = $this->Ar_model->deleteAr($id);
        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getBankacc()
    {
        $idx = $this->input->post("idx", true);
        $query = "select descriptions
                    from master.cash_bank_acc
                    where no_acc='" . $idx . "';";
        $result = $this->db->query($query)->row_array();
        $data = $result['descriptions'];
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getProject()
    {
        $query = "select a.*,
                    to_char(a.dt_order,'dd-mm-yyyy')::varchar(30) as dt_order_char
                    from master.mcc_project a
                    WHERE a.isproject='1' AND a.isactive='1'";
        $data = array();
        $data = $this->db->query($query)->result_array();
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getCustomer()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getCustomer();
        echo json_encode($vdata);
    }


    public function getCoaMaster()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getCoaMaster();
        echo json_encode($vdata);
    }


    public function getCoaDetail()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getCoaDetail();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getUnit();
        echo json_encode($vdata);
    }

    public function getItem($idx)
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getItem($idx);
        echo json_encode($vdata);
    }


    public function getBank()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ar_model->getAccBank();
        echo json_encode($vdata);
    }

    public function cetakAr($datax)
    {

        list($ce, $id) = explode('-', $datax);
        $data['m'] = $this->Ar_model->getMARCetak($id);
        $data['d'] = $this->Ar_model->getDARCetak($id);
        $data['p'] = $this->DataMaster_model->getPerusahaan();

        if ($ce == 'S') {
            $this->load->view('sales/r_surat', $data);
        } elseif ($ce == 'I') {
            $this->load->view('sales/r_invoice', $data);
        } elseif ($ce == 'K') {
            $this->load->view('sales/r_kwitansi', $data);
        }
    }
}

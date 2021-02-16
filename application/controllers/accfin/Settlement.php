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

        // if ($role_id == 'admin') {
        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);


        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];

        $ds = $this->session->userdata('stl');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('stl');
        } else {
            $data['dtnow'] = "today";
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('finance/v_settlement', $data);
        $this->load->view('templates/footer');
    }


    public function getSettlement($idtrans)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->getSettlement($idtrans);
        echo json_encode($data);
    }

    public function getSettlementDetail($idj)
    {

        $data = $this->Settlement_model->getDetailSettlement($idj);

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
                a.id_settlement, 
                a.no_settlement, 
                to_char(a.dt_settlement,'dd-mm-yyyy') as dt_settlement,
                a.id_cc_project,
                a.kd_rekanan,
                a.no_kasbon,                                                                                                                                                        
                to_char(a.dt_kasbon,'dd-mm-yyyy') as dt_kasbon,
                a.kegiatan_1,
                a.total,
                a.total_kasbon,
                a.lebih_kurang,
                a.id_curr,
                a.kurs,
                a.id_rek_gl,
                a.remarks
            from accfin.settlement a
            WHERE a.id_settlement = " . $idx . ";";

        $xQuot = $this->db->query($q)->result_array();
        // var_dump($xQuot);
        // die;
        if ($xQuot) {
            echo json_encode($xQuot);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDetailData()
    {

        $idx = $this->input->post("idx", true);

        $query = "SELECT    a.id_settlement, 
                            a.id_settlement_detail,
                            to_char(a.dt_biaya,'dd-Mon-yyyy') as dt_biaya,
                            a.diskripsi, 
                            a.biaya,
                            a.id_rek_gl,
                            a.kd_item,
                            a.no_mrir
                    FROM accfin.settlement_detail a
                    WHERE a.id_settlement=" . $idx . "
                    ORDER BY a.id_settlement_detail ASC";


        $result = array();

        $result = $this->db->query($query)->result_array();

        $this->output->set_content_type('application/json');
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }




    public function loadSettlement()
    {
        //var_dump($dtx);

        //$datax = $this->input->post("data", true);
        $datax = $this->session->userdata('stl');
        // var_dump($datax['m']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Settlement';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Settlement';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('finance/i_settlement', $data);
    }





    public function newSettlement()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('stl', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editSettlement()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('stl', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertSettlement()
    {
        // var_dump('masuk');
        // die;
        $input = $this->Settlement_model->saveSettlement();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateSettlement()
    {
        // $id = $this->input->post("id", true);
        $input = $this->Settlement_model->editSettlement();
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


    public function getCCProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Settlement_model->getCCProject();
        echo json_encode($vdata);
    }

    public function getRekanan()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Settlement_model->getRekanan();
        echo json_encode($vdata);
    }


    public function getCurrency()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getCurrency();
        echo json_encode($vdata);
    }

    public function getCoa()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Settlement_model->getCoa();
        echo json_encode($vdata);
    }

    public function getCaAccount($id)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->fetchCaNumber($id);
        echo json_encode($data);
    }

    public function getCoaDetail()
    {
        // var_dump($idcp);
        // die;

        $this->output->set_content_type('application/json');
        $data = $this->Settlement_model->getCoaDetail();
        echo json_encode($data);
    }
}

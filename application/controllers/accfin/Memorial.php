<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memorial extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Memorial_model');
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
        $data['tittle'] =  $noTrans['menu_name'];

        $ds = $this->session->userdata('mm');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('mm');
        } else {
            $data['dtnow'] = "today";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('accounting/v_memorial', $data);
        $this->load->view('templates/footer');
    }


    public function getMemorial()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Memorial_model->getMemorial();
        echo json_encode($data);
    }



    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT 
                a.id_jurnal, 
                a.no_jurnal, 
                to_char(a.dt_jurnal,'dd-mm-yyyy') as dt_jurnal,
                a.kd_rekanan,
                a.debet,
                a.kredit,
                a.remark
            from accfin.jurnal a
            WHERE a.id_jurnal = " . $idx . ";";

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
        $idd = $this->input->post("idx", true);

        $query = "SELECT    a.id_jurnal, 
                            a.id_jurnal_detail,
                            a.id_cc_project,  
                            a.description, 
                            a.debet,
                            a.kredit,
                            a.id_rek_gl,
                            a.no_reff
                    FROM accfin.jurnal_detail a
                    WHERE a.id_jurnal= $idd
                    ORDER BY a.id_jurnal_detail ASC";


        $data = $this->db->query($query)->result_array();

        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function loadMemorial()
    {

        $datax = $this->session->userdata('mm');

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Memorial';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Memorial';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('accounting/i_memorial', $data);
    }




    public function newMemorial()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('mm', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editMemorial()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('mm', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function insertMemorial()
    {
        $input = $this->Memorial_model->saveMemorial();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateMemorial()
    {
        $input = $this->Memorial_model->editMemorial();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyMemorial()
    {
        $id = $this->input->post("id", true);
        $input = $this->Memorial_model->deleteMemorial($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getMemorialDetail($idj)
    {
        $data = $this->Memorial_model->getMemorialDetail($idj);
        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getCCProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Memorial_model->getCCProject();
        echo json_encode($vdata);
    }

    public function getRekanan()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Memorial_model->getRekanan();
        echo json_encode($vdata);
    }

    public function getCoaDetail()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Memorial_model->getCoaDetail();
        echo json_encode($vdata);
    }
}

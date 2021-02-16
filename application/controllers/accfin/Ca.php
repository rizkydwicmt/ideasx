<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ca extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Ca_model');
        $this->load->model('DataMaster_model');
    }

    public function index()
    {

        // $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] =  $noTrans['menu_name'];


        $ds = $this->session->userdata('ca');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('ca');
        } else {
            $data['dtnow'] = "today";
        }



        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('finance/v_ca', $data);
        $this->load->view('templates/footer');
    }


    public function getCa()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Ca_model->getCa();
        echo json_encode($data);
    }



    public function getOustandCa()
    {
        $idx = $this->input->post("idx", true);

        $query = "select COALESCE(sum(jumlah),0)::numeric(17,2) as tunggakan
                    from accfin.vcek_kasbon
                    where kd_rekanan='" . $idx . "';";

        $result = $this->db->query($query)->row_array();
        $totca = $result['tunggakan'];

        if ($totca) {
            echo json_encode($totca);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT
                a.id_kasbon, 
                a.no_kasbon, 
                to_char(a.dt_purposed, 'DD-Mon-YYYY') as dt_purposed,
                to_char(a.dt_purposed, 'dd/mm/yyyy') as dt_purposed_char,
                a.kd_rekanan, 
                a.kasbon_untuk,
                a.id_cc_project,
                a.id_rek_gl_debet,
                a.remarks, 
                a.usr_ins,
                a.usr_upd,
                a.ispost, 
                a.iscancel, 
                a.jumlah,
                a.tunggakan
            from accfin.kasbon a
            WHERE a.id_kasbon = " . $idx . ";";

        $xQry = $this->db->query($q)->result_array();

        // var_dump($xQry);
        // die;

        if ($xQry) {
            echo json_encode($xQry);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function loadCa()
    {
        //var_dump($dtx);

        //$datax = $this->input->post("data", true);
        $datax = $this->session->userdata('ca');
        // var_dump($datax['m']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Cash Advance';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Cash Advance';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('finance/i_ca', $data);
    }


    public function newCa()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('ca', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editCa()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';

        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('ca', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function insertCa()
    {
        $input = $this->Ca_model->saveCa();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateCa()
    {
        $input = $this->Ca_model->editCa();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyCa()
    {
        $id = $this->input->post("id", true);
        $input = $this->Ca_model->deleteCa($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getRekanan()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Ca_model->getRekanan();
        echo json_encode($data);
    }

    public function getCCProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ca_model->getCCProject();
        echo json_encode($vdata);
    }

    public function getCoa()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Ca_model->getCoa();
        echo json_encode($vdata);
    }
}

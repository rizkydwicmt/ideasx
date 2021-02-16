<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('Project_model');
        $this->load->model('DataMaster_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $data['Coa'] = $this->DataMaster_model->getCoa();


        $ds = $this->session->userdata('pro');
        if ($ds) {
            $this->session->unset_userdata('pro');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/v_project', $data);
        $this->load->view('templates/footer');
    }


    public function getData()
    {
        $this->output->set_content_type('application/json');
        $data = $this->Project_model->getData();
        echo json_encode($data);
    }

    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT *, to_char(dt_announcement, 'dd-mm-yyyy') as dt_announcement_char,
                        to_char(dt_order, 'dd-mm-yyyy') as dt_order_char,
                        to_char(dt_start, 'dd-mm-yyyy') as dt_start_char,
                        to_char(dt_finish, 'dd-mm-yyyy') as dt_finish_char
            from master.mcc_project
            WHERE id_cc_project = '" . $idx . "';";


        $xQry = $this->db->query($q)->result_array();

        // var_dump($xQry);
        // die;

        if ($xQry) {
            echo json_encode($xQry);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function loadPro()
    {
        $datax = $this->session->userdata('pro');

        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Project Data';
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Project Data';
            $data['idx'] = '0';
            // $data['tuser'] = $datax['tu'];
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('master/i_project', $data);
    }


    public function newPro()
    {
        //$data['tu'] = $this->input->post("tu", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('pro', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editPro()
    {

        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('pro', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertPro()
    {

        $input = $this->Project_model->saveData();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updatePro()
    {
        $input = $this->Project_model->updatePro();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyData()
    {
        $id = $this->input->post("id", true);
        $input = $this->Project_model->deleteData($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getCustomer()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getCustomer();
        echo json_encode($vdata);
    }

    public function getManager()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Project_model->getManager();
        echo json_encode($vdata);
    }

    public function getCatProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Project_model->getCatProject();
        echo json_encode($vdata);
    }

    public function getCoa()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getCoaPendapatan();
        echo json_encode($vdata);
    }



}

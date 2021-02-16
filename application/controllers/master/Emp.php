<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('Emp_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();

        // var_dump($data['user']);
        // die;
        //  $datas['title'] = 'iDeas System Home';
        $data['curlx'] = $this->uri->segment(2);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];

        $data['divisi'] = $this->Emp_model->getDivisi();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/v_emp', $data);
        $this->load->view('templates/footer');
    }



    public function getEmp()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Emp_model->getEmp();
        echo json_encode($data);
    }



    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT *, to_char(dt_birth, 'dd-mm-yyyy') as dt_birth_char,
                        to_char(join_date, 'dd-mm-yyyy') as join_date_char,
                        to_char(dt_hire, 'dd-mm-yyyy') as dt_hire_char,
                        to_char(dt_release, 'dd-mm-yyyy') as dt_release_char
            from master.mpegawai
            WHERE nk = '" . $idx . "';";

        $xQry = $this->db->query($q)->result_array();

        if ($xQry) {
            echo json_encode($xQry);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function loadEmp()
    {
        $datax = $this->session->userdata('emp');

        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Employee Data';
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Employee Data';
            $data['idx'] = '0';
            // $data['tuser'] = $datax['tu'];
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('master/i_emp', $data);
    }


    public function newEmp()
    {
        //$data['tu'] = $this->input->post("tu", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('emp', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editEmp()
    {

        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';
        // var_dump($data['id']);
        // die;
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('emp', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertEmp()
    {

        $input = $this->Emp_model->saveEmp();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateEmp()
    {
        $input = $this->Emp_model->updateEmp();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyEmp()
    {
        $id = $this->input->post("id", true);
        $input = $this->Emp_model->destroyEmp($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDivisi()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Emp_model->getDivisi();
        echo json_encode($vdata);
    }

    public function getSpv()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Emp_model->getSpv();
        echo json_encode($vdata);
    }
}

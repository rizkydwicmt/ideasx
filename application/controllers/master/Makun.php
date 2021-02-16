<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Makun extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('Makun_model');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        //  $datas['title'] = 'iDeas System Home';
        $data['curlx'] = $this->uri->segment(4);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];
        //$data['tittle'] =  'Balance Report';


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        if ($data['curlx'] == 'Breport') {
            $this->load->view('master/v_akun_neraca', $data);
        } elseif ($data['curlx'] == 'Bbesar') {
            $this->load->view('master/v_akun_plost', $data);
        }
        $this->load->view('templates/footer');
    }



    public function getMAkunNeraca()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Makun_model->getMAkunNeraca();
        echo json_encode($data);
    }

    public function getDAkunNeraca()
    {
        $id = $this->input->post("id", true);
        $data = $this->Makun_model->getDAkunNeraca($id);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }



    public function simpanData()
    {

        $input = $this->Makun_model->saveData();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateData($id)
    {
        $input = $this->Makun_model->updateData($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyData()
    {
        $id = $this->input->post("id", true);
        $input = $this->Makun_model->destroyData($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function destroyDetail()
    {
        $id = $this->input->post("id", true);
        $input = $this->Makun_model->destroyDetail($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function getCoa($c)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Makun_model->getCoa($c);
        echo json_encode($data);
    }


    public function insertDetail($i)
    {
        // var_dump('ok');
        // die;
        //$i = $this->input->post("info", true);

        $input = $this->Makun_model->saveDetail($i);

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }
}

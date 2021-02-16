<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('Coa_model');
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
        $data['curlx'] = $this->uri->segment(2);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];

        $data['tax'] = $this->Coa_model->getTaxAccount();
        $data['cflow'] = $this->Coa_model->getCashFlowAccount();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/v_coa', $data);
        $this->load->view('templates/footer');
    }



    public function getCoa()
    {
        $id = $this->input->post("id", true);
        $id = !is_null($id) ? ($id) : '0';

        $this->output->set_content_type('application/json');
        $data = $this->Coa_model->getCoa($id);
        echo json_encode($data);
    }



    public function simpanCoa()
    {

        $input = $this->Coa_model->saveCoa();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateCoa($id)
    {
        $input = $this->Coa_model->updateCoa($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyCoa()
    {
        $id = $this->input->post("id", true);
        $input = $this->Coa_model->destroyCoa($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

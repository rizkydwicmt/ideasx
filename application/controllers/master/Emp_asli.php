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



    public function simpanEmp()
    {

        $input = $this->Emp_model->saveEmp();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateEmp($id)
    {
        $input = $this->Emp_model->updateEmp($id);
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
}

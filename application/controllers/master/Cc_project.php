<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cc_project extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('Cc_project_model');
        $this->load->model('DataMaster_model');
    }

    public function index($kindof)
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['jenis'] = $kindof;
        $data['curlx'] = $this->uri->segment(4);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $data['Customer'] = $this->DataMaster_model->getCustomer();
        $data['Employee'] = $this->DataMaster_model->getEmployee();
        $data['Currency'] = $this->DataMaster_model->getCurrency();
        $data['Coa'] = $this->DataMaster_model->getCoa();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        if ($kindof == 'Cost_center') {
            $this->load->view('master/v_cost_center', $data);
        } elseif ($kindof == 'Project') {
            $data['CatProject'] = $this->Cc_project_model->getCatProject();
            $this->load->view('master/v_project', $data);
        };
        $this->load->view('templates/footer');
    }


    public function getData($j)
    {
        $this->output->set_content_type('application/json');
        $data = $this->Cc_project_model->getData($j);
        echo json_encode($data);
    }



    public function appendData($jenis)
    {

        $input = $this->Cc_project_model->saveData($jenis);

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateData($id)
    {
        $input = $this->Cc_project_model->editData($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyData()
    {
        $id = $this->input->post("id", true);
        $input = $this->Cc_project_model->deleteData($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

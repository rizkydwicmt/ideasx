<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Item_model');
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

        //  $datas['title'] = 'iDeas System Home';
        $data['curlx'] = $this->uri->segment(2);
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $data['unit'] = $this->DataMaster_model->getUnit();
        $data['itemType'] = $this->DataMaster_model->getItemType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/v_item', $data);
        $this->load->view('templates/footer');
    }


    public function getItem()
    {


        $this->output->set_content_type('application/json');
        $data = $this->Item_model->getItem();
        echo json_encode($data);
    }



    public function simpanItem()
    {

        $input = $this->Item_model->saveItem();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateItem($id)
    {
        $input = $this->Item_model->editItem($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyItem()
    {
        $id = $this->input->post("id", true);
        $input = $this->Item_model->deleteItem($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

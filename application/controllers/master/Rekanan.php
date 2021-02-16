<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekanan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('Rekanan_model');
    }

    //public $jenisRekanan = "";

    public function index($kindof)
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(4);
        $data['jnsRekanan'] = $kindof;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/v_rekanan', $data);
        $this->load->view('templates/footer');
    }


    public function getRekanan($jr)
    {
        //$jr = $this->input->post("jnsRekanan", true);
        // var_dump('this is jenis rekanan ' . $jr);
        // die;

        $this->output->set_content_type('application/json');
        $data = $this->Rekanan_model->getDataRekanan($jr);
        echo json_encode($data);
    }



    public function simpanRekanan($jnsRekanan)
    {

        $input = $this->Rekanan_model->saveRekanan($jnsRekanan);

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateRekanan($id)
    {
        $input = $this->Rekanan_model->editRekanan($id);
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyRekanan()
    {
        $id = $this->input->post("id", true);
        $input = $this->Rekanan_model->deleteRekanan($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }
}

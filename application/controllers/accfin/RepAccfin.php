<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RepAccfin extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };

        $this->load->model('RepAccfin_model');
        $this->load->model('DataMaster_model');
    }

    public function Index()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(4);

        // var_dump($data['curlx']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(4)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        if (($data['curlx']) == 'Cb') {
            $this->load->view('finance/v_cb', $data);
        } elseif (($data['curlx']) == 'Bb') {
            $this->load->view('finance/v_bb', $data);
        }
        $this->load->view('templates/footer');
    }


    public function getMaster($x)
    {

        $this->output->set_content_type('application/json');
        $data = $this->RepAccfin_model->getMaster($x);
        echo json_encode($data);
    }

    public function getDetail()
    {
        $idr = $this->input->post("idd", true);
        $this->output->set_content_type('application/json');
        $data = $this->RepAccfin_model->getDetail($idr);
        echo json_encode($data);
    }
}

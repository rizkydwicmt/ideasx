<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('User_model');
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        $data['curlx'] = $this->uri->segment(1);


        $data['tittle'] =  'Profile';
         $data['mpegawai'] = $this->db->get_where('master.mpegawai', ['nk' => $data['user']['nk']])->row_array();
        // $data['mpegawai'] = $this->db->get_where('master.mpegawai', ['nk' => 'IDE-1801'])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/v_profile', $data);
        $this->load->view('templates/footer');
    }



    public function getUpload()
    {
        $filename = $this->session->userdata('username');
        //die;
        $data = array(); // Buat variabel $data sebagai array
        //$data['sheet'] = [];

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php

            $upload = $this->User_model->upload_file($filename);
            // var_dump($this->filename);
            // die;

            if ($upload['result'] == "success") {
                echo json_encode(array('success' => true));
            } else { // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
                echo json_encode(array('errorMsg' => 'Some errors occured.'));
            }
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['tittle'] =  $noTrans['menu_name'];

        $ds = $this->session->userdata('usr');
        if ($ds) {
            $data['tuser'] = $ds['tu'];
            $this->session->unset_userdata('usr');
        } else {
            $data['tuser'] = '2';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/v_user', $data);
        $this->load->view('templates/footer');
    }



    public function getUser()
    {

        $this->output->set_content_type('application/json');
        $data = $this->User_model->getUser();
        echo json_encode($data);
    }

    public function getDetail()
    {
        $id = $this->input->post("id", true);
        $data = $this->User_model->getDetail($id);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }

    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT
                vuser, 
                passwd, 
                full_name, 
                tipe, 
                passwd_auth,
                nk,
                email,
                is_active,
                user_role
            from master.vuser
            WHERE vuser = '" . $idx . "';";

        $xQry = $this->db->query($q)->result_array();

        if ($xQry) {
            echo json_encode($xQry);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDetailData()
    {
        $idx = $this->input->post("idx", true);


        $query = "SELECT vuser, 
                        ((lpad(' - '::text, 3 * lvl) || menu_name::text))::character varying(255) AS nama_menu,
                        lvl,
                        isbrowse,
                        isinsert,
                        isedit,
                        isdelete,
                        isprint,
                        imenu,
                        tag::varchar(1) as isdetail
                    FROM master.vuser_menu
                    WHERE vuser= '" . $idx . "'
                    ORDER BY imenu ASC;";


        $data = $this->db->query($query)->result_array();

        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDetailDefault()
    {
        $idx = $this->input->post("idx", true);


        $query = "SELECT 
                    menu_id, 
                    menu_name,
                    ((lpad('', 6 * lvl,'-') || menu_name::text))::character varying(255) AS nama_menu,
                    url_active, 
                    lvl, 
                    '1'::character varying(1) as isbrowse, 
                    '1'::character varying(1) as isinsert, 
                    '1'::character varying(1) as isedit,  
                    '1'::character varying(1) as isdelete, 
                    '1'::character varying(1) as isprint, 
                    isdetail, 
                    menu_id as imenu
                    FROM master.menu_web
                    ORDER BY menu_id";


        $data = $this->db->query($query)->result_array();

        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function loadUser()
    {
        $datax = $this->session->userdata('usr');

        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit User';
            $data['idx'] = $datax['id'];
            $data['tuser'] = $datax['tu'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New User';
            $data['idx'] = '0';
            $data['tuser'] = $datax['tu'];
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('admin/i_user', $data);
    }


    public function newUser()
    {
        $data['tu'] = $this->input->post("tu", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('usr', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function editUser()
    {

        $data['id'] = $this->input->post("id", true);
        $data['tu'] = $this->input->post("tu", true);
        $data['m'] = 'e';

        // var_dump($this->input->post("tu", true));
        // die;

        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('usr', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function insertUser()
    {

        $input = $this->User_model->saveUser();

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateUser()
    {
        $input = $this->User_model->editUser();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function destroyUser()
    {
        $id = $this->input->post("id", true);
        $input = $this->User_model->destroyUser($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }



    public function getRekanan()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->User_model->getRekanan();
        echo json_encode($vdata);
    }


    public function getUpload()
    {
        // var_dump($filename);
        // die;
        $data = array(); // Buat variabel $data sebagai array
        //$data['sheet'] = [];

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php

            $upload = $this->User_model->upload_file($this->session->userdata('username'));
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

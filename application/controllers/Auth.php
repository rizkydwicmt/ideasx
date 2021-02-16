<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model');
    }
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'iDeas System Log In';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $usrname = $this->input->post('username');
        $passwd = $this->input->post('password');

        $admin = $this->db->get_where('master.vadmin', ['vusr_admin' => $usrname])->row_array();

        if ($admin) {

            //var_dump(strtoupper(md5($passwd)));
            //die;
            //terbaca sebagai admin
            if (strtoupper(md5($passwd)) == $admin['vpwd_admin']) {
                $data = [
                    'username' => $admin['vusr_admin'],
                    'fullname' => 'Administrator',
                    'role' => 'admin'
                ];
                $this->session->set_userdata($data);
                redirect('main');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong Password</div>');
                redirect('auth');
            }
        } else {

            $user = $this->db->get_where('master.vuser', ['vuser' => $usrname])->row_array();

            if ($user) {
                //user exist
                if (strtoupper(md5($passwd)) == $user['passwd']) {
                    $data = [
                        'username' => $user['vuser'],
                        'fullname' => $user['full_name'],
                        'role' => $user['user_role']
                    ];
                    $this->session->set_userdata($data);
                    redirect('main');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Wrong Password</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Username is not Registered</div>');
                redirect('auth');
            }
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('fullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('username', 'User Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[repassword]');
        $this->form_validation->set_rules('repassword', 'Repeat Password', 'required|trim|matches[password]', [
            'matches' => 'Password dint match !!!',
            'min_length' =>  'Password too Shot !!!'
        ]);



        if ($this->form_validation->run() == false) {
            $data['title'] = 'iDeas System Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            /*
            $data = [
                'vuser' => $this->input->post('username'),
                'passwd' => strtoupper(md5($this->input->post('password'))),
                'full_name' => $this->input->post('fullname'),
                'passwd_auth' => strtoupper(md5($this->input->post('password'))),
                'email' => $this->input->post('email')
            ];
            */

            if ($this->Auth_model->tambahDataUser($_POST)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Your Account has been Created! PLease Login</div>');
                redirect('auth');
            }
            /*
            $this->db->insert('master.vuser', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Account has been Created! PLease Login</div>');
            redirect('auth');
             */
        }
    }


    public function logout()
    {

        $this->session->unset_userdata('username');
        $this->session->unset_userdata('fullname');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been LogOut</div>');
        redirect('auth');
    }
}

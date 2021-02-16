<?php

class User_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getUser()
    {


        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;
        $tipe_user = !is_null($this->input->post('tipe_user')) ? $this->input->post('tipe_user') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        // var_dump($tipe_user);
        // die;


        $qrM = "SELECT a.*
                    FROM master.vuser a
                    WHERE lvl=" . $tipe_user . "
                    AND  concat(upper(a.vuser),'',upper(a.full_name)) like upper('%".$getFilteredVal."%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.vuser,
                         a.email,
                         a.is_active,
                         a.email,
                         a.tipe,
                         a.user_role,
                         a.full_name,
                         a.nk,   
                         p.jabatan 
                    FROM master.vuser a
                    LEFT JOIN master.mpegawai p ON p.nk=a.nk
                    WHERE lvl=" . $tipe_user . "
                    AND  concat(upper(a.vuser),'',upper(a.full_name)) like upper('%".$getFilteredVal."%') 
                    ORDER BY a.vuser ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function getDetail($vuser)
    {

        $query = "SELECT a.*, ((lpad(''::text, 3 * a.lvl,'-') || a.menu_name::text))::character varying(255) AS nama_menu,
                        (CASE WHEN a.isbrowse ='0' THEN 'n'
                              WHEN a.isbrowse='1' THEN 'y'
                        END)::varchar(1) as hbrowse,
                        (CASE WHEN a.isinsert ='0' THEN 'n'
                              WHEN a.isinsert='1' THEN 'y'
                        END)::varchar(1) as hinsert,
                        (CASE WHEN a.isedit ='0' THEN 'n'
                              WHEN a.isedit='1' THEN 'y'
                        END)::varchar(1) as hedit,
                        (CASE WHEN a.isdelete ='0' THEN 'n'
                              WHEN a.isdelete='1' THEN 'y'
                        END)::varchar(1) as hdelete,
                        (CASE WHEN a.isprint ='0' THEN 'n'
                              WHEN a.isprint='1' THEN 'y'
                        END)::varchar(1) as hprint
                    FROM master.vuser_menu a
                    WHERE vuser='" . $vuser . "'
                    ORDER BY a.imenu ASC";

        $result = array();
        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function saveUser()
    {
        //$data = $this->input->post('info', true)[0];
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];
        //var_dump($datdetail);
        // var_dump($data['vuser']);
        //die;

        $qrM = "INSERT INTO master.vuser (
                vuser, tipe, full_name,
                nk, is_active, user_role, email,
                passwd, passwd_auth,lvl,
                image)
               VALUES (
                '" . $datmaster['vuser'] . "', '" . $datmaster['tipe'] . "', '" . $datmaster['full_name'] . "',
                '" . $datmaster['nk'] . "', '1', '" . $datmaster['user_role'] . "','" . $datmaster['email'] . "',
                '" . strtoupper(md5($datmaster['passwd'])) . "', '" . strtoupper(md5($datmaster['passwd_auth'])) . "', " . $datmaster['tuser'] . ",
                 trim('" . $datmaster['vuser'] . "'||'.jpg'));";

        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $sQL = "INSERT INTO master.vuser_menu (
                    vuser, imenu, menu_name,
                    menu_caption, lvl , tag,
                    isbrowse, 
                    isinsert, 
                    isedit, 
                    isdelete,
                    isprint, 
                    isexport, 
                    ispreparer, 
                    isreviewer,
                    isapprover)
                    VALUES(
                    '" . $datmaster['vuser'] . "'," . $datdetail[$x]['menu_id'] . ",'" . $datdetail[$x]['menu_name'] . "',
                    NULL, " . $datdetail[$x]['lvl'] . ", " . $datdetail[$x]['isdetail'] . ",
                    '" . $datdetail[$x]['isbrowse'] . "',
                    '" . $datdetail[$x]['isinsert'] . "',
                    '" . $datdetail[$x]['isedit'] . "',
                    '" . $datdetail[$x]['isdelete'] . "',
                    '" . $datdetail[$x]['isprint'] . "',
                    '1',
                    '1',
                    '1',
                    '1');";
            $qrD = $qrD . $sQL;
        };


        // var_dump($qrM);
        // var_dump($qrD);
        // die;


        $this->db->trans_begin();
        $this->db->query($qrM);
        $this->db->query($qrD);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            // $this->upload_image($data['vuser']);
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function editUser()
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];


        $qrM = "UPDATE master.vuser SET
                    vuser ='" .  $datmaster['vuser'] . "', 
                    tipe ='" .  $datmaster['tipe'] . "', 
                    full_name ='" .  $datmaster['full_name'] . "', 
                    nk ='" .  $datmaster['nk'] . "',  
                    is_active ='" .  $datmaster['is_active'] . "', 
                    user_role ='" .  $datmaster['user_role'] . "',  
                    email ='" .  $datmaster['email'] . "', 
                    lvl = " .  $datmaster['tuser'] . ", 
                    image = trim('" .  $datmaster['vuser'] . "'||'.jpg')
                    WHERE vuser ='" .  $datmaster['id_user'] . "';
                ";





        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

                $idd =  $datdetail[$x]['imenu'];

                $sQL = "UPDATE master.vuser_menu SET 
                            isbrowse = '" . $datdetail[$x]['isbrowse'] . "',
                            isinsert = '" . $datdetail[$x]['isinsert'] . "', 
                            isedit = '" . $datdetail[$x]['isedit'] . "', 
                            isdelete = '" . $datdetail[$x]['isdelete'] . "',
                            isprint = '" . $datdetail[$x]['isprint'] . "'
                        WHERE imenu=" . $idd . " 
                                AND vuser = '" .  $datmaster['vuser'] . "' ;";
           

            $qrD = $qrD . $sQL;
        };



        // var_dump($qrD);
        // die;

        $this->db->trans_begin();
        $this->db->query($qrM);
        $this->db->query($qrD);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function destroyUser($id)
    {
        $this->db->where('vuser', $id);
        $this->db->delete('master.vuser');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

  

    public function getRekanan()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis
                    FROM master.mrekanan a
                    WHERE a.jenis='PEGAWAI'
                    ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    private function upload_image($vusr)
    {
        $config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $vusr;
        $config['overwrite'] = true;
        $config['max_size']      = 1024;
        // $config['max_width']     = 1024;
        // $config['max_height']    = 768;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->do_upload('image');
        }
        return "default.jpg";
    }


    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename)
    {
        $this->load->library('upload');
        // var_dump($filename);
        // die;

        $config['upload_path'] = './img_user/';

        // $config['allowed_types'] = 'pdf';

        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 100;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;


        $config['overwrite'] = true;
        $config['file_name'] = $filename;



        $this->upload->initialize($config); // Load konfigurasi uploadnya

        if ($this->upload->do_upload('file')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }
}

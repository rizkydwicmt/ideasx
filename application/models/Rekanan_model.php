<?php

class Rekanan_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        //        $this->load->database();
    }

    public function getDataRekanan($jr)
    {


        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        // $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        // $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $offset = ($page - 1) * $rows;

        $result = array();


        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $qtotal = "SELECT * FROM master.mrekanan WHERE jenis=upper('" . $jr . "')
                    AND  concat(upper(nama_rekanan),'',upper(alamat),'',upper(kd_rekanan)) like upper('%" . $getFilteredVal . "%')";

        $result['total'] = $this->db->query($qtotal)->num_rows();

        $query = "SELECT * FROM master.mrekanan WHERE jenis=upper('" . $jr . "')
                    AND  concat(upper(nama_rekanan),'',upper(alamat),'',upper(kd_rekanan)) like upper('%" . $getFilteredVal . "%') 
                    ORDER BY kd_rekanan ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }


    public function saveRekanan($jr)
    {

        //get id
        //-$qNo = "SELECT master.fn_gen_id_supplier() AS new_no_trans";
        $jRek =  strtoupper($jr);

        if ($jRek == 'SUPPLIER') {
            $rNo = $this->db->get('master.fn_gen_id_supplier() as new_no_trans ')->row_array();
            $id = $rNo['new_no_trans'];
        } elseif ($jRek == 'CUSTOMER') {
            $rNo = $this->db->get('master.fn_gen_id_customer() as new_no_trans ')->row_array();
            $id = $rNo['new_no_trans'];
        }


        $data = array(
            'kd_rekanan' => "$id",
            'nama_rekanan'  => $this->input->post('nama_rekanan', true),
            'contact'  => $this->input->post('kontak', true),
            'alamat' => $this->input->post('alamat', true),
            'kota' => $this->input->post('kota', true),
            'telephone' => $this->input->post('telephone', true),
            'faxcimile' => $this->input->post('faxcimile', true),
            'email' => $this->input->post('email', true),
            'mobile_no' => $this->input->post('mobile_no', true),
            'npwp' => $this->input->post('npwp' . true),
            'nppkp' => $this->input->post('nppkp', true),
            'remarks' => $this->input->post('remarks', true),
            'jenis' => "$jRek",
            'usr_upd' =>  $this->session->userdata('username'),
            'usr_ins' =>  $this->session->userdata('username')
        );


        $this->db->insert('master.mrekanan', $data);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function editRekanan($id)
    {
        $data =  array(
            'nama_rekanan' => $this->input->post('nama_rekanan', true),
            'contact' => $this->input->post('kontak', true),
            'alamat' => $this->input->post('alamat', true),
            'kota' => $this->input->post('kota', true),
            'telephone' => $this->input->post('telephone', true),
            'faxcimile' => $this->input->post('faxcimile', true),
            'email' => $this->input->post('email', true),
            'mobile_no' => $this->input->post('mobile_no', true),
            'npwp' => $this->input->post('npwp', true),
            'nppkp' => $this->input->post('nppkp', true),
            'remarks' => $this->input->post('remarks', true),
            'usr_upd' =>  $this->session->userdata('username')
        );

        $this->db->where('kd_rekanan', $id);
        $this->db->set($data);
        $hasil = $this->db->update('master.mrekanan');
        return $hasil;
    }

    public function deleteRekanan($id)
    {
        $this->db->where('kd_rekanan', $id);
        $this->db->delete('master.mrekanan');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    /*
    public function tambahDataUser()
    {
        $query = "INSERT INTO master.vuser 
                  (vuser, passwd, full_name, passwd_auth,  email)
                  VALUES
                  (" . $this->db->escape($_POST['username']) . "," .
            $this->db->escape(strtoupper(md5($_POST['password']))) . "," .
            $this->db->escape($_POST['fullname']) . "," .
            $this->db->escape(strtoupper(md5($_POST['password']))) . "," .
            $this->db->escape($_POST['email']) . ")";


        $this->db->query($query);


        return $this->db->affected_rows();;
    }
    */
}

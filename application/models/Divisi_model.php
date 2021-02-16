<?php

class Divisi_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getDivisi($id)
    {

        $result = array();
        $query = $this->db->query("SELECT * FROM master.vmdivisi WHERE parentid = '$id'");

        foreach ($query->result_array() as $row) {

            $row['state'] = $this->has_child($row['id']) ? 'closed' : 'open';
            array_push($result, $row);
        }
        return $result;
    }

    private function has_child($id)
    {


        $count = "select count(*) FROM master.vmdivisi WHERE parentid='$id'";
        $rs =  $this->db->query($count)->num_rows();

        return $rs > 0 ? true : false;
    }



    public function saveDivisi()
    {

        $data = array(
            'kd_divisi'  => $this->input->post('kd_divisi', true),
            'kd_parent'  => $this->input->post('kd_parent', true),
            'deskripsi' => $this->input->post('deskripsi', true),
            'isdetail' => $this->input->post('isdetail', true),
            'usr_ins' => $this->session->userdata('username'),
            'usr_upd' => $this->session->userdata('username')
        );


        $this->db->insert('master.mdivisi', $data);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function updateDivisi($id)
    {

        $data =  array(
            'kd_divisi'  => $this->input->post('kd_divisi', true),
            'kd_parent'  => $this->input->post('kd_parent', true),
            'deskripsi' => $this->input->post('deskripsi', true),
            'isdetail' => $this->input->post('isdetail', true),
            'usr_upd' => $this->session->userdata('username')
        );

        $this->db->where('kd_divisi', $id);
        $this->db->set($data);
        $hasil = $this->db->update('master.mdivisi');
        return $hasil;
    }

    public function destroyDivisi($id)
    {
        $this->db->where('kd_divisi', $id);
        $this->db->delete('master.mdivisi');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }
}

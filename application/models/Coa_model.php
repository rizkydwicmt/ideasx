<?php

class Coa_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getCoa($id)
    {

        $result = array();
        $query = $this->db->query("SELECT * FROM master.vmrek_gl WHERE parentid = '$id'");

        foreach ($query->result_array() as $row) {

            $row['state'] = $this->has_child($row['id']) ? 'closed' : 'open';
            array_push($result, $row);
        }
        return $result;
    }

    private function has_child($id)
    {


        $count = "select count(*) FROM master.vmrek_gl WHERE parentid='$id'";
        $rs =  $this->db->query($count)->num_rows();

        return $rs > 0 ? true : false;
    }



    public function saveCoa()
    {

        //get id
        //-$qNo = "SELECT master.fn_gen_id_supplier() AS new_no_trans";
        $parent =  $this->input->post('id_parent', true);
        $rNo = $this->db->get_where('master.mrek_gl', ['id_parent' => "$parent"])->row_array();
        $lvl = $rNo['lvl'];
        $level = $lvl + 1;

        // $rNo = $this->db->query("SELECT master.fn_gen_id_supplier() AS new_no_trans");
        //$id = $rNo->row();

        $data = array(
            'id_rek_gl'  => $this->input->post('id_rek_gl', true),
            'id_parent'  => $this->input->post('id_parent', true),
            'descriptions' => $this->input->post('nama_rekening', true),
            'golongan' => $this->input->post('golongan', true),
            'isdetail' => $this->input->post('isdetail', true),
            'id_rek_pajak' => $this->input->post('id_rek_pajak', true),
            'id_arus' => $this->input->post('id_arus', true),
            'lvl' => $level
        );


        $this->db->insert('master.mrek_gl', $data);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function updateCoa($id)
    {

        $data =  array(
            'id_rek_gl'  => $this->input->post('id_rek_gl', true),
            'id_parent'  => $this->input->post('id_parent', true),
            'descriptions' => $this->input->post('nama_rekening', true),
            'golongan' => $this->input->post('golongan', true),
            'isdetail' => $this->input->post('isdetail', true),
            'id_rek_pajak' => $this->input->post('id_rek_pajak', true),
            'id_arus' => $this->input->post('id_arus', true)
        );

        $this->db->where('id_rek_gl', $id);
        $this->db->set($data);
        $hasil = $this->db->update('master.mrek_gl');
        return $hasil;
    }

    public function destroyCoa($id)
    {
        $this->db->where('id_rek_gl', $id);
        $this->db->delete('master.mrek_gl');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function getTaxAccount()
    {
        $query = "SELECT id_rek_pajak, descriptions as nama_rekening
                    FROM master.mrek_gl_pajak
                    WHERE isdetail='1' 
                    ORDER BY id_rek_pajak ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getCashFlowAccount()
    {
        $query = "SELECT id_arus, deskripsi as nama_arus
                    FROM master.marus_kas
                    WHERE isdetail='1' 
                    ORDER BY id_arus ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }
}

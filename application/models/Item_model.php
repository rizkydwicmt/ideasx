<?php

class Item_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        //        $this->load->database();
    }

    public function getItem()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        // $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        // $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $offset = ($page - 1) * $rows;

        $result = array();


        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $qtotal = "SELECT a.*, t.item_type_name
                    FROM master.mitem a
                    LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                    WHERE 1=1
                    AND  concat(upper(a.kd_item),'',upper(a.nama_item),'',upper(t.item_type_name)) like upper('%" . $getFilteredVal . "%')";

        $result['total'] = $this->db->query($qtotal)->num_rows();

        $query = "SELECT a.* , t.item_type_name
                    FROM master.mitem  a
                    LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                    WHERE 1=1
                    AND  concat(upper(a.kd_item),'',upper(a.nama_item),'',upper(t.item_type_id)) like upper('%" . $getFilteredVal . "%') 
                    ORDER BY a.kd_item ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }


    public function saveItem()
    {

        //get id
        //-$qNo = "SELECT master.fn_gen_id_supplier() AS new_no_trans";
        $it = $this->input->post('item_type_id', true);
        $rNo = $this->db->get("master.fn_gen_item_id('" . $it . "') as new_no_trans")->row_array();
        $id = $rNo['new_no_trans'];

        $data = array(
            'kd_item' => "$id",
            'nama_item'  => $this->input->post('nama_item', true),
            'item_type_id'  => $this->input->post('item_type_id', true),
            'kd_satuan' => $this->input->post('kd_satuan', true),
            'kd_satuan_beli' => $this->input->post('kd_satuan_beli', true),
            'rasio' => $this->input->post('ratio', true),
            'lvl' => 1,
            'isdetail' => '1',
            'isinventory' => '1',
            'usr_upd' =>  $this->session->userdata('username'),
            'usr_ins' =>  $this->session->userdata('username')

        );


        $this->db->insert('master.mitem', $data);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function editItem($id)
    {
        $data =  array(
            'kd_item' => $this->input->post('kd_item', true),
            'nama_item'  => $this->input->post('nama_item', true),
            'item_type_id'  => $this->input->post('item_type_id', true),
            'kd_satuan' => $this->input->post('kd_satuan', true),
            'kd_satuan_beli' => $this->input->post('kd_satuan_beli', true),
            'rasio' => $this->input->post('ratio', true),
            'usr_upd' =>  $this->session->userdata('username')
        );

        $this->db->where('kd_item', $id);
        $this->db->set($data);
        $hasil = $this->db->update('master.mitem');
        return $hasil;
    }

    public function deleteItem($id)
    {
        $this->db->where('kd_item', $id);
        $this->db->delete('master.mitem');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }
}

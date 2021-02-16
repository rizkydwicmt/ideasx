<?php

class Cba_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getCba()
    {


        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*
                    FROM master.cash_bank_acc a
                    WHERE 1=1
                    AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*
                    FROM master.cash_bank_acc a
                    WHERE 1=1
                    AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredVal%') 
                    ORDER BY a.id_rek_gl ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function saveCba()
    {
        // $datmaster = $this->input->post('data', true);
        // var_dump($datmaster);
        // die;

        $data = array(
            'id_rek_gl'  => $this->input->post('id_rek_gl', true),
            'jenis'  => $this->input->post('jenis', true),
            'descriptions' => $this->input->post('descriptions', true),
            'no_acc' => $this->input->post('no_acc', true),
            'isdetail' => '1',
            'id' => $this->input->post('id', true),
            'usr_ins' => $this->session->userdata('username'),
            'usr_upd' => $this->session->userdata('username')
        );


        $this->db->insert('master.cash_bank_acc', $data);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function updateCba($id)
    {
        $data =  array(
            'id_rek_gl'  => $this->input->post('id_rek_gl', true),
            'jenis'  => $this->input->post('jenis', true),
            'descriptions' => $this->input->post('descriptions', true),
            'no_acc' => $this->input->post('no_acc', true),
            'id' => $this->input->post('id', true),
            'usr_upd' => $this->session->userdata('username')
        );

        $this->db->where('id_rek_gl', $id);
        $this->db->set($data);
        $hasil = $this->db->update('master.cash_bank_acc');
        return $hasil;
    }

    public function destroyCba($id)
    {
        $this->db->where('id_rek_gl', $id);
        $this->db->delete('master.cash_bank_acc');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }
}

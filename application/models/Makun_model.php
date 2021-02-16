<?php

class Makun_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getMAkunNeraca()
    {


        $qrM = "SELECT a.*
                    FROM accfin.mrek_neraca a
                    WHERE 1=1";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*
                    FROM accfin.mrek_neraca a
                    WHERE 1=1
                    ORDER BY a.id_rek_neraca ASC";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function getDAkunNeraca($id)
    {

        $query = "SELECT a.*
                    FROM master.mrek_gl a
                    WHERE a.id_rek_neraca='" . $id . "'
                    ORDER BY a.id_rek_gl ASC";

        $result = array();
        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function saveData()
    {
        $data = $this->input->post('info', true)[0];
        // var_dump($data);
        // var_dump($data['vuser']);
        // die;

        $qrM = "INSERT INTO accfin.mrek_neraca (
                id_rek_neraca, 
                diskripsi, 
                jenis)
               VALUES (
                '" . $data['id_rek_neraca'] . "', 
                '" . $data['diskripsi'] . "', 
                '" . $data['jenis'] . "');";


        $this->db->trans_begin();
        $this->db->query($qrM);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function updateData($id)
    {

        $data = $this->input->post('info', true)[0];

        $data =  array(
            'id_rek_neraca'  => $data['id_rek_neraca'],
            'diskripsi'  => $data['diskripsi'],
            'jenis' => $data['jenis']
        );

        $this->db->where('id_rek_neraca', $id);
        $this->db->set($data);
        $hasil = $this->db->update('accfin.mrek_neraca');
        return $hasil;
    }

    public function destroyData($id)
    {
        $this->db->where('id_rek_neraca', $id);
        $this->db->delete('accfin.mrek_neraca');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function updateDetail()
    {
        $data = $this->input->post('info', true)[0];


        $qrM = "UPDATE master.vuser_menu SET
                isbrowse = '" . $data['isbrowse'] . "',
                isinsert = '" . $data['isinsert'] . "', 
                isedit = '" . $data['isedit'] . "',
                isdelete = '" . $data['isdelete'] . "',
                isprint = '" . $data['isprint'] . "',
                isexport = '" . $data['isexport'] . "'
                where vuser ='" . $data['vuserx'] . "' AND imenu = " . $data['imenu'] . ";";

        // var_dump($qrM);
        // die;

        $this->db->trans_begin();
        $this->db->query($qrM);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function destroyDetail($id)
    {

        $qrM = "UPDATE master.mrek_gl
                SET id_rek_neraca= NULL
                WHERE id_rek_gl='" . $id . "'";


        $this->db->trans_begin();
        $this->db->query($qrM);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function getCoa($c)
    {
        $id = substr($c, 0, 1);

        $query = "SELECT a.id_rek_gl, a.descriptions, a.golongan
                    FROM master.mrek_gl a
                    WHERE a.isdetail='1' and a.id_rek_neraca is null AND SUBSTRING(a.id_rek_gl,1,1)='" . $id . "'  
                    ORDER BY a.id_rek_gl ASC";

        // var_dump($query);
        // die;

        $result = array();
        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }

    public function saveDetail($i)
    {

        // $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true);

        // var_dump($datdetail);
        // die;


        $qrD = '';
        $sQL = '';
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            $sQL = "UPDATE master.mrek_gl
                    SET id_rek_neraca='" . $i . "'
                    where id_rek_gl='" . $datdetail[$x]['id_rek_gl'] . "'; ";
            $qrD = $qrD . $sQL;
        };

        // var_dump($qrD);
        // die;


        $this->db->trans_begin();
        $this->db->query($qrD);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }
}

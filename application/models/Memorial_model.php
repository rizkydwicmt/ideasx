<?php

class Memorial_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getMemorial()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                    FROM accfin.jurnal a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0'
                    AND a.dt_jurnal::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_jurnal),'',upper(a.remark)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_jurnal, 
                            a.no_jurnal, 
                            to_char(a.dt_jurnal, 'DD-Mon-YYYY') as dt_jurnal,
                            to_char(a.dt_jurnal, 'dd/mm/yyyy') as dt_jurnal_char,
                            to_char(a.dt_due, 'DD-Mon-YYYY') as dt_due, 
                            to_char(a.dt_due, 'dd/mm/yyyy') as dt_due_char, 
                            a.kd_rekanan, 
                            mr.nama_rekanan, 
                            a.remark, 
                            a.usr_ins,
                            a.usr_upd,
                            a.ispost, 
                            a.iscancel, 
                            a.debet,
                            a.kredit,
                            a.id_kurs,
                            a.kurs
                    FROM accfin.jurnal a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0'
                    AND a.dt_jurnal::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_jurnal),'',upper(a.remark)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_jurnal ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }




    public function getMemorialDetail($idd)
    {

        $query = "SELECT    a.id_jurnal, 
                            a.id_jurnal_detail,
                            a.no_reff,
                            a.description, 
                            a.debet,
                            a.kredit,
                            a.id_cc_project,
                            a.id_rek_gl
                    FROM accfin.jurnal_detail a
                    WHERE a.id_jurnal= $idd
                    ORDER BY a.id_jurnal_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['debet'] = tegar_num($row['debet']);
            $row['kredit'] = tegar_num($row['kredit']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(debet) AS total_debet, SUM(kredit) as total_kredit
                FROM accfin.jurnal_detail
                WHERE id_jurnal =" . $idd . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['description'] = "TOTAL";
            $row['debet'] = tegar_num($row['total_debet']);
            $row['kredit'] = tegar_num($row['total_kredit']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        return $result;
    }



    private function getTransid($seq)
    {
        $rIdx = $this->db->get("NEXTVAL('" . $seq . "') as idx")->row_array();
        $id = $rIdx['idx'];

        return $id;
    }


    public function saveMemorial()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        //get no_trans
        $rNo = $this->db->get('accfin.fn_gen_memorial_number() as new_no_trans ')->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('accfin.sq_jurnal');

        //build query insert master
        $qrM = "INSERT INTO accfin.jurnal (
         id_jurnal, no_jurnal, dt_jurnal, dt_due,
         id_trans, id_kurs, kurs,
         kd_rekanan, remark,
         debet, kredit,
         usr_ins, usr_upd,
         ispost, iscancel)
         VALUES (
          $id, '" . $no_trans . "', to_timestamp('" . $datmaster['dt_jurnal'] . "','dd/mm/yyyy'), null,
          '" . $datmaster['idtrans'] . "', 'IDR', 1,
          '" . $datmaster['kd_rekanan'] . "', '" . $datmaster['remarks'] . "',
          " . $datmaster['total_debet'] . ", " . $datmaster['total_kredit'] . ",
          '" . $this->session->userdata('username') . "', '" . $this->session->userdata('username') . "',
          '0','0');";


        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('accfin.sq_jurnal_detail');
            $sQL = "INSERT INTO accfin.jurnal_detail
            (
                nomor,
                id_jurnal, id_jurnal_detail,
                no_reff, id_rek_gl, description,
                debet, kredit,
                id_cc_project, kd_pi)
            VALUES
            (
                $n,
                $id, $idd,
                '" . $datdetail[$x]['no_reff'] . "', '" . $datdetail[$x]['id_rek_gl'] . "', '" . $datdetail[$x]['description'] . "',
                " . $datdetail[$x]['debet'] . ", " . $datdetail[$x]['kredit'] . ",
                '" . $datdetail[$x]['id_cc_project'] . "', null);        
            ";
            $qrD = $qrD . $sQL;
        };


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


    public function editMemorial()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $id = $datmaster['id_jurnal'];

        //build query update master
        $qrM = "UPDATE accfin.jurnal SET
                dt_jurnal = to_timestamp('" . $datmaster['dt_jurnal'] . "','dd/mm/yyyy'),
                kd_rekanan ='" . $datmaster['kd_rekanan'] . "',
                remark ='" . $datmaster['remarks'] . "',
                debet =" . $datmaster['total_debet'] . ",
                kredit =" . $datmaster['total_kredit'] . ",
                usr_upd ='" . $this->session->userdata('username') . "'
                WHERE id_jurnal=" . $id . ";";

        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            if (($datdetail[$x]['id_jurnal_detail']) == '0') {
                $idd = $this->getTransid('accfin.sq_jurnal_detail');
                $sQL = "INSERT INTO accfin.jurnal_detail
                        (
                            nomor,
                            id_jurnal,
                            id_jurnal_detail,
                            no_reff,
                            id_rek_gl,
                            description,
                            debet,
                            kredit,
                            id_cc_project)
                        VALUES
                        (
                            $n,
                            $id,
                            $idd,
                            '" . $datdetail[$x]['no_reff'] . "',
                            '" . $datdetail[$x]['id_rek_gl'] . "',
                            '" . $datdetail[$x]['description'] . "',
                            " . $datdetail[$x]['debet'] . ",
                            " . $datdetail[$x]['kredit'] . ",
                            COALESCE('" . $datdetail[$x]['id_cc_project'] . "',NULL));        
                        ";
            } else {

                $idd =  $datdetail[$x]['id_jurnal_detail'];
                $sQL = "UPDATE accfin.jurnal_detail SET
                            no_reff = '" . $datdetail[$x]['no_reff'] . "',
                            id_rek_gl = '" . $datdetail[$x]['id_rek_gl'] . "',
                            description = '" . $datdetail[$x]['description'] . "',
                            debet =" . $datdetail[$x]['debet'] . ",
                            kredit =" . $datdetail[$x]['kredit'] . ",
                            id_cc_project ='" . $datdetail[$x]['id_cc_project'] . "'
                            WHERE id_jurnal_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };


        //get deleted record 
        $qrX = "SELECT id_jurnal_detail AS idd
                FROM accfin.jurnal_detail
                WHERE id_jurnal=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'id_jurnal_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from accfin.jurnal_detail
                        WHERE id_jurnal_detail=" . $row['idd'] . ";";
                $qrD = $qrD . $sQLX;
            }
        }

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

    public function deleteMemorial($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('id_jurnal', $id);
        $this->db->set($data);
        $hasil = $this->db->update('accfin.jurnal');
        return $hasil;
    }

    public function getCoaNumber()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;
        $offset = ($page - 1) * $rows;

        $getFilteredValCoa = !is_null($this->input->post('searching_coa')) ? $this->input->post('searching_coa') : '';

        $qrM = "SELECT a.id_rek_gl, a.descriptions
            FROM master.mrek_gl a
            WHERE a.isdetail='1'
            AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredValCoa%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();



        $query = "SELECT a.id_rek_gl, a.descriptions
                FROM master.mrek_gl a
                WHERE a.isdetail='1'
                AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredValCoa%')
                ORDER BY a.id_rek_gl ASC 
                LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }


    public function getCCProject()
    {


        $query = "SELECT id_cc_project, cc_project_name,
                         (CASE WHEN isproject='1' THEN 'Project'
                               else 'Cost Center'
                          END)::varchar(30) as jenis   
                    FROM master.mcc_project 
                    WHERE isactive='1'
                    ORDER BY id_cc_project ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }



    public function getCoaDetail()
    {
        $query = "SELECT a.id_rek_gl, a.descriptions
                FROM master.mrek_gl a
                WHERE a.isdetail='1'
                ORDER BY a.id_rek_gl ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getRekanan()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis
                    FROM master.mrekanan a
                    WHERE 1=1
                    ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }
}

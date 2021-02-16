<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Nsaldo_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }


    public function getNsaldo()
    {

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);



        $query = "SELECT a.*, 
                        (a.awal_debet+a.debet_berjalan) as akhir_debet,
                        (a.awal_kredit+a.kredit_berjalan) as akhir_kredit,
                        (a.saldo_awal+a.saldo_mutasi) as saldo_akhir
                FROM accfin.get_trial_balance('" . $dt_awal . "','" . $dt_akhir . "') a
                WHERE 1=1
                ORDER BY a.id_rek_gl ASC";

        $data_x = $this->db->query($query);

        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['awal_debet'] = tegar_num($row['awal_debet']);
            $row['awal_kredit'] = tegar_num($row['awal_kredit']);
            $row['saldo_awal'] = tegar_num($row['saldo_awal']);
            $row['debet_berjalan'] = tegar_num($row['debet_berjalan']);
            $row['kredit_berjalan'] = tegar_num($row['kredit_berjalan']);
            $row['saldo_mutasi'] = tegar_num($row['saldo_mutasi']);
            $row['akhir_debet'] = tegar_num($row['akhir_debet']);
            $row['akhir_kredit'] = tegar_num($row['akhir_kredit']);
            $row['saldo_akhir'] = tegar_num($row['saldo_akhir']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;



        //get total


        $qrT = "SELECT  
                        SUM(a.awal_debet) as tawal_debet,  
                        SUM(a.awal_kredit) as tawal_kredit,  
                        SUM(a.saldo_awal) as tsaldo_awal,  
                        SUM(a.debet_berjalan) as tdebet_berjalan,  
                        SUM(a.kredit_berjalan) as tkredit_berjalan,  
                        SUM(a.saldo_mutasi) as tsaldo_mutasi,  
                        SUM((a.awal_debet+a.debet_berjalan)) as takhir_debet,
                        SUM((a.awal_kredit+a.kredit_berjalan)) as takhir_kredit,
                        SUM((a.saldo_awal+a.saldo_mutasi)) as tsaldo_akhir
                FROM accfin.get_trial_balance('" . $dt_awal . "','" . $dt_akhir . "') a
                WHERE 1=1";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['rekening'] = "TOTAL";
            $row['awal_debet'] = tegar_num($row['tawal_debet']);
            $row['awal_kredit'] = tegar_num($row['tawal_kredit']);
            $row['saldo_awal'] = tegar_num($row['tsaldo_awal']);
            $row['debet_berjalan'] = tegar_num($row['tdebet_berjalan']);
            $row['kredit_berjalan'] = tegar_num($row['tkredit_berjalan']);
            $row['saldo_mutasi'] = tegar_num($row['tsaldo_mutasi']);
            $row['akhir_debet'] = tegar_num($row['takhir_debet']);
            $row['akhir_kredit'] = tegar_num($row['takhir_kredit']);
            $row['saldo_akhir'] = tegar_num($row['tsaldo_akhir']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        return $result;
    }

    public function getCoa()
    {
        $query = "SELECT id_rek_gl, descriptions
                    FROM master.mrek_gl 
                    WHERE isdetail='1'
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getMBukuBesar($f)
    {

        list($ptgl0, $ptgl1, $pid_rek_gl) = explode('_', $f);

        $ptgl0 = str_replace('-', '/', $ptgl0);
        $ptgl1 = str_replace('-', '/', $ptgl1);

        // var_dump($ptgl0);
        // var_dump($ptgl1);
        // var_dump($pid_rek_gl);
        // die;


        $query = "SELECT a.id_rek_gl, a.descriptions as nama_rekening,
        COALESCE((SELECT coalesce(sum(b.debet-b.kredit),0)  
            FROM accfin.memorial b 
            WHERE b.id_rek_gl=a.id_rek_gl 
                AND b.dt_memorial<to_timestamp('" . $ptgl0 . "','dd/mm/yyyy')),0) as awal,
        COALESCE((SELECT coalesce(sum(b.debet-b.kredit),0)  
            FROM accfin.memorial b
            WHERE b.id_rek_gl=a.id_rek_gl 
                 AND b.dt_memorial between to_timestamp('" . $ptgl0 . "','dd/mm/yyyy') 
                 AND to_timestamp('" . $ptgl1 . "','dd/mm/yyyy') +  interval '23 hours 59 min' ),0) as berjalan,

        (COALESCE((SELECT coalesce(sum(b.debet-b.kredit),0)  
            FROM accfin.memorial b 
            WHERE b.id_rek_gl=a.id_rek_gl 
                AND b.dt_memorial<to_timestamp('" . $ptgl0 . "','dd/mm/yyyy')),0) +
        COALESCE((SELECT coalesce(sum(b.debet-b.kredit),0)  
            FROM accfin.memorial b
            WHERE b.id_rek_gl=a.id_rek_gl 
                 AND b.dt_memorial between to_timestamp('" . $ptgl0 . "','dd/mm/yyyy') AND to_timestamp('" . $ptgl1 . "','dd/mm/yyyy') +  interval '23 hours 59 min' ),0)) as akhir 
                                  
        FROM master.mrek_gl a
        WHERE a.id_rek_gl='" . $pid_rek_gl . "'";

        $data_x = $this->db->query($query);

        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['awal'] = tegar_num($row['awal']);
            $row['berjalan'] = tegar_num($row['berjalan']);
            $row['akhir'] = tegar_num($row['akhir']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;


        // $result = array();
        // $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getDBukuBesar($d)
    {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'dt_memorial';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $offset = ($page - 1) * $rows;
        //            isset($_POST['pnsaldo']) ? pg_escape_string($_POST['pnsaldo']) : '';

        list($ptgl0, $ptgl1, $pid_rek_gl) = explode('_', $d);

        $ptgl0 = str_replace('-', '/', $ptgl0);
        $ptgl1 = str_replace('-', '/', $ptgl1);


        $qrM = "SELECT a.*
                FROM accfin.memorial a
                WHERE a.id_rek_gl='" . $pid_rek_gl . "' AND
                        a.dt_memorial between 
                            to_timestamp('" . $ptgl0 . "','dd/mm/yyyy') and 
                            to_timestamp('" . $ptgl1 . "','dd/mm/yyyy') +  interval '23 hours 59 min'";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT 
                    a.no_jurnal, 
                    a.no_bukti, 
                    a.no_nota, 
                    to_char(a.dt_memorial,'dd-mm-yyyy') as dt_memorial, 
                    a.id_cc_project, 
                    a.descriptions, 
                    a.debet, 
                    a.kredit, 
                    b.nama_rekanan
                FROM accfin.memorial a
                LEFT JOIN master.mrekanan b on b.kd_rekanan=a.kd_rekanan
                WHERE a.id_rek_gl='" . $pid_rek_gl . "' AND
                        a.dt_memorial between 
                            to_timestamp('" . $ptgl0 . "','dd/mm/yyyy') and 
                            to_timestamp('" . $ptgl1 . "','dd/mm/yyyy') +  interval '23 hours 59 min' 
                ORDER BY $sort $order
                LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);

        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['debet'] = tegar_num($row['debet']);
            $row['kredit'] = tegar_num($row['kredit']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total
        $qrT = "SELECT  
                SUM(a.debet) as tdebet,  
                SUM(a.kredit) as tkredit  
                FROM accfin.memorial a
                WHERE a.id_rek_gl='" . $pid_rek_gl . "' AND
                        a.dt_memorial between 
                            to_timestamp('" . $ptgl0 . "','dd/mm/yyyy') and 
                            to_timestamp('" . $ptgl1 . "','dd/mm/yyyy') +  interval '23 hours 59 min' ";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['descriptions'] = "TOTAL";
            $row['debet'] = tegar_num($row['tdebet']);
            $row['kredit'] = tegar_num($row['tkredit']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;
        return $result;
    }


    public function getJkontrol($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'b.no_jurnal';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $offset = ($page - 1) * $rows;

        list($dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);

        // $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        // $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        // $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $dt_awal = str_replace('-', '/', $dt_awal);
        $dt_akhir = str_replace('-', '/', $dt_akhir);




        $qrM = "SELECT b.*
                FROM accfin.memorial b
                WHERE b.no_jurnal!='SYS-THN' AND 
                    b.dt_memorial between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') 
                    +  interval '23 hours 59 min'
                AND  concat(upper(b.no_jurnal),'',upper(b.no_bukti),'',upper(b.descriptions)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_rek_gl, 
                        a.descriptions as nama_rekening, 
                        b.descriptions as remarks, 
                        b.id_arus,
                        to_char(b.dt_memorial,'DD-Mon-YYYY') as dt_memorial, 
                        b.no_jurnal, 
                        b.debet, 
                        b.kredit, 
                        b.no_bukti, 
                        b.id_cc_project, 
                        b.no_payment, 
                        b.kd_rekanan
                    FROM accfin.memorial b
                    LEFT JOIN master.mrek_gl a on a.id_rek_gl=b.id_rek_gl
                    WHERE b.no_jurnal!='SYS-THN' 
                        AND b.dt_memorial between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                        AND  concat(upper(b.no_jurnal),'',upper(b.no_bukti),'',upper(b.descriptions)) like upper('%$getFilteredVal%') 
                    ORDER BY $sort $order
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['debet'] = tegar_num($row['debet']);
            $row['kredit'] = tegar_num($row['kredit']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total
        $qrT = "SELECT  
                SUM(b.debet) as tdebet,  
                SUM(b.kredit) as tkredit  
                FROM accfin.memorial b
                WHERE b.no_jurnal!='SYS-THN' 
                        AND b.dt_memorial between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                        AND  concat(upper(b.no_jurnal),'',upper(b.no_bukti),'',upper(b.descriptions)) like upper('%$getFilteredVal%') ";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['remarks'] = "TOTAL";
            $row['debet'] = tegar_num($row['tdebet']);
            $row['kredit'] = tegar_num($row['tkredit']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;


        return $result;
    }

    public function getUjurnal($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'z.no_jurnal';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $offset = ($page - 1) * $rows;

        list($dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);

        $dt_awal = str_replace('-', '/', $dt_awal);
        $dt_akhir = str_replace('-', '/', $dt_akhir);

        $qrM = "SELECT z.*, t.description as nama_transaksi
                FROM
                (SELECT a.no_jurnal, a.id_trans, 
                        CAST(sum(a.debet) AS numeric(17,2)) as sdebet, 
                        CAST(sum(a.kredit) AS numeric(17,2)) as skredit
                FROM accfin.memorial a
                WHERE a.id_trans!='509' and a.no_jurnal!='SYS-THN' 
                    AND a.dt_memorial BETWEEN to_timestamp('" . $dt_awal . "','dd-mm-yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd-mm-yyyy') +  INTERVAL '23 hours 59 min'
                GROUP BY a.no_jurnal, a.id_trans
                ) as z
                LEFT JOIN master.mtransaction t on t.id_trans=z.id_trans
                WHERE z.sdebet!=z.skredit";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT z.*, 
                        (coalesce(z.sdebet,0)-coalesce(z.skredit,0))::numeric(17,2) as selisih,
                        t.description as nama_transaksi
                    FROM
                    (SELECT a.no_jurnal, a.id_trans, 
                            CAST(sum(a.debet) AS numeric(17,2)) as sdebet, 
                            CAST(sum(a.kredit) AS numeric(17,2)) as skredit
                    FROM accfin.memorial a
                    WHERE a.id_trans!='509' and a.no_jurnal!='SYS-THN' 
                        AND a.dt_memorial BETWEEN to_timestamp('" . $dt_awal . "','dd-mm-yyyy') 
                            AND to_timestamp('" . $dt_akhir . "','dd-mm-yyyy') +  INTERVAL '23 hours 59 min'
                    GROUP BY a.no_jurnal, a.id_trans
                    ) as z
                    LEFT JOIN master.mtransaction t on t.id_trans=z.id_trans
                    WHERE z.sdebet!=z.skredit
                    ORDER BY $sort $order
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['sdebet'] = tegar_num($row['sdebet']);
            $row['skredit'] = tegar_num($row['skredit']);
            $row['selisih'] = tegar_num($row['selisih']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total
        $qrT = "SELECT SUM(z.sdebet) as tsdebet,
                       SUM(z.skredit) as tskredit, 
                       SUM((coalesce(z.sdebet,0)-coalesce(z.skredit,0)))::numeric(17,2) as tselisih
                FROM
                (SELECT a.no_jurnal,
                        CAST(sum(a.debet) AS numeric(17,2)) as sdebet, 
                        CAST(sum(a.kredit) AS numeric(17,2)) as skredit
                FROM accfin.memorial a
                WHERE a.id_trans!='509' and a.no_jurnal!='SYS-THN' 
                    AND a.dt_memorial BETWEEN to_timestamp('" . $dt_awal . "','dd-mm-yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd-mm-yyyy') +  INTERVAL '23 hours 59 min'
                GROUP BY a.no_jurnal
                ) as z
                WHERE z.sdebet!=z.skredit ";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['no_jurnal'] = "TOTAL";
            $row['sdebet'] = tegar_num($row['tsdebet']);
            $row['skredit'] = tegar_num($row['tskredit']);
            $row['selisih'] = tegar_num($row['tselisih']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;


        return $result;
    }


    public function getUjurnalDetail($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'b.no_jurnal';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $offset = ($page - 1) * $rows;

        list($mjno, $dt_awal, $dt_akhir) = explode('_', $idx);

        $dt_awal = str_replace('-', '/', $dt_awal);
        $dt_akhir = str_replace('-', '/', $dt_akhir);

        $qrM = "SELECT a.* 
                FROM accfin.memorial a
                WHERE a.no_jurnal='" . $mjno . "' 
                    AND a.dt_memorial BETWEEN to_timestamp('" . $dt_awal . "','dd-mm-yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd-mm-yyyy') +  INTERVAL '23 hours 59 min'";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_rek_gl, 
                            a.descriptions as nama_rekening, 
                            b.descriptions as remarks, 
                            b.id_arus,
                            to_char(b.dt_memorial,'DD-Mon-YYYY') as dt_memorial, 
                            b.no_jurnal, 
                            b.debet, 
                            b.kredit, 
                            b.no_bukti, 
                            b.id_cc_project, 
                            b.no_payment, 
                            b.kd_rekanan
                        FROM accfin.memorial b
                        LEFT JOIN master.mrek_gl a on a.id_rek_gl=b.id_rek_gl
                        WHERE b.no_jurnal='" . $mjno . "' 
                            AND b.dt_memorial between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') 
                            AND to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                        ORDER BY $sort $order
                        LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['debet'] = tegar_num($row['debet']);
            $row['kredit'] = tegar_num($row['kredit']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total
        $qrT = "SELECT  
                SUM(b.debet) as tdebet,  
                SUM(b.kredit) as tkredit  
                FROM accfin.memorial b
                WHERE b.no_jurnal='" . $mjno . "' 
                        AND b.dt_memorial between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') 
                        AND to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['remarks'] = "TOTAL";
            $row['debet'] = tegar_num($row['tdebet']);
            $row['kredit'] = tegar_num($row['tkredit']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;


        return $result;
    }
}

<?php

class Posting_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    private function getTransNo($url)
    {
        $qTrans = $this->db->get_where('master.menu_web', ['url_active' => $url])->row_array();
        $noTrans = $qTrans['id_trans'];
        return $noTrans;
    }

    public function getSettlement($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);
        $idTrans = $this->getTransNo($ix);



        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM accfin.settlement a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' and a.id_trans='" . $idTrans . "'
                AND a.dt_settlement::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_settlement),'',upper(a.no_kasbon)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_settlement,
                        to_char(a.dt_settlement,'dd-Mon-yyyy') as dt_settlement, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.no_settlement,
                        a.kd_rekanan,
                        a.remarks,
                        a.id_cc_project,
                        a.total,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel,
                        a.lebih_kurang,
                        mr.nama_rekanan

                    FROM accfin.settlement a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $idTrans . "'
                    AND a.dt_settlement::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_settlement),'',upper(a.no_kasbon)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_settlement ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postSettlement($p)
    {

        $data = $this->input->post('info', true);

        // var_dump($data);
        // die;

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.settlement SET
                ispost = '" . $p . "',
                dt_post = null, 
                usr_post = null
                where id_settlement =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.settlement SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where id_settlement =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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


    public function getPayment($idx)
    {



        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);
        $idTrans = $this->getTransNo($ix);



        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM accfin.payment a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' and a.id_trans='" . $idTrans . "'
                AND a.dt_payment::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_payment)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_payment,
                        to_char(a.dt_payment,'dd-Mon-yyyy') as dt_payment, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.no_payment,
                        a.kd_rekanan,
                        a.no_cek_bg_tt,
                        a.jns_ttbg,
                        a.remarks,
                        a.nominal,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel,
                        mr.nama_rekanan
                    FROM accfin.payment a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $idTrans . "'
                    AND a.dt_payment::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_payment)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_payment ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['nominal'] = tegar_num($row['nominal']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postPayment($p)
    {

        $data = $this->input->post('info', true);

        // var_dump($data);
        // die;

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.payment SET
                ispost = '" . $p . "',
                dt_post = NULL, 
                usr_post = NULL'
                where id_payment =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.payment SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where id_payment =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }

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



    public function getMemorial($idx)
    {



        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);
        $idTrans = $this->getTransNo($ix);



        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM accfin.jurnal a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' and a.id_trans='" . $idTrans . "'
                AND a.dt_jurnal::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_jurnal),'',upper(a.remark)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_jurnal,
                        to_char(a.dt_jurnal,'dd-Mon-yyyy') as dt_payment, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.no_jurnal,
                        a.kd_rekanan,
                        a.remark as remarks,
                        a.debet as nominal,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel,
                        mr.nama_rekanan
                    FROM accfin.jurnal a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $idTrans . "'
                    AND a.dt_jurnal::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_jurnal),'',upper(a.remark)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_jurnal ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['nominal'] = tegar_num($row['nominal']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postMemorial($p)
    {

        $data = $this->input->post('info', true);

        // var_dump($data);
        // die;

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.jurnal SET
                ispost = '" . $p . "',
                dt_post = null, 
                usr_post = null
                where id_jurnal =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE accfin.jurnal SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where id_jurnal =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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


    public function getAr($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);
        $idTrans = $this->getTransNo($ix);



        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM sales.sales_invoice a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' and a.id_trans='" . $idTrans . "'
                AND a.dt_sales_invoice::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_sales_invoice),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_sales_invoice,
                        to_char(a.dt_sales_invoice,'dd-Mon-yyyy') as dt_sales_invoice, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.no_sales_invoice,
                        a.kd_rekanan,
                        a.remarks,
                        a.id_cc_project,
                        a.total,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel,
                        mr.nama_rekanan
                    FROM sales.sales_invoice a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $idTrans . "'
                    AND a.dt_sales_invoice::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_sales_invoice),'',upper(a.remarks)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_sales_invoice ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postAr($p)
    {

        $data = $this->input->post('info', true);

        // var_dump($data);
        // die;

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE sales.sales_invoice SET
                ispost = '" . $p . "',
                dt_post = null, 
                usr_post = null
                where id_sales_invoice =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE sales.sales_invoice SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where id_sales_invoice =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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


    public function getPr($idx)
    {



        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*
                FROM purchasing.pr a 
                WHERE a.isdelete='0' 
                AND a.dt_pr::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(a.requester),'',upper(a.no_pr),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_pr,
                        to_char(a.dt_pr,'dd-Mon-yyyy') as dt_pr, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.no_pr,
                        a.requester,
                        a.remarks,
                        a.id_cc_project,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel
                    FROM purchasing.pr a 
                    WHERE a.isdelete='0' 
                    AND a.dt_pr::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(a.requester),'',upper(a.no_pr),'',upper(a.remarks)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_pr ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postPr($p)
    {

        $data = $this->input->post('info', true);

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.pr SET
                ispost = '" . $p . "',
                dt_post = NULL, 
                usr_post = NULL
                where kd_pr =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.pr SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where kd_pr =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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


    public function getPo($idx)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM purchasing.po a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' 
                AND a.po_date::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.po_number),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_po,
                        to_char(a.po_date,'dd-Mon-yyyy') as po_date, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.po_number,
                        a.kd_rekanan,
                        mr.nama_rekanan,
                        a.total,
                        a.remarks,
                        a.id_cc_project,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel
                    FROM purchasing.po a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' 
                    AND a.po_date::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.po_number),'',upper(a.remarks)) like upper('%$getFilteredVal%') 
                    ORDER BY a.po_number ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postPo($p)
    {

        $data = $this->input->post('info', true);

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.po SET
                ispost = '" . $p . "',
                dt_post = null, 
                usr_post = null
                where kd_po =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.po SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where kd_po =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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

    public function getAp($idx)
    {



        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        list($ix, $dt_awal, $dt_akhir, $getFilteredVal) = explode('_', $idx);

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM purchasing.acc_payable a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' 
                AND a.dt_ap::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.ap_number),'',upper(a.invoice_no)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_ap,
                        to_char(a.dt_ap,'dd-Mon-yyyy') as dt_ap, 
                        to_char(a.dt_post,'dd-Mon-yyyy HH24:MI:SS') as dt_post, 
                        a.ap_number,
                        a.invoice_no,
                        a.kd_rekanan,
                        mr.nama_rekanan,
                        a.total,
                        a.commentar as remarks,
                        a.id_cc_project,
                        a.usr_ins,
                        a.usr_upd,
                        a.usr_post,
                        a.ispost,
                        a.iscancel
                    FROM purchasing.acc_payable a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' 
                    AND a.dt_ap::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.ap_number),'',upper(a.invoice_no)) like upper('%$getFilteredVal%') 
                    ORDER BY a.ap_number ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query);
        $rows = array();
        // $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        return $result;
    }



    public function postAp($p)
    {

        $data = $this->input->post('info', true);

        // var_dump($data);
        // die;

        $qrD = '';
        $sQL = '';
        $Count  = count($data);
        if ($p == '0') {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.acc_payable SET
                ispost = '" . $p . "',
                dt_post = NULL, 
                usr_post = NULL
                where kd_ap =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        } else {
            for ($x = 0; $x <= $Count - 1; $x++) {
                $sQL = "UPDATE purchasing.acc_payable SET
                ispost = '" . $p . "',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where kd_ap =" . $data[$x]['no'] . ";";
                $qrD = $qrD . $sQL;
            }
        }


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

<?php

class Ap_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getAp($id_trans)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                    FROM purchasing.acc_payable a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $id_trans . "'
                    AND a.dt_ap::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.ap_number),'',upper(a.invoice_no)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_ap, 
                            a.ap_number, 
                            to_char(a.dt_ap, 'DD-Mon-YYYY') as dt_ap,
                            to_char(a.dt_ap, 'dd/mm/yyyy') as dt_ap_char,
                            to_char(a.dt_jth_tempo, 'dd/mm/yyyy') as dt_jth_tempo,
                            to_char(a.dt_invoice, 'dd/mm/yyyy') as dt_invoice,
                            a.kd_rekanan, 
                            mr.nama_rekanan, 
                            a.commentar,
                            a.invoice_no,
                            a.ordering_no,
                            a.id_cc_project,
                            a.inv_amount,
                            a.po_balance,
                            a.total_mrir,
                            a.id_rek_gl,
                            a.id_rek_gl_debet,
                            a.id_curr,
                            a.kurs,
                            a.bank,
                            a.nama_akun,
                            a.usr_ins,
                            a.usr_upd,
                            a.ispost, 
                            a.iscancel,
                            a.vat_pr,
                            a.vat_rp,
                            a.id_rek_gl_vat,
                            a.wht_rp,
                            a.id_rek_gl_wht,
                            a.id_rek_gl_dp
                    FROM purchasing.acc_payable a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' AND a.id_trans='" . $id_trans . "'
                    AND a.dt_ap::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.ap_number),'',upper(a.invoice_no)) like upper('%$getFilteredVal%') 
                    ORDER BY a.ap_number ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }

    public function getPoData($idd)
    {

        $query = "SELECT    0::integer as kd_ap, 
                            0::integer as kd_ap_detail, 
                            a.kd_item, 
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            a.extended as sub_total,
                            a.extended
                    FROM purchasing.po_details a
                    JOIN purchasing.po b ON b.kd_po=a.kd_po
                    WHERE b.po_number= '" . $idd . "'
                    ORDER BY a.kd_po_detail ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();

        //$result  = $this->db->get_where('accfin.jurnal_detail', ['id_jurnal' => $idd])->row_array();
        return $result;
    }

    public function getApDetail($idd)
    {

        $query = "SELECT    a.kd_ap, 
                            a.kd_ap_detail, 
                            a.kd_item, 
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            (a.qty*a.unit_price)::numeric(17,2) as sub_total,
                            (a.qty*a.unit_price)::numeric(17,2) as extended
                    FROM purchasing.acc_payable_detail a
                    WHERE a.kd_ap= $idd
                    ORDER BY a.kd_ap_detail ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();

        //$result  = $this->db->get_where('accfin.jurnal_detail', ['id_jurnal' => $idd])->row_array();
        return $result;
    }



    public function fetchApDetail($idd)
    {

        $query = "SELECT    a.kd_ap, 
                            a.kd_ap_detail,
                            a.kd_item,
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            (a.qty*a.unit_price)::numeric(17,2) as extended
                    FROM purchasing.acc_payable_detail a
                    WHERE a.kd_ap= $idd
                    ORDER BY a.kd_ap_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();
        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['extended'] = tegar_num($row['extended']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM((qty*unit_price)) AS total
                FROM purchasing.acc_payable_detail
                WHERE kd_ap=" . $idd . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['unit_price'] = "TOTAL";
            $row['extended'] = tegar_num($row['total']);
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


    public function saveAp()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_ap'], 3, 2));
        $vyy = trim(substr($datmaster['dt_ap'], 6, 4));

        // var_dump($datmaster);
        // die;

        //get no_trans
        $rNo = $this->db->get("purchasing.fn_gen_ap_number('" . $datmaster['notrans'] . "','" . $vmm . "','" . $vyy . "') as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('purchasing.sq_ap');

        if ($datmaster['id_rek_gl_dp'] == '') {
            $id_rek_dp = "NULL";
        } else {
            $id_rek_dp = "'" . $datmaster['id_rek_gl_dp'] . "'";
        };

        if ($datmaster['id_rek_gl_wht'] == '') {
            $id_rek_wht = "NULL";
        } else {
            $id_rek_wht = "'" . $datmaster['id_rek_gl_wht'] . "'";
        };


        //build query insert master
        $qrM = "INSERT INTO purchasing.acc_payable (
         kd_ap, ap_number, kd_rekanan,
         dt_ap, dt_received, 
         dt_to_finance, commentar, ordering_no, id_cc_project,
         po_balance,  invoice_no, dt_invoice, 
         dt_jth_tempo, isinvoice, isfaktur, isporir, ismrir, is_po_copy, iscertificate_prog, isother,
         cc_number, cc_comment, vat_pr, vat_rp, wht_pr, 
         wht_rp, usr_ins, usr_upd, 
        is_mc_related, is_non_mc_related, inv_amount, id_curr, kurs, prepared_by,
        isproject, isreceived, ispost, iscancel, isdelete, isclosed, id_trans, id_rek_gl_debet,
        bank, nama_akun, id_rek_gl_vat, id_rek_gl_wht, 
        total, id_rek_gl_dp, id_rek_gl,
        kd_pi, kd_pi_dp, total_mrir)
         VALUES (
          $id, '" . $no_trans . "','" . $datmaster['kd_rekanan'] . "',
          to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'), to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'),
          to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'), '" . $datmaster['commentar'] . "', NULL,'" . $datmaster['id_cc_project'] . "',
          " . $datmaster['po_balance'] . ", '" . $datmaster['invoice_no'] . "', to_timestamp('" . $datmaster['dt_invoice'] . "','dd/mm/yyyy'),
         to_timestamp('" . $datmaster['dt_jth_tempo'] . "','dd/mm/yyyy'), '0', '0', '0', '0', '0', '0', '0',
         '" . $datmaster['id_cc_project'] . "', '-', " . $datmaster['vat_pr'] . ",  " . $datmaster['vat_rp'] . ", 0,
         " . $datmaster['wht_rp'] . ",  '" . $this->session->userdata('username') . "',  '" . $this->session->userdata('username') . "',
         '0', '0', " . $datmaster['inv_amount'] . ", '" . $datmaster['id_curr'] . "'," . $datmaster['kurs'] . ", '" . $this->session->userdata('username') . "',
         '0', '0', '0', '0', '0', '0', '" . $datmaster['notrans'] . "', '" . $datmaster['id_rek_gl_debet'] . "',
         '" . $datmaster['bank'] . "', '" . $datmaster['nama_akun'] . "', '" . $datmaster['id_rek_gl_vat'] . "', " . $id_rek_wht . ",
         " . $datmaster['inv_amount'] . "," . $id_rek_dp . " , '" . $datmaster['id_rek_gl'] . "',
         '" . $vmm . "','" . $vyy . "'," . $datmaster['total_mrir'] . ");";

        // var_dump($qrM);
        // die;

        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('purchasing.sq_ap_detail');
            $sQL = "INSERT INTO purchasing.acc_payable_detail
                    (
                        nomor,
                        kd_ap,
                        kd_ap_detail,
                        kd_pr_detail,
                        kd_item,
                        descriptions,
                        kd_satuan,
                        id_rek_gl,
                        id_cc_project,
                        qty,
                        unit_price)
                    VALUES
                    (
                        $n,
                        $id,
                        $idd,
                        0,
                        '" . $datdetail[$x]['kd_item'] . "',
                        '" . $datdetail[$x]['descriptions'] . "',
                        '" . $datdetail[$x]['kd_satuan'] . "',
                        '" . $datmaster['id_rek_gl_debet'] . "',
                        '" . $datmaster['id_cc_project'] . "',
                        " . $datdetail[$x]['qty'] . ",
                        " . $datdetail[$x]['unit_price'] . ");        
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
        if ($hasil) {
            $this->_ispost($id);
        } else {
            return $hasil;
        }
    }


    public function editAp($id)
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_ap'], 3, 2));
        $vyy = trim(substr($datmaster['dt_ap'], 6, 4));

        // var_dump($datdetail);
        // die;
        if ($datmaster['id_rek_gl_dp'] == '') {
            $id_rek_dp = "NULL";
        } else {
            $id_rek_dp = "'" . $datmaster['id_rek_gl_dp'] . "'";
        };

        if ($datmaster['id_rek_gl_wht'] == '') {
            $id_rek_wht = "NULL";
        } else {
            $id_rek_wht = "'" . $datmaster['id_rek_gl_wht'] . "'";
        };


        //build query update master
        $qrM = "UPDATE purchasing.acc_payable SET
                dt_ap = to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'),
                dt_received = to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'),
                dt_to_finance = to_timestamp('" . $datmaster['dt_ap'] . "','dd/mm/yyyy'),
                dt_jth_tempo = to_timestamp('" . $datmaster['dt_jth_tempo'] . "','dd/mm/yyyy'),
                dt_invoice = to_timestamp('" . $datmaster['dt_invoice'] . "','dd/mm/yyyy'),
                id_curr = '" . $datmaster['id_curr'] . "',
                kurs =" . $datmaster['kurs'] . ",
                kd_rekanan ='" . $datmaster['kd_rekanan'] . "',
                commentar ='" . $datmaster['commentar'] . "',
                id_cc_project ='" . $datmaster['id_cc_project'] . "',
                invoice_no = '" . $datmaster['invoice_no'] . "',
                cc_number = '" . $datmaster['id_cc_project'] . "',
                bank= '" . $datmaster['bank'] . "', 
                nama_akun= '" . $datmaster['nama_akun'] . "',
                id_rek_gl_vat='" . $datmaster['id_rek_gl_vat'] . "',
                id_rek_gl_wht= " . $id_rek_wht . ", 
                id_rek_gl_dp= " . $id_rek_dp . ", 
                id_rek_gl= '" . $datmaster['id_rek_gl'] . "',
                vat_pr =" . $datmaster['vat_pr'] . ",
                vat_rp =" . $datmaster['vat_rp'] . ",
                wht_rp =" . $datmaster['wht_rp'] . ",
                inv_amount =" . $datmaster['inv_amount'] . ",
                total =" . $datmaster['inv_amount'] . ",
                usr_upd ='" . $this->session->userdata('username') . "',
                kd_pi='" . $vmm . "',
                kd_pi_dp = '" . $vyy . "',
                total_mrir = " . $datmaster['total_mrir'] . "
                WHERE kd_ap=" . $id . ";";


        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['kd_ap_detail']) == '0') {
                $n = $n + 1;
                $idd = $this->getTransid('purchasing.sq_ap_detail');
                $sQL = "INSERT INTO purchasing.acc_payable_detail
                                (   nomor,
                                    kd_ap,
                                    kd_ap_detail,
                                    kd_pr_detail,
                                    kd_item,
                                    descriptions,
                                    kd_satuan,
                                    id_rek_gl,
                                    id_cc_project,
                                    qty,
                                    unit_price)
                                VALUES
                                (   $n,
                                    $id,
                                    $idd,
                                    0,
                                    '" . $datdetail[$x]['kd_item'] . "',
                                    '" . $datdetail[$x]['descriptions'] . "',
                                    '" . $datdetail[$x]['kd_satuan'] . "',
                                    '" . $datmaster['id_rek_gl_debet'] . "',
                                    '" . $datmaster['id_cc_project'] . "',
                                    " . $datdetail[$x]['qty'] . ",
                                    " . $datdetail[$x]['unit_price'] . ");        
                                ";
            } else {
                $idd =  $datdetail[$x]['kd_ap_detail'];

                $sQL = "UPDATE purchasing.acc_payable_detail SET 
                                    kd_item = '" . $datdetail[$x]['kd_item'] . "',
                                    descriptions = '" . $datdetail[$x]['descriptions'] . "',
                                    kd_satuan = '" . $datdetail[$x]['kd_satuan'] . "',
                                    id_rek_gl = '" . $datmaster['id_rek_gl_debet'] . "',
                                    id_cc_project = '" . $datmaster['id_cc_project'] . "',
                                    qty =  " . $datdetail[$x]['qty'] . ",
                                    unit_price = " . $datdetail[$x]['unit_price'] . " 
                                WHERE kd_ap_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT kd_ap_detail AS idd
                        FROM purchasing.acc_payable_detail
                        WHERE kd_ap=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'kd_ap_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from purchasing.acc_payable_detail
                                WHERE kd_ap_detail=" . $row['idd'] . ";";
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
        if ($hasil) {
            $this->_ispost($id);
        } else {
            return $hasil;
        }
    }

    private function _ispost($id)
    {
        $qrP =  "UPDATE purchasing.acc_payable
                    SET ispost='1',
                        usr_post='" . $this->session->userdata('username') . "',
                        dt_post= now()
                WHERE kd_ap=" . $id . ";";

        $this->db->trans_begin();
        $this->db->query($qrP);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function deleteAp($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('kd_ap', $id);
        $this->db->set($data);
        $hasil = $this->db->update('purchasing.acc_payable');
        return $hasil;
    }

    public function getCoa_ap($j)
    {
        if ($j == 'ap') {
            $where_str = "id_parent='2010'";
        } elseif ($j == 'vat') {
            $where_str = "id_rek_gl='1555'";
        } elseif ($j == 'wht') {
            $where_str = "id_rek_gl>'2120' and id_rek_gl<'2130'";
        } elseif ($j == 'dp') {
            $where_str = "id_parent='1500'";
        } elseif ($j == 'debet') {
            $where_str = "id_parent='1610' or (id_rek_gl>'1750' and id_rek_gl<'1760')";
        }


        $query = "SELECT id_rek_gl, descriptions
                    FROM master.mrek_gl
                    WHERE isdetail='1' 
                    AND " . $where_str . "
                    order by id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getPoRef($r)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredValPo = !is_null($this->input->post('searching_po')) ? $this->input->post('searching_po') : '';


        $qrM = "SELECT a.*
                FROM purchasing.fn_look_po_notyet_ap('" . $r . "') a
                WHERE 1=1
                AND  concat(upper(a.po_number)) like upper('%$getFilteredValPo%') ";


        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT    a.* 
                            FROM purchasing.fn_look_po_notyet_ap('" . $r . "') a
                            WHERE 1=1
                            AND  concat(upper(a.po_number)) like upper('%$getFilteredValPo%')  
                    ORDER BY a.po_number ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }

    public function getItem()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredValItem = !is_null($this->input->post('searching_item')) ? $this->input->post('searching_item') : '';


        $qrM = "SELECT a.*, t.item_type_name
                FROM master.mitem a
                LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                WHERE 1=1
                AND  concat(upper(a.kd_item),'',upper(a.nama_item),'',upper(t.item_type_name)) like upper('%$getFilteredValItem%') ";


        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT    a.kd_item, 
                            a.nama_item,
                            a.kd_satuan,
                            a.kd_satuan_beli,
                            a.item_type_id,
                            t.item_type_name
                    FROM master.mitem a
                    LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                    WHERE 1=1 
                    AND  concat(upper(a.kd_item),'',upper(a.nama_item),'',upper(t.item_type_name)) like upper('%$getFilteredValItem%') 
                    ORDER BY a.kd_item ASC
                    LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }
}

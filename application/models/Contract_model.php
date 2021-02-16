<?php

class Contract_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
        $this->load->helper('date_id');
    }

    public function getContract()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        // var_dump($dt_akhir);
        // die;


        $qrM = "SELECT a.*
                FROM sales.so a 
                WHERE a.isdelete='0'
                AND a.dt_so::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(a.kd_rekanan),'',upper(a.so_number),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_so,
                         to_char(a.dt_so,'dd-Mon-yyyy') as dt_so, 
                        to_char(a.dt_so,'dd/mm/yyyy') as dt_so_str,
                        a.so_number,
                        a.no_qt,
                        a.id_cc_project,
                        a.kd_rekanan,
                        mr.nama_rekanan,
                        a.cust_po_number,
                        a.vat_str,
                        a.sub_total,
                        a.vat_num,
                        a.total,
                        a.usr_ins,
                        a.usr_upd,
                        a.ispost,
                        a.iscancel,
                        a.isclosed,
                        a.remarks,
                        a.category
                    FROM sales.so a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0'
                    AND a.dt_so::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(a.kd_rekanan),'',upper(a.so_number),'',upper(a.remarks)) like upper('%$getFilteredVal%') 
                    ORDER BY a.so_number ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }



    public function getContractDetail($idd)
    {
        $query = "SELECT a.id_so,
                         a.id_so_detail,
                         a.kd_pi,
                         a.kd_item,
                         a.descriptions,
                         a.kd_satuan,
                         a.qty,
                         a.unit_price,
                         a.sub_total
                    FROM sales.so_detail a
                    WHERE a.id_so= " . $idd . "";
        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();


        foreach ($data_x->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['sub_total'] = tegar_num($row['sub_total']);
            array_push($rows, $row);
        }

        $result["rows"] = $rows;


        //get total

        $qrT = "SELECT SUM(sub_total) AS total
                FROM sales.so_detail
                WHERE id_so=" . $idd . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['unit_price'] = "TOTAL";
            $row['sub_total'] = tegar_num($row['total']);
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


    public function saveContract()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        // var_dump($datmaster);
        // die;

         $year = substr($datmaster['dt_so'], -4);
        // $rNo = $this->db->get('sales.fn_gen_so_number(' . $year . ') as new_no_trans ')->row_array();
        // $no_so = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('sales.sq_so');

        //build query insert master
        $qrM = "INSERT INTO sales.so (
            id_so, id_trans, so_number, dt_so, 
            kd_rekanan, cust_po_number, 
            prepared_by, vat_str,
            sub_total, vat_num, total,
            cara_bayar, remarks, status_auth,
            usr_ins, usr_upd,
            category, no_qt,
            dt_finish, manager, id_rek_gl, 
            id_cc_project, ispost,iscancel, isdelete, isclosed,
            tahun, lokasi)
         VALUES (
           " . $id . ", '" . $datmaster['idtrans'] . "','" . $datmaster['so_number'] . "', to_timestamp('" . $datmaster['dt_so'] . "','dd-mm-yyyy'),
           '" . $datmaster['kd_rekanan'] . "', '" . $datmaster['cust_po_number'] . "',
           '" .  $this->session->userdata('username') . "', 'EXCLUDE',
           " . $datmaster['sub_total'] . ", " . $datmaster['vat_num'] . ", " . $datmaster['total'] . ",
           '" . $datmaster['cara_bayar'] . "','" . $datmaster['remarks'] . "', 'OPEN',
          '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', 
          '" . $datmaster['id_cat_project'] . "', '" . $datmaster['no_qt'] . "', 
          to_timestamp('" . $datmaster['dt_finish'] . "','dd-mm-yyyy'),'" . $datmaster['manager'] . "', '" . $datmaster['id_rek_gl'] . "', 
          '" . $datmaster['so_number'] . "', '0','0','0','0',
        " . $year . ", '" . $datmaster['lokasi'] . "' );";

        $qrD = '';
        // $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('sales.sq_so_detail');
            $sQL = "INSERT INTO sales.so_detail
                      (
                          id_so,
                          id_so_detail,
                          nomor,
                          kd_item,
                          descriptions,
                          kd_satuan,
                          qty,
                          unit_price,
                          sub_total,
                          hpp_price,
                          hpp_sub_total,
                          margin_psn)
                      VALUES
                      (
                          $id,
                          $idd,
                          $n,
                          '" . $datdetail[$x]['kd_item'] . "',
                          '" . $datdetail[$x]['descriptions'] . "',
                          '" . $datdetail[$x]['kd_satuan'] . "',
                          " . $datdetail[$x]['qty'] . ",
                          " . $datdetail[$x]['unit_price'] . ",
                          " . $datdetail[$x]['sub_total'] . ",
                          " . $datdetail[$x]['hpp_price'] . ",
                          " . $datdetail[$x]['hpp_sub_total'] . ",
                          " . $datdetail[$x]['margin_psn'] . "
                        );";
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

        // if ($hasil) {
        //     $this->_ispost($id);
        // } else {
        //     return $hasil;
        // }
    }


    public function editContract()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        // var_dump($datdetail);
        // die;
        $id = $datmaster['id_so'];

        $qrM = "UPDATE sales.so SET
                so_number =  '" . $datmaster['so_number'] . "',  
                dt_so = to_timestamp('" . $datmaster['dt_so'] . "','dd-mm-yyyy'), 
                dt_finish = to_timestamp('" . $datmaster['dt_finish'] . "','dd-mm-yyyy'), 
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                no_qt =  '" . $datmaster['no_qt'] . "', 
                prepared_by = '" .  $this->session->userdata('username') . "',
                cust_po_number = '" . $datmaster['cust_po_number'] . "',
                category = '" . $datmaster['id_cat_project'] . "',
                id_cc_project = '" . $datmaster['so_number'] . "',
                id_rek_gl = '" . $datmaster['id_rek_gl'] . "',
                sub_total = " . $datmaster['sub_total'] . ", 
                vat_num = " . $datmaster['vat_num'] . ", 
                total = " . $datmaster['total'] . ",
                sub_total_hpp = " . $datmaster['sub_total_hpp'] . ", 
                vat_num_hpp = " . $datmaster['vat_num_hpp'] . ", 
                total_hpp = " . $datmaster['total_hpp'] . ",
                cara_bayar = '" .  $datmaster['cara_bayar'] . "',
                remarks = '" .  $datmaster['remarks'] . "',
                manager = '" .  $datmaster['manager'] . "',
                lokasi = '" .  $datmaster['lokasi'] . "',
                usr_upd = '" .  $this->session->userdata('username') . "'
                WHERE id_so=" . $id . ";";

        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            if (($datdetail[$x]['id_so_detail']) == '0') {
                $idd = $this->getTransid('sales.sq_so_detail');
                $sQL = "INSERT INTO sales.so_detail
                         (id_so,
                          id_so_detail,
                          nomor,
                          kd_item,
                          descriptions,
                          kd_satuan,
                          qty,
                          unit_price,
                          sub_total,
                          hpp_price,
                          hpp_sub_total,
                          margin_psn)
                      VALUES
                      (
                          $id,
                          $idd,
                          $n,
                          '" . $datdetail[$x]['kd_item'] . "',
                          '" . $datdetail[$x]['descriptions'] . "',
                          '" . $datdetail[$x]['kd_satuan'] . "',
                          " . $datdetail[$x]['qty'] . ",
                          " . $datdetail[$x]['unit_price'] . ",
                          " . $datdetail[$x]['sub_total'] . ",
                          " . $datdetail[$x]['hpp_price'] . ",
                          " . $datdetail[$x]['hpp_sub_total'] . ",
                          " . $datdetail[$x]['margin_psn'] . "
                        );";
            } else {
                $idd =  $datdetail[$x]['id_so_detail'];

                $sQL = "UPDATE sales.so_detail SET 
                        nomor = " . $n . ",
                        kd_item = '" . $datdetail[$x]['kd_item'] . "',
                        descriptions = '" . $datdetail[$x]['descriptions'] . "',
                        kd_satuan = '" . $datdetail[$x]['kd_satuan'] . "',
                        qty =  " . $datdetail[$x]['qty'] . ",
                        unit_price = " . $datdetail[$x]['unit_price'] . ",
                        sub_total = " . $datdetail[$x]['sub_total'] . ",
                        hpp_price = " . $datdetail[$x]['hpp_price'] . ",
                        hpp_sub_total = " . $datdetail[$x]['hpp_sub_total'] . ",
                        margin_psn = " . $datdetail[$x]['margin_psn'] . "
                        WHERE id_so_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT id_so_detail AS idd
                        FROM sales.so_detail
                        WHERE id_so=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'id_so_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from sales.so_detail
                                WHERE id_so_detail=" . $row['idd'] . ";";
                $qrD = $qrD . $sQLX;
            }
        }

        // var_dump($qrM);
        // die;

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
        // if ($hasil) {
        //     $this->_ispost($id);
        // } else {
        //     return $hasil;
        // }
    }


    private function _ispost($id)
    {
        $qrP =  "UPDATE sales.so
                    SET ispost='1',
                        dt_post=now(),
                        usr_post='" . $this->session->userdata('username') . "',
                        usr_upd='" . $this->session->userdata('username') . "'
                WHERE id_so=" . $id . ";";

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


    public function deleteContract($id)
    {
        $data =  array(
            'isdelete' => '1',
            'usr_upd' =>  $this->session->userdata('username')
        );
        $this->db->where('id_so', $id);
        $this->db->set($data);
        $hasil = $this->db->update('sales.so');
        return $hasil;;
    }

    // cetak

    public function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

    public function getMCetak($id)
    {

        $qTotal = $this->db->get_where('sales.so', ['id_so' => $id])->row_array();
        $Total = $this->terbilang($qTotal['total']);

        // var_dump($Total);
        // var_dump($this->terbilang($Total));
        // die;

        $query = "SELECT a.id_qs,
                         to_char(a.dt_qs,'dd-Mon-yyyy') as dt_qs,
                         to_char(a.dt_qs,'dd-mm-yyyy') as dt_qs_char,  
                        a.no_qs, 
                        a.sub_total_quot,
                        a.vat_num_quot,
                        a.total_quot,
                        a.pterm,
                        a.id_curr,
                        a.remarks,
                        a.revision,
                        a.nama_rekanan,
                        a.proposal_description,
                        a.nama_kontak,
                        a.lampiran,
                        a.prepared_by,
                        a.checked_by,
                        ' '::varchar(255) as terbilang,
                        p.full_name as prepared_name,
                        p.full_name as checked_name
                    FROM sales.quote_sheet a 
                    LEFT JOIN master.vuser p ON p.vuser=a.prepared_by
                    LEFT JOIN master.vuser ap ON ap.vuser=a.approved_by
                    WHERE a.id_qs=" . $id . "; ";


        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['dt_qs_char'] = date_id($row['dt_qs_char']);
            $row['sub_total_quot'] = tegar_num($row['sub_total_quot']);
            $row['vat_num_quot'] = tegar_num($row['vat_num_quot']);
            $row['total_quot'] = tegar_num($row['total_quot']);
            $row['terbilang'] = strtoupper($Total . ' ' . $row['terbilang']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;
        return $result;
    }


    public function getDCetak($id)
    {

        $query = "SELECT    a.id_qs, 
                            a.id_unit,
                            a.descriptions,
                            a.part_number,
                            a.merk, 
                            a.remarks, 
                            a.qty,
                            a.quot_price,
                            a.quot_extended
                    FROM sales.quote_sheet_detail a
                    WHERE a.id_qs= $id 
                    ORDER BY a.id_qs_detail ASC";

        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['quot_price'] = tegar_num($row['quot_price']);
            $row['quot_extended'] = tegar_num($row['quot_extended']);
            array_push($rows, $row);
        }

        $result["rows"] = $rows;


        return $result;
    }


    public function getRCetak($id)
    {

        $query = "SELECT    a.nomor, 
                            a.descriptions
                    FROM sales.quote_sheet_remarks a
                    WHERE a.id_qs= $id 
                    ORDER BY a.nomor ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    // lookup

    public function getItem()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;
        $sort = !is_null($this->input->post('sort')) ? $this->input->post('sort') : 'kd_item';
        $order = !is_null($this->input->post('order')) ? $this->input->post('order') : 'asc';

        $offset = ($page - 1) * $rows;

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';
        list($filterVal, $selectFilter) = explode('|', $getFilteredVal);

        if ($getFilteredVal) {

            $qrM = "SELECT a.*
                FROM master.mitem a
                WHERE  1=1 AND upper($selectFilter) ~ upper('$filterVal') ";

            $result = array();
            $result['total'] = $this->db->query($qrM)->num_rows();

            $query = "SELECT z.* FROM (
                    SELECT    a.kd_item, 
                            a.nama_item,
                            a.kd_satuan,
                            a.kd_satuan_beli,
                            a.item_type_id,
                            t.item_type_name
                    FROM master.mitem a
                    LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                    WHERE 1=1 AND upper(" . $selectFilter . ") like upper('%" . $filterVal . "%')
                    ) as z 
                    ORDER BY z." . $sort . " " . $order . "
                    LIMIT " . $rows . " OFFSET " . $offset . "";
        } else {
            $qrM = "SELECT a.*
            FROM master.mitem a
            WHERE  1=1";

            $result = array();
            $result['total'] = $this->db->query($qrM)->num_rows();

            $query = "SELECT z.* FROM (
                SELECT    a.kd_item, 
                        a.nama_item,
                        a.kd_satuan,
                        a.kd_satuan_beli,
                        a.item_type_id,
                        t.item_type_name
                FROM master.mitem a
                LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                WHERE 1=1) as z 
                ORDER BY z." . $sort . " " . $order . "
                LIMIT " . $rows . " OFFSET " . $offset . "";
        }

        // var_dump($query);
        // die;

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }

    public function getUnit()
    {
        $query = "SELECT a.kd_satuan 
                    FROM master.satuan a
                    WHERE 1=1
                    ORDER BY a.kd_satuan ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getProject()
    {
        $query = "SELECT p.*,
                    to_char(p.dt_order,'dd-mm-yyyy') as dt_order_char,
                    to_char(p.dt_finish,'dd-mm-yyyy') as dt_finish_char
                    FROM master.mcc_project p
                    WHERE p.isproject='1' and p.isactive='1'
                    AND p.id_cc_project not in (select so_number from sales.so)
                    ORDER BY P.id_cc_project ASC";
        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getCatProject()
    {
        $query = "SELECT id_cat_project, descriptions as cpdescriptions
                    FROM master.mcat_project
                    WHERE 1=1
                    ORDER BY id_cat_project ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getProfitCenter()
    {
        $query = "SELECT a.id_rek_gl, a.descriptions
                    FROM master.mrek_gl a
                    WHERE a.isdetail='1' AND a.id_parent='4100'
                    ORDER BY a.id_rek_gl ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }



    public function getQuotation()
    {
        $query = "SELECT a.id_qt, 
                        a.no_qt,
                        a.id_qs, 
                        a.no_qs,
                        a.nama_kontak,
                        a.nama_rekanan,
                        a.proposal_description,
                        to_char(a.dt_qt,'dd-Mon-yyyy') as dt_qt,
                        a.total as total_qs,
                        a.pterm
                FROM sales.quotation a
                WHERE a.isclosed='0' AND a.isdelete='0' AND a.iscancel='0' 
                ORDER BY a.id_qt ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getResumeValue()
    {
        $idq = $this->input->post("idQuot", true);
        $idc = $this->input->post("idCont", true);

        // var_dump('quot' . $idq);
        // var_dump('contract' . $idc);
        // die;


        if ($idq > 0) {
            $idQuot = $idq;
        } else {
            $q = $this->db->get_where('sales.so', ['id_so' => $idc])->row_array();
            $idQuot =  $q['id_qt'];
        };
        // var_dump($idQuot);
        // die;


        $query = "SELECT 'Quotsheet'::varchar(30) as diskripsi, b.sub_total, b.vat_num, b.total
                    FROM sales.quote_sheet b
                    join sales.quotation a on a.id_qs=b.id_qs
                    WHERE a.id_qt = " . $idQuot . "
                    union
                    SELECT 'Quotation'::varchar(30) as diskripsi, a.sub_total_quot as sub_total, a.vat_num_quot as vat_num, a.total_quot as total
                    FROM sales.quotation a
                    WHERE a.id_qt=" . $idQuot . "";


        $qrDetail = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['sub_total'] = tegar_num($row['sub_total']);
            $row['vat_num'] = tegar_num($row['vat_num']);
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total
        $qrT = "SELECT 'Quotation'::varchar(30) as diskripsi, b.sub_total, b.total, b.vat_num, a.sub_total_quot, a.total_quot, a.vat_num_quot
                    FROM sales.quote_sheet b
                    join sales.quotation a on a.id_qs=b.id_qs
                    WHERE a.id_qt = " . $idQuot . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['diskripsi'] = "MARGIN";
            $row['sub_total'] = tegar_num($row['sub_total_quot'] - $row['sub_total']);
            $row['vat_num'] = tegar_num($row['vat_num_quot'] - $row['vat_num']);
            $row['total'] = tegar_num($row['total_quot'] - $row['total']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;
        return $result;
    }


    public function getDetailQuotsheet()
    {
        $idqs = $this->input->post("id_qs", true);

        $query = "SELECT 
                    a.id_qs,
                    0::integer as id_so_detail,
                    a.id_parent,
                    a.kd_item,
                    '' as kd_pi,
                    a.descriptions,
                    a.kd_satuan,
                    a.qty,
                    a.unit_price,
                    a.extended as sub_total
            FROM sales.quote_sheet_detail a
            WHERE a.id_qs= " . $idqs . "
            ORDER BY a.id_qs_detail ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }



    // // WHERE a.jenis='SUPPLIER' OR a.jenis='PEGAWAI'
    public function getCustomer()
    {
        $query = "SELECT    a.kd_rekanan, 
                                a.nama_rekanan,
                                a.alamat
                        FROM master.mrekanan a
                        WHERE 1=1 and a.jenis='CUSTOMER'
                        ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }



    // // WHERE a.jenis='SUPPLIER' OR a.jenis='PEGAWAI'
    public function getManager()
    {
        $query = "SELECT    a.nk, 
                            a.full_name
                        FROM master.mpegawai a
                        WHERE 1=1 
                        ORDER BY a.nk ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getDQuotation()
    {

        $id = $this->input->post('id_qt', true);
        // var_dump($data);
        // die;

        $query = "SELECT 
                    a.id_qt,
                    0::integer as id_so_detail,
                    a.kd_item	,
                    a.descriptions,
                    a.kd_satuan,
                    a.qty,
                    a.quot_price as unit_price,
                    a.quot_extended as sub_total
            FROM sales.quotation_detail a
            WHERE a.id_qt= " . $id . " and a.kd_item != ''
            ORDER BY a.id_qt_detail ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }



    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename)
    {
        $this->load->library('upload');

        $config['upload_path'] = './pdf/';

        $config['allowed_types'] = 'pdf';

        //$config['max_size'] = '2048';

        $config['overwrite'] = true;

        //$config['file_name'] = $filename . ' ' . date('d-m-Y his');
        $config['file_name'] = $filename;



        $this->upload->initialize($config); // Load konfigurasi uploadnya

        if ($this->upload->do_upload('file')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    /// ----------------------------end of pdf----------------
}

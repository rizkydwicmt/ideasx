<?php

class Ar_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
        $this->load->helper('date_id');
    }

    public function getAr()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM sales.sales_invoice a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0'
                AND a.dt_sales_invoice::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_sales_invoice),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_sales_invoice,
                         to_char(a.dt_sales_invoice,'dd-Mon-yyyy') as dt_sales_invoice, 
                        to_char(a.dt_sales_invoice,'dd/mm/yyyy') as dt_sales_invoice_str,
                        a.no_sales_invoice,
                        a.kd_rekanan,
                        a.no_berita_acara,
                        to_char(a.dt_berita_acara,'dd/mm/yyyy') as dt_berita_acara,
                        to_char(a.dt_contract,'dd/mm/yyyy') as dt_contract,
                        to_char(a.due_date,'dd/mm/yyyy') as due_date,
                        a.cust_po_number,
                        a.sub_total,
                        a.disc,
                        a.dpp,
                        a.vat_num,
                        a.pph_psn,
                        a.pph_rp,
                        a.dp_termin,
                        a.total,
                        a.vat_str,
                        a.id_curr,
                        a.kurs,
                        a.usr_ins,
                        a.usr_upd,
                        a.id_cc_project,
                        a.id_rek_gl,
                        a.remarks,
                        a.no_kontrak,
                        a.ispost,
                        a.iscancel,
                        a.no_acc,
                        a.bank_transfer,
                        mr.nama_rekanan 
                    FROM sales.sales_invoice a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0'
                    AND a.dt_sales_invoice::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_sales_invoice),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_sales_invoice ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }



    public function getArDetail($idd)
    {

        // var_dump($idd);
        // die;

        $query = "SELECT   a.id_sales_invoice, 
                            a.id_sales_invoice_detail, 
                            a.remarks, 
                            a.id_rek_gl, 
                            a.id_unit,
                            a.qty,
                            a.qty_unit,
                            a.unit_price,
                            (((a.qty/100)*a.unit_price)+(a.qty_unit*a.unit_price))::numeric(17,2) as sub_total
                    FROM sales.sales_invoice_detail a
                    WHERE a.id_sales_invoice= $idd
                    ORDER BY a.id_sales_invoice_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['sub_total'] = tegar_num($row['sub_total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(((a.qty/100)*a.unit_price)+(a.qty_unit*a.unit_price))::numeric(17,2) AS total
                FROM sales.sales_invoice_detail a
                WHERE a.id_sales_invoice=" . $idd . "";

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


    public function saveAr()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];


        $vmm = trim(substr($datmaster['dt_sales_invoice'], 3, 2));
        $vyy = trim(substr($datmaster['dt_sales_invoice'], 6, 4));

        //get no_trans
        $rNo = $this->db->get("sales.fn_gen_sales_invoice_number('" . $vmm . "','" . $vyy . "') as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('sales.sq_sales_invoice');

        //build query insert master
        $qrM = "INSERT INTO sales.sales_invoice (
         id_sales_invoice,  no_sales_invoice, dt_sales_invoice, kd_rekanan,
         no_berita_acara, dt_berita_acara, no_kontrak, dt_contract,
         no_acc, bank_transfer, vat_str, 
         cust_po_number, usr_ins, usr_upd,
         id_curr, kurs, isclosed, id_trans, id_rek_gl,
         prepared_by, iscancel, remarks, ispost, 
         id_cc_project, due_date, 
         status_auth, isdelete,  bulan, tahun,
         sub_total,
         disc,
         dpp,
         vat_num,
         pph_psn,
         pph_rp,
         dp_termin,
         total
         )
         VALUES (
          $id, '" . $no_trans . "', to_timestamp('" . $datmaster['dt_sales_invoice'] . "','dd/mm/yyyy'), '" . $datmaster['kd_rekanan'] . "',
          '" . $datmaster['no_berita_acara'] . "', to_timestamp('" . $datmaster['dt_berita_acara'] . "','dd/mm/yyyy'), 
          '" . $datmaster['no_kontrak'] . "',  to_timestamp('" . $datmaster['dt_contract'] . "','dd/mm/yyyy'),
          '" . $datmaster['no_acc'] . "', '" . $datmaster['bank_transfer'] . "', '" . $datmaster['vat_str'] . "',
          '" . $datmaster['no_kontrak'] . "', '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "',
          'IDR',1, '0',  '" . $datmaster['idtrans'] . "', '" . $datmaster['id_rek_gl'] . "',
          '" .  $this->session->userdata('username') . "', '0', '" . $datmaster['remarks'] . "', '0',
          '" . $datmaster['id_cc_project'] . "', to_timestamp('" . $datmaster['due_date'] . "','dd/mm/yyyy'),
          'APPROVAL-ACCEPTED', '0',  to_number('" . $vmm . "','99'), to_number('" . $vyy . "','9999')" . ",
          " . $datmaster['sub_total'] . ", 
          " . $datmaster['disc'] . ", 
          " . $datmaster['dpp'] . ", 
          " . $datmaster['vat_num'] . ",
          " . $datmaster['pph_psn'] . ", 
          " . $datmaster['pph_rp'] . ", 
          " . $datmaster['dp_termin'] . ", 
          " . $datmaster['total'] . "
         );";

        // var_dump($qrM);
        // die;

        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('sales.sq_sales_invoice_detail');
            $sQL = "INSERT INTO sales.sales_invoice_detail
                    (
                        nomor,
                        id_sales_invoice,
                        id_sales_invoice_detail,
                        remarks,
                        id_unit,
                        qty_unit,
                        qty,
                        unit_price,
                        id_rek_gl,
                        disc)
                    VALUES
                    (
                        $n,
                        $id,
                        $idd,
                        '" . $datdetail[$x]['remarks'] . "',
                        '" . $datdetail[$x]['kd_satuan'] . "',
                        " . $datdetail[$x]['qty_unit'] . ",
                        " . $datdetail[$x]['qty'] . ",
                        " . $datdetail[$x]['unit_price'] . ",
                        '" . $datdetail[$x]['id_rek_gl'] . "',
                        0);        
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


    public function editAr()
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_sales_invoice'], 3, 2));
        $vyy = trim(substr($datmaster['dt_sales_invoice'], 6, 4));

        // var_dump($datmaster);
        // var_dump($datmaster);
        // die;

        $id = $datmaster['id_sales_invoice'];


        $qrM = "UPDATE sales.sales_invoice SET
                dt_sales_invoice = to_timestamp('" . $datmaster['dt_sales_invoice'] . "','dd/mm/yyyy'), 
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                no_kontrak =  '" . $datmaster['no_kontrak'] . "',  
                cust_po_number =  '" . $datmaster['no_kontrak'] . "', 
                dt_contract =  to_timestamp('" . $datmaster['dt_contract'] . "','dd/mm/yyyy'), 
                due_date =  to_timestamp('" . $datmaster['due_date'] . "','dd/mm/yyyy'), 
                vat_str = '" . $datmaster['vat_str'] . "',
                usr_upd ='" .  $this->session->userdata('username') . "',
                remarks = '" . $datmaster['remarks'] . "',
                id_cc_project = '" . $datmaster['id_cc_project'] . "', 
                id_rek_gl = '" . $datmaster['id_rek_gl'] . "', 
                sub_total= " . $datmaster['sub_total'] . ",
                disc= " . $datmaster['disc'] . ",
                dpp= " . $datmaster['dpp'] . ",
                vat_num = " . $datmaster['vat_num'] . ", 
                pph_psn= " . $datmaster['pph_psn'] . ",
                pph_rp= " . $datmaster['pph_rp'] . ",
                dp_termin= " . $datmaster['dp_termin'] . ",
                total = " . $datmaster['total'] . ",
                bulan = to_number('" . $vmm . "','99'), 
                tahun = to_number('" . $vyy . "','9999'),
                no_berita_acara = '" . $datmaster['no_berita_acara'] . "', 
                dt_berita_acara = to_timestamp('" . $datmaster['dt_berita_acara'] . "','dd/mm/yyyy'),
                no_acc = '" . $datmaster['no_acc'] . "', 
                bank_transfer = '" . $datmaster['bank_transfer'] . "'
                WHERE id_sales_invoice=" . $id . ";";



        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['id_sales_invoice_detail']) == '0') {
                $n = $n + 1;
                $idd = $this->getTransid('sales.sq_sales_invoice_detail');
                $sQL = "INSERT INTO sales.sales_invoice_detail
                        (   nomor,
                            id_sales_invoice,
                            id_sales_invoice_detail,
                            remarks,
                            id_unit,
                            id_rek_gl,
                            qty,
                            qty_unit,
                            unit_price)
                        VALUES
                        (
                            $n,
                            $id,
                            $idd,
                            '" . $datdetail[$x]['remarks'] . "',
                            '" . $datdetail[$x]['kd_satuan'] . "',
                            '" . $datdetail[$x]['id_rek_gl'] . "',
                            " . $datdetail[$x]['qty'] . ",
                            " . $datdetail[$x]['qty_unit'] . ",
                            " . $datdetail[$x]['unit_price'] . ");        
                        ";
            } else {
                $idd =  $datdetail[$x]['id_sales_invoice_detail'];

                $sQL = "UPDATE sales.sales_invoice_detail SET 
                            id_rek_gl = '" . $datdetail[$x]['id_rek_gl'] . "',
                            remarks = '" . $datdetail[$x]['remarks'] . "',
                            id_unit = '" . $datdetail[$x]['kd_satuan'] . "',
                            qty =  " . $datdetail[$x]['qty'] . ",
                            qty_unit = " . $datdetail[$x]['qty_unit'] . ",
                            unit_price = " . $datdetail[$x]['unit_price'] . "
                        WHERE id_sales_invoice_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT id_sales_invoice_detail AS idd
                FROM sales.sales_invoice_detail
                WHERE id_sales_invoice=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'id_sales_invoice_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from sales.sales_invoice_detail
                        WHERE id_sales_invoice_detail=" . $row['idd'] . ";";
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
        $qrP =  "UPDATE sales.sales_invoice
                    SET ispost='1',
                        dt_post=now(),
                        usr_post='" . $this->session->userdata('username') . "',
                        usr_upd='" . $this->session->userdata('username') . "'
                WHERE id_sales_invoice=" . $id . ";";

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


    public function deleteAr($id)
    {
        $data =  array(
            'isdelete' => '1',
            'usr_upd' =>  $this->session->userdata('username')
        );
        $this->db->where('id_sales_invoice', $id);
        $this->db->set($data);
        $hasil = $this->db->update('sales.sales_invoice');
        return $hasil;;
    }


    public function getAccBank()
    {


        $query = "SELECT * 
                    FROM master.cash_bank_acc 
                    WHERE isdetail='1' and jenis='BANK'
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getCustomer()
    {

        $query = "SELECT kd_rekanan, nama_rekanan, alamat, contact
                    FROM master.mrekanan
                    WHERE jenis='CUSTOMER';";

        $data_x = array();
        $data_x = $this->db->query($query)->result_array();
        return $data_x;
    }


    public function getCoaMaster()
    {


        $query = "SELECT id_rek_gl, descriptions 
                    FROM master.mrek_gl 
                    WHERE isdetail='1' and id_parent='1200'
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getCoaDetail()
    {


        $query = "SELECT id_rek_gl, descriptions
                    FROM master.mrek_gl 
                    WHERE isdetail='1' and ((id_parent='4100') or (id_parent='2500'))
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }



    public function getUnit()
    {
        $query = "SELECT kd_satuan 
                    FROM master.satuan
                    WHERE 1=1
                    ORDER BY kd_satuan ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getItem($id)
    {

        $result = array();

        $query = "SELECT    b.id_so,
                            a.kd_item, 
                            a.descriptions,
                            a.qty,
                            a.kd_satuan,
                            a.unit_price,
                            a.sub_total
                    FROM sales.so_detail a
                    JOIN sales.so b ON b.id_so=a.id_so
                    WHERE b.so_number='" . $id . "'  ";

        $result = $this->db->query($query)->result_array();
        //$result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }

    //-----------------------------------------cetak AR --------------------------------------------
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


    public function getMARCetak($id)
    {

        $qTotal = $this->db->get_where('sales.sales_invoice', ['id_sales_invoice' => $id])->row_array();
        $Total = $this->terbilang($qTotal['total']);

        // var_dump($Total);
        // var_dump($this->terbilang($Total));
        // die;

        $query = "SELECT a.id_sales_invoice,
                         to_char(a.dt_sales_invoice,'dd-Mon-yyyy') as dt_sales_invoice,
                         to_char(a.dt_sales_invoice,'dd-mm-yyyy') as dt_sales_invoice_char,  
                        a.no_sales_invoice, 
                        a.sub_total,
                        a.disc,
                        a.dpp,
                        a.vat_num,
                        a.pph_psn,
                        a.pph_rp,
                        a.dp_termin,
                        a.total,
                        a.vat_str,
                        a.id_curr,
                        a.kurs,
                        cr.terbilang,
                        a.id_cc_project,
                        a.no_kontrak,
                        to_char(a.dt_contract,'dd-mm-yyyy') as dt_contract_char,
                        a.remarks,
                        a.no_acc,
                        a.bank_transfer,
                        p.full_name as prepared_by,
                        ap.full_name as approved_by,
                        mr.nama_rekanan,
                        mr.npwp,
                        mr.contact as kontak_rekanan,
                        (mr.alamat||', '||mr.kota||' '||coalesce(mr.kode_pos,''))::varchar(500) as alamat_rekanan,
                        ('Phone: '||coalesce(mr.telephone,'')||'/Fax: '||coalesce(mr.faxcimile,''))::varchar(500) as telp_rekanan,
                        (coalesce(mr.province,'')||'-'||coalesce(mr.country,''))::varchar(255) as negara_rekanan
                    FROM sales.sales_invoice a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    LEFT JOIN master.vuser p ON p.vuser=a.prepared_by
                    LEFT JOIN master.vuser ap ON ap.vuser=a.approved_by
                    LEFT JOIN master.mcurrency cr ON cr.id_curr=a.id_curr
                    WHERE a.id_sales_invoice=" . $id . "; ";


        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['dt_contract_char'] = date_id($row['dt_contract_char']);
            $row['dt_sales_invoice_char'] = date_id($row['dt_sales_invoice_char']);
            $row['sub_total'] = tegar_num($row['sub_total']);
            $row['disc'] = tegar_num($row['disc']);
            $row['dpp'] = tegar_num($row['dpp']);
            $row['vat_num'] = tegar_num($row['vat_num']);
            $row['pph_psn'] = tegar_num($row['pph_psn']);
            $row['pph_rp'] = tegar_num($row['pph_rp']);
            $row['dp_termin'] = tegar_num($row['dp_termin']);
            $row['total'] = tegar_num($row['total']);
            $row['terbilang'] = strtoupper($Total . ' ' . $row['terbilang']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //$result = $this->db->query($query)->result_array();
        return $result;
    }



    public function getDARCetak($id)
    {

        $query = "SELECT    a.id_sales_invoice, 
                            a.id_unit, 
                            a.remarks, 
                            (case when a.qty > 0 and a.qty_unit=0 then (a.qty/100)
                                  when a.qty = 0 and a.qty_unit>0 then a.qty_unit
                                  else 0
                            END)::numeric(9,2) as qty,
                            a.unit_price,
                            (((a.qty/100)+a.qty_unit)*a.unit_price)::numeric(17,2) as sub_total
                    FROM sales.sales_invoice_detail a
                    WHERE a.id_sales_invoice= $id 
                    ORDER BY a.id_sales_invoice_detail ASC";

        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            // $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['sub_total'] = tegar_num($row['sub_total']);
            array_push($rows, $row);
        }

        $result["rows"] = $rows;


        return $result;
    }
}

<?php

class Quotsheet_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
        $this->load->helper('date_id');
    }

    public function getQuot()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*
                FROM sales.quote_sheet a 
                WHERE a.isdelete='0'
                AND a.dt_qs::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(a.nama_rekanan),'',upper(a.no_qs),'',upper(a.proposal_description)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_qs,
                         to_char(a.dt_qs,'dd-Mon-yyyy') as dt_qs, 
                        to_char(a.dt_qs,'dd/mm/yyyy') as dt_qs_str,
                        a.no_qs,
                        a.nama_rekanan,
                        a.nama_kontak,
                        a.kd_rekanan,
                        a.revision,
                        a.sub_total,
                        a.vat_num,
                        a.total,
                        a.id_curr,
                        a.usr_ins,
                        a.usr_upd,
                        a.proposal_description,
                        a.ispost,
                        a.iscancel,
                        a.pterm,
                        a.id_cat_project,
                        cp.descriptions as  cpdescriptions
                    FROM sales.quote_sheet a 
                    LEFT JOIN master.mcat_project cp ON cp.id_cat_project=a.id_cat_project
                    WHERE a.isdelete='0'
                    AND a.dt_qs::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(a.nama_rekanan),'',upper(a.no_qs),'',upper(a.proposal_description)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_qs ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }



    public function getQuotDetail($idd)
    {

        $query = "SELECT a.id_qs,
                         a.id_qs_detail,
                         a.id_parent,
                         a.kd_item,
                         a.descriptions,
                         a.kd_satuan,
                         a.part_number,
                         a.merk,
                         a.qty,
                         a.unit_price,
                         a.extended,
                         a.remarks,
                         a.kd_pi,
                         p.parentname 
                    FROM sales.quote_sheet_detail a
                    LEFT JOIN  sales.quote_item_group p ON p.id_parent=a.id_parent
                    WHERE a.id_qs= $idd 
                    ORDER BY a.id_qs_detail ASC";

        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['extended'] = tegar_num($row['extended']);
            array_push($rows, $row);
        }

        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(extended) AS total
                FROM sales.quote_sheet_detail
                WHERE id_qs=" . $idd . "";

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


    public function saveQuot($m)
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_qs'], 3, 2));
        $vyy = trim(substr($datmaster['dt_qs'], 6, 4));

        // get no_trans
        if ($m == 'add') {
            $rNo = $this->db->get("sales.fn_gen_qs_number('" . $vmm . "','" . $vyy . "') as new_no_trans")->row_array();
            $no_trans = $rNo['new_no_trans'];
        } else {
            $no_trans =  $datmaster['no_qs'];
        }

        // get index 
        $id = $this->getTransid('sales.sq_qs');

        //build query insert master
        $qrM = "INSERT INTO sales.quote_sheet (
            id_qs, id_trans, no_qs, dt_qs, 
            nama_rekanan, proposal_description, revision, 
            id_curr, prepared_by, nama_kontak, lampiran,
            bulan_rom, tahun_rom, kd_rekanan,
            sub_total, vat_num, total,
            pterm, id_cat_project,
            usr_ins, usr_upd,
            ispost,iscancel, isdelete, isclosed)
         VALUES (
           " . $id . ", '" . $datmaster['idtrans'] . "','" . $no_trans . "', to_timestamp('" . $datmaster['dt_qs'] . "','dd-mm-yyyy'),
           '" . $datmaster['nama_rekanan'] . "', '" . $datmaster['proposal_description'] . "', '" . $datmaster['revision'] . "',
           'IDR', '" .  $this->session->userdata('username') . "', '" . $datmaster['nama_kontak'] . "', NULL,
           '" . $vmm . "', '" . $vyy . "', '" . $datmaster['kd_rekanan'] . "',
           " . $datmaster['sub_total'] . ", " . $datmaster['vat_num'] . ", " . $datmaster['total'] . ",
           NULL, '" . $datmaster['id_cat_project'] . "',
          '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', 
          '0','0','0','0' );";

        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            //$n = $n + 1;
            $idd = $this->getTransid('sales.sq_qs_detail');
            $sQL = "INSERT INTO sales.quote_sheet_detail
                      (
                          id_qs,
                          id_qs_detail,
                          id_parent,
                          kd_item,
                          descriptions,
                          part_number,
                          merk,
                          isdetail,
                          kd_satuan,
                          qty,
                          unit_price,
                          extended,
                          remarks)
                      VALUES
                      (
                          $id,
                          $idd,
                          '" . $datdetail[$x]['id_parent'] . "',
                          '" . $datdetail[$x]['kd_item'] . "',
                          '" . $datdetail[$x]['descriptions'] . "',
                          '" . $datdetail[$x]['part_number'] . "',
                          '" . $datdetail[$x]['merk'] . "',
                          '1',
                          '" . $datdetail[$x]['kd_satuan'] . "',
                          " . $datdetail[$x]['qty'] . ",
                          " . $datdetail[$x]['unit_price'] . ",
                          " . $datdetail[$x]['extended'] . ",
                          '" . $datdetail[$x]['remarks'] . "');";
            $qrD = $qrD . $sQL;
        };

        // var_dump($qrM);
        // var_dump($qrD);
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
    }


    public function editQuot()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        // var_dump($datmaster);
        // die;
        //$datremarks = $this->input->post('info', true)[0]['dremarks'];

        // var_dump($datmaster);
        // die;
        $id = $datmaster['id_qs'];
        $vmm = trim(substr($datmaster['dt_qs'], 3, 2));
        $vyy = trim(substr($datmaster['dt_qs'], 6, 4));


        $qrM = "UPDATE sales.quote_sheet SET
                dt_qs = to_timestamp('" . $datmaster['dt_qs'] . "','dd-mm-yyyy'), 
                nama_rekanan = '" . $datmaster['nama_rekanan'] . "',
                proposal_description =  '" . $datmaster['proposal_description'] . "',  
                revision =  '" . $datmaster['revision'] . "', 
                prepared_by = '" .  $this->session->userdata('username') . "',
                nama_kontak = '" . $datmaster['nama_kontak'] . "',
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                sub_total = " . $datmaster['sub_total'] . ", 
                vat_num = " . $datmaster['vat_num'] . ", 
                total = " . $datmaster['total'] . ",
                id_cat_project = '" .  $datmaster['id_cat_project'] . "',
                bulan_rom = '" . $vmm . "', 
                tahun_rom = '" . $vyy . "',
                usr_upd = '" .  $this->session->userdata('username') . "'
                WHERE id_qs=" . $id . ";";




        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['id_qs_detail']) == '0') {
                //$n = $n + 1;
                $idd = $this->getTransid('sales.sq_qs_detail');
                $sQL = "INSERT INTO sales.quote_sheet_detail
                         (id_qs,
                          id_qs_detail,
                          id_parent,
                          kd_item,
                          descriptions,
                          part_number,
                          merk,
                          isdetail,
                          kd_satuan,
                          qty,
                          unit_price,
                          extended,
                          remarks)
                      VALUES
                      (
                          $id,
                          $idd,
                          '" . $datdetail[$x]['id_parent'] . "',
                          '" . $datdetail[$x]['kd_item'] . "',
                          '" . $datdetail[$x]['descriptions'] . "',
                          '" . $datdetail[$x]['part_number'] . "',
                          '" . $datdetail[$x]['merk'] . "',
                          '1',
                          '" . $datdetail[$x]['kd_satuan'] . "',
                          " . $datdetail[$x]['qty'] . ",
                          " . $datdetail[$x]['unit_price'] . ",
                          " . $datdetail[$x]['extended'] . ",
                          '" . $datdetail[$x]['remarks'] . "');";
            } else {
                $idd =  $datdetail[$x]['id_qs_detail'];

                $sQL = "UPDATE sales.quote_sheet_detail SET 
                        id_parent = '" . $datdetail[$x]['id_parent'] . "',
                        kd_item = '" . $datdetail[$x]['kd_item'] . "',
                        descriptions = '" . $datdetail[$x]['descriptions'] . "',
                        part_number = '" . $datdetail[$x]['part_number'] . "',
                        merk = '" . $datdetail[$x]['merk'] . "',
                        kd_satuan = '" . $datdetail[$x]['kd_satuan'] . "',
                        qty =  " . $datdetail[$x]['qty'] . ",
                        unit_price = " . $datdetail[$x]['unit_price'] . ",
                        extended = " . $datdetail[$x]['extended'] . ", 
                        remarks = '" . $datdetail[$x]['remarks'] . "'
                        WHERE id_qs_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT id_qs_detail AS idd
                        FROM sales.quote_sheet_detail
                        WHERE id_qs=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'id_qs_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from sales.quote_sheet_detail
                                WHERE id_qs_detail=" . $row['idd'] . ";";
                $qrD = $qrD . $sQLX;
            }
        }

        $this->db->trans_begin();
        $this->db->query($qrM);
        $this->db->query($qrD);
        // $this->db->query($qrR);

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
        $qrP =  "UPDATE sales.quote_sheet
                    SET ispost='1',
                        dt_post=now(),
                        usr_post='" . $this->session->userdata('username') . "',
                        usr_upd='" . $this->session->userdata('username') . "'
                WHERE id_qs=" . $id . ";";

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


    public function deleteQuot($id)
    {
        $data =  array(
            'isdelete' => '1',
            'usr_upd' =>  $this->session->userdata('username')
        );
        $this->db->where('id_qs', $id);
        $this->db->set($data);
        $hasil = $this->db->update('sales.quote_sheet');
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

        $qTotal = $this->db->get_where('sales.quote_sheet', ['id_qs' => $id])->row_array();
        $Total = $this->terbilang($qTotal['total']);

        // var_dump($Total);
        // var_dump($this->terbilang($Total));
        // die;

        $query = "SELECT a.id_qs,
                         to_char(a.dt_qs,'dd-Mon-yyyy') as dt_qs,
                         to_char(a.dt_qs,'dd-mm-yyyy') as dt_qs_char,  
                        a.no_qs, 
                        a.pterm,
                        a.id_curr,
                        a.id_cat_project,
                        cp.descriptions as remarks,
                        a.revision,
                        a.nama_rekanan,
                        a.proposal_description,
                        a.nama_kontak,
                        a.lampiran,
                        a.prepared_by,
                        a.checked_by,
                        ' '::varchar(255) as terbilang,
                        p.full_name as prepared_name,
                        p.full_name as checked_name,
                        a.sub_total,
                        a.vat_num,
                        a.total

                    FROM sales.quote_sheet a 
                    LEFT JOIN master.mcat_project cp ON cp.id_cat_project=a.id_cat_project
                    LEFT JOIN master.vuser p ON p.vuser=a.prepared_by
                    LEFT JOIN master.vuser ap ON ap.vuser=a.approved_by
                    WHERE a.id_qs=" . $id . "; ";


        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['dt_qs_char'] = date_id($row['dt_qs_char']);
            $row['sub_total'] = tegar_num($row['sub_total']);
            $row['vat_num'] = tegar_num($row['vat_num']);
            $row['total'] = tegar_num($row['total']);
            $row['terbilang'] = strtoupper($Total . ' ' . $row['terbilang']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;
        return $result;
    }


    public function getDCetak($id)
    {

        $query = "SELECT    a.id_qs, 
                            a.kd_satuan,
                            a.descriptions,
                            a.part_number,
                            a.merk, 
                            a.remarks, 
                            a.qty,
                            a.extended,
                            a.unit_price
                    FROM sales.quote_sheet_detail a
                    WHERE a.id_qs= $id 
                    ORDER BY a.id_qs_detail ASC";

        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['extended'] = tegar_num($row['extended']);
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


        //var_dump($this->input->post('searching'));

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;
        $sort = !is_null($this->input->post('sort')) ? $this->input->post('sort') : 'kd_item';
        $order = !is_null($this->input->post('order')) ? $this->input->post('order') : 'asc';

        $offset = ($page - 1) * $rows;

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';
        list($filterVal, $selectFilter) = explode('|', $getFilteredVal);

        if ($getFilteredVal == '') {
            $qrM = "SELECT a.*
            FROM master.mitem a
            WHERE  1=1 ";

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
                WHERE 1=1 ) as z 
                ORDER BY z." . $sort . " " . $order . "
                LIMIT " . $rows . " OFFSET " . $offset . "";
        } else {
            $qrM = "SELECT a.*
            FROM master.mitem a
            WHERE  1=1 AND upper('" . $selectFilter . "') like upper('%" . $filterVal . "%') ";

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
        };



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
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


    public function getParent()
    {
        $query = "SELECT id_itemg, id_parent, parentname 
                    FROM sales.quote_item_group
                    WHERE 1=1
                    ORDER BY id_parent ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getCatProject()
    {
        $query = "SELECT id_cat_project, 
                        descriptions AS cpdescriptions
                    FROM master.mcat_project
                    WHERE 1=1
                    ORDER BY id_cat_project ASC";

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

    public function getCustomer()
    {
        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;
        $sort = !is_null($this->input->post('sort')) ? $this->input->post('sort') : 'kd_rekanan';
        $order = !is_null($this->input->post('order')) ? $this->input->post('order') : 'asc';

        $offset = ($page - 1) * $rows;

        $filterVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT *
        FROM master.mrekanan a
        WHERE  jenis='CUSTOMER' 
        AND  concat(upper(nama_rekanan),'',upper(kd_rekanan),'',upper(contact)) like upper('%" . $filterVal . "%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT kd_rekanan, 
                         nama_rekanan,
                         alamat,
                         contact
                    FROM master.mrekanan
                    WHERE jenis='CUSTOMER'
                    AND  concat(upper(nama_rekanan),'',upper(kd_rekanan),'',upper(contact)) like upper('%" . $filterVal . "%') 
                    ORDER BY " . $sort . " " . $order . "
                    LIMIT  " . $rows . " OFFSET " . $offset . ";";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }


    //----------------------excel-----------

    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename)
    {
        $this->load->library('upload');

        $config['upload_path'] = './excel/';

        $config['allowed_types'] = 'xls';

        $config['max_size'] = '2048';

        $config['overwrite'] = true;

        $config['file_name'] = $filename . ' ' . date('d-m-Y his');



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

    /// ----------------------------end of excel----------------
}

<?php

class Po_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getPO()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM purchasing.po a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0'
                AND a.po_date::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.po_number),'',upper(a.payment_terms)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_po,
                         to_char(a.po_date,'dd-Mon-yyyy') as po_date, 
                        to_char(a.po_date,'dd/mm/yyyy') as po_date_str,
                         to_char(a.dt_delivery,'dd-Mon-yyyy') as dt_delivery, 
                        to_char(a.dt_delivery,'dd/mm/yyyy') as dt_delivery_str,
                        a.po_number,
                        a.rev_number,
                        a.kd_rekanan,
                        a.buyer,
                        a.payment_terms,
                        a.delivery_terms,
                        a.quotation_reff,
                        a.dt_quotation,
                        a.sub_total,
                        a.vat_num,
                        a.total,
                        a.vat_str,
                        a.id_curr,
                        a.kurs,
                        a.usr_ins,
                        a.usr_upd,
                        a.id_cc_project,
                        a.remarks,
                        a.ship_to,
                        a.ispost,
                        a.iscancel,
                        a.prepared_by,
                        a.reviewed_by,
                        a.reviewed_by_2,
                        a.reviewed_by_3,
                        a.approved_by,
                        mr.nama_rekanan 
                    FROM purchasing.po a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0'
                    AND a.po_date::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.po_number),'',upper(a.payment_terms)) like upper('%$getFilteredVal%') 
                    ORDER BY a.po_number ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function getPoDetail($idd)
    {

        $query = "SELECT    a.kd_po, 
                            a.kd_po_detail, 
                            a.kd_pr_detail, 
                            a.kd_item, 
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            a.extended as sub_total,
                            a.extended
                    FROM purchasing.po_details a
                    WHERE a.kd_po= $idd
                    ORDER BY a.kd_po_detail ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();

        //$result  = $this->db->get_where('accfin.jurnal_detail', ['id_jurnal' => $idd])->row_array();
        return $result;
    }


    public function fetchPoDetail($idd)
    {

        $query = "SELECT    a.kd_po, 
                            a.kd_po_detail,
                            a.kd_item,
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            a.extended
                    FROM purchasing.po_details a
                    WHERE a.kd_po= $idd
                    ORDER BY a.kd_po_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();
        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['unit_price'] = tegar_num($row['unit_price']);
            $row['extended'] = tegar_num($row['extended']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(extended) AS total
                FROM purchasing.po_details
                WHERE kd_po=" . $idd . "";

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


    public function savePo()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];


        $vmm = trim(substr($datmaster['po_date'], 3, 2));
        $vyy = trim(substr($datmaster['po_date'], 6, 4));

        //get no_trans
        $rNo = $this->db->get("purchasing.fn_gen_po_number('" . $vmm . "','" . $vyy . "') as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('purchasing.sq_po');

        //build query insert master
        $qrM = "INSERT INTO purchasing.po (
         kd_po,  PO_number, rev_number,  po_date, kd_rekanan,
         ship_to, buyer, delivery_terms, payment_terms, total,
         descriptions, vat_str, delivery_time_str, usr_ins, usr_upd,
         id_curr, kurs, isclosed, id_trans, ordering_no,
         prepared_by, reviewed_by, reviewed_by_2, reviewed_by_3, approved_by,
         iscancel, remarks, ispost, islast,
         status, id_cc_project, dt_delivery, vat_num, status_auth,
         jml_reviewer, isdelete, wht_num, sub_total,
         bulan, tahun, discount, vat_discount, after_discount, bulan_rom,
         quotation_reff, dt_quotation)
         VALUES (
          $id, '" . $no_trans . "', '00', to_timestamp('" . $datmaster['po_date'] . "','dd/mm/yyyy'), '" . $datmaster['kd_rekanan'] . "',
          '" . $datmaster['ship_to'] . "', '" .  $datmaster['buyer'] . "','" . $datmaster['delivery_terms'] . "','" . $datmaster['payment_terms'] . "'," . $datmaster['total'] . ",
           '-', '" . $datmaster['vat_str'] . "','-','" . $this->session->userdata('username')  . "','" . $this->session->userdata('username') . "',
           '" . $datmaster['id_curr'] . "'," . $datmaster['kurs'] . ",'0','116','0',
           '" . $datmaster['prepared_by'] . "',  '" . $datmaster['reviewed_by'] . "',  '" . $datmaster['reviewed_by_2'] . "', '" . $datmaster['reviewed_by_3'] . "',
           '" . $datmaster['approved_by'] . "', '0', '" . $datmaster['remarks'] . "','0','1',
           'OPEN','" . $datmaster['id_cc_project'] . "', to_timestamp('" . $datmaster['dt_delivery'] . "','dd/mm/yyyy')," . $datmaster['vat_num'] . ", 'APPROVAL-ACCEPTED',
           0, '0',0," . $datmaster['sub_total'] . ",
           to_number('" . $vmm . "','99'), to_number('" . $vyy . "','9999'), 0, 0, 0, 'X',
           '" . $datmaster['quotation_reff'] . "','" . $datmaster['dt_quotation'] . "');";



        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            //$n = $n + 1;
            $idd = $this->getTransid('purchasing.sq_po_detail');
            $sQL = "INSERT INTO purchasing.po_details
                    (
                        kd_po,
                        kd_po_detail,
                        kd_pr_detail,
                        kd_item,
                        descriptions,
                        kd_satuan,
                        delivery_date,
                        qty,
                        unit_price,
                        extended,
                        discount)
                    VALUES
                    (
                        $id,
                        $idd,
                        " . $datdetail[$x]['kd_pr_detail'] . ",
                        '" . $datdetail[$x]['kd_item'] . "',
                        '" . $datdetail[$x]['descriptions'] . "',
                        '" . $datdetail[$x]['kd_satuan'] . "',
                        to_timestamp('" . $datmaster['dt_delivery'] . "','dd/mm/yyyy'),
                        " . $datdetail[$x]['qty'] . ",
                        " . $datdetail[$x]['unit_price'] . ",
                        " . $datdetail[$x]['extended'] . ",
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


    public function editPo($id)
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['po_date'], 3, 2));
        $vyy = trim(substr($datmaster['po_date'], 6, 4));


        $qrM = "UPDATE purchasing.po SET
                po_date = to_timestamp('" . $datmaster['po_date'] . "','dd/mm/yyyy'), 
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                ship_to =  '" . $datmaster['ship_to'] . "',  
                payment_terms = '" . $datmaster['payment_terms'] . "', 
                delivery_terms = '" . $datmaster['delivery_terms'] . "', 
                buyer = '" . $datmaster['buyer'] . "', 
                total = " . $datmaster['total'] . ",
                vat_str = '" . $datmaster['vat_str'] . "',
                usr_upd ='" .  $this->session->userdata('username') . "',
                id_curr ='" . $datmaster['id_curr'] . "', 
                kurs = " . $datmaster['kurs'] . ",
                remarks = '" . $datmaster['remarks'] . "',
                id_cc_project = '" . $datmaster['id_cc_project'] . "', 
                dt_delivery =  to_timestamp('" . $datmaster['dt_delivery'] . "','dd/mm/yyyy'),
                vat_num = " . $datmaster['vat_num'] . ", 
                sub_total= " . $datmaster['sub_total'] . ",
                bulan = to_number('" . $vmm . "','99'), 
                tahun = to_number('" . $vyy . "','9999'),
                quotation_reff = '" . $datmaster['quotation_reff'] . "', 
                dt_quotation ='" . $datmaster['dt_quotation'] . "',
                prepared_by = '" . $datmaster['prepared_by'] . "',  
                reviewed_by = '" . $datmaster['reviewed_by'] . "',  
                reviewed_by_2 = '" . $datmaster['reviewed_by_2'] . "', 
                reviewed_by_3 = '" . $datmaster['reviewed_by_3'] . "',
                approved_by = '" . $datmaster['approved_by'] . "'
                WHERE kd_po=" . $id . ";";



        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['kd_po_detail']) == '0') {
                //$n = $n + 1;
                $idd = $this->getTransid('purchasing.sq_po_detail');
                $sQL = "INSERT INTO purchasing.po_details
                        (
                            kd_po,
                            kd_po_detail,
                            kd_pr_detail,
                            kd_item,
                            descriptions,
                            kd_satuan,
                            delivery_date,
                            qty,
                            unit_price,
                            extended,
                            discount)
                        VALUES
                        (
                            $id,
                            $idd,
                            " . $datdetail[$x]['kd_pr_detail'] . ",
                            '" . $datdetail[$x]['kd_item'] . "',
                            '" . $datdetail[$x]['descriptions'] . "',
                            '" . $datdetail[$x]['kd_satuan'] . "',
                            to_timestamp('" . $datmaster['dt_delivery'] . "','dd/mm/yyyy'),
                            " . $datdetail[$x]['qty'] . ",
                            " . $datdetail[$x]['unit_price'] . ",
                            " . $datdetail[$x]['extended'] . ",
                            0);        
                        ";
            } else {
                $idd =  $datdetail[$x]['kd_po_detail'];

                $sQL = "UPDATE purchasing.po_details SET 
                            kd_pr_detail = " . $datdetail[$x]['kd_pr_detail'] . ",
                            kd_item = '" . $datdetail[$x]['kd_item'] . "',
                            descriptions = '" . $datdetail[$x]['descriptions'] . "',
                            kd_satuan = '" . $datdetail[$x]['kd_satuan'] . "',
                            delivery_date = to_timestamp('" . $datmaster['dt_delivery'] . "','dd/mm/yyyy'),
                            qty =  " . $datdetail[$x]['qty'] . ",
                            unit_price = " . $datdetail[$x]['unit_price'] . ",
                            extended = " . $datdetail[$x]['extended'] . " 
                        WHERE kd_po_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT kd_po_detail AS idd
                FROM purchasing.po_details
                WHERE kd_po=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'kd_po_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from purchasing.po_details
                        WHERE kd_po_detail=" . $row['idd'] . ";";
                $qrD = $qrD . $sQLX;
            }
        }

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
        if ($hasil) {
            $this->_ispost($id);
        } else {
            return $hasil;
        }
    }


    private function _ispost($id)
    {
        $data =  array(
            'ispost' => '1'
        );
        $this->db->where('kd_po', $id);
        $this->db->set($data);
        $hasil = $this->db->update('purchasing.po');
        return $hasil;
    }


    public function deletePo($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('kd_po', $id);
        $this->db->set($data);
        $hasil = $this->db->update('purchasing.po');
        return $hasil;;
    }





    public function getItem($idcp)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredValItem = !is_null($this->input->post('searching_item')) ? $this->input->post('searching_item') : '';


        $qrM = "SELECT a.kd_pr_detail, a.kd_item, a.deskripsi, a.kd_satuan, a.qty, a.ispo, b.no_pr, 
                        b.id_cc_project
                FROM purchasing.pr_details a
                JOIN purchasing.pr b on b.kd_pr=a.kd_pr
                WHERE b.isdelete='0' AND  b.iscancel='0'	AND a.isclosed='0' AND b.id_cc_project='" . $idcp . "'
                AND  concat(upper(a.kd_item),'',upper(a.deskripsi),'',upper(b.no_pr)) like upper('%$getFilteredValItem%') ";


        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT   a.kd_pr_detail, 
                           a.kd_item, 
                           a.deskripsi, 
                           a.kd_satuan, 
                           a.qty, 
                           a.ispo, 
                           b.no_pr, 
                           b.id_cc_project
                           FROM purchasing.pr_details a
                JOIN purchasing.pr b on b.kd_pr=a.kd_pr
                WHERE b.isdelete='0' AND  b.iscancel='0' AND a.isclosed='0' AND b.id_cc_project='" . $idcp . "'
                AND  concat(upper(a.kd_item),'',upper(a.deskripsi),'',upper(b.no_pr)) like upper('%$getFilteredValItem%')
                ORDER BY a.kd_item ASC
                LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        return $result;
    }

    //------------------------------------CETAK PO -------------------------------------------------------

    public function getMPOCetak($id)
    {
        $query = "SELECT a.kd_po,
                         to_char(a.po_date,'dd-Mon-yyyy') as po_date, 
                         to_char(a.dt_delivery,'dd-Mon-yyyy') as dt_delivery, 
                        a.po_number, 
                        a.rev_number,
                        a.buyer,
                        a.payment_terms,
                        a.delivery_terms,
                        a.quotation_reff,
                        a.dt_quotation, 
                        a.ship_to, 
                        a.sub_total,
                        a.vat_num,
                        a.total,
                        a.vat_str,
                        a.id_curr,
                        a.kurs,
                        a.id_cc_project,
                        a.remarks,
                        a.ship_to,
                        p.full_name as prepared_by,
                        r1.full_name as reviewed_by,
                        r2.full_name as reviewed_by_2,
                        r3.full_name as reviewed_by_3,
                        ap.full_name as approved_by,
                        mr.nama_rekanan,
                        mr.contact as kontak_rekanan,
                        (mr.alamat||', '||mr.kota||' '||coalesce(mr.kode_pos,''))::varchar(500) as alamat_rekanan,
                        ('Phone: '||coalesce(mr.telephone,'')||'/Fax: '||coalesce(mr.faxcimile,''))::varchar(500) as telp_rekanan,
                        (coalesce(mr.province,'')||'-'||coalesce(mr.country,''))::varchar(255) as negara_rekanan
                    FROM purchasing.po a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    LEFT JOIN master.vuser p ON p.vuser=a.prepared_by
                    LEFT JOIN master.vuser r1 ON r1.vuser=a.reviewed_by
                    LEFT JOIN master.vuser r2 ON r2.vuser=a.reviewed_by_2
                    LEFT JOIN master.vuser r3 ON r3.vuser=a.reviewed_by_3
                    LEFT JOIN master.vuser ap ON ap.vuser=a.approved_by
                    WHERE a.kd_po=" . $id . "; ";


        $data_x = $this->db->query($query);
        $result = array();
        $rows = array();

        foreach ($data_x->result_array() as $row) {
            $row['sub_total'] = tegar_num($row['sub_total']);
            $row['vat_num'] = tegar_num($row['vat_num']);
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //$result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getDPOCetak($id)
    {

        $query = "SELECT    a.kd_po, 
                            a.kd_item, 
                            a.descriptions, 
                            a.kd_satuan,
                            a.qty,
                            a.unit_price,
                            a.extended as sub_total
                    FROM purchasing.po_details a
                    WHERE a.kd_po= $id 
                    ORDER BY a.kd_po_detail ASC";

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


        return $result;
    }
}

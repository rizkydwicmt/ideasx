<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Payment_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }



    public function getPayment($idtrans)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM accfin.payment a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' AND a.id_trans='" . $idtrans . "'
                AND a.dt_payment::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_payment),'',upper(a.remarks)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_payment,
                        to_char(a.dt_payment,'dd-Mon-yyyy') as dt_payment, 
                        to_char(a.dt_payment,'dd/mm/yyyy') as dt_payment_str,
                        a.no_payment,
                        a.kd_rekanan,
                        a.remarks,
                        a.id_cc_project,
                        a.id_trans,
                        a.nominal,
                        to_char(a.due_date,'dd-Mon-yyyy') as due_date, 
                        to_char(a.due_date,'dd/mm/yyyy') as due_date_str,
                        a.usr_ins,
                        a.usr_upd,
                        a.ispost,
                        a.iscancel,
                        a.id_rek_gl,
                        a.id_curr,
                        a.kurs,
                        a.an,
                        a.bank,
                        a.jns_ttbg,
                        a.no_cek_bg_tt,
                        a.id,
                        mr.nama_rekanan,
                        mc.descriptions as nama_kasbank
                    FROM accfin.payment a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    LEFT JOIN master.cash_bank_acc mc ON mc.id=a.id
                    WHERE a.isdelete='0' AND a.id_trans='" . $idtrans . "'
                    AND a.dt_payment::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_payment),'',upper(a.remarks)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_payment ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function getPaymentDetail($idd)
    {

        $query = "SELECT    a.id_payment, 
                            a.id_payment_detail,
                            a.no_reff,
                            a.kd_pi,
                            a.description, 
                            a.dibayar,
                            a.id_rek_gl,
                            a.id_cc_project
                    FROM accfin.payment_detail a
                    WHERE a.id_payment= $idd
                    ORDER BY a.id_payment_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        foreach ($qrDetail->result_array() as $row) {
            array_push($result, $row);
        }

        return $result;
    }


    public function getDetailPayment($idd)
    {

        $query = "SELECT    a.id_payment, 
                            a.id_payment_detail,
                            a.kd_pi,
                            a.no_reff,
                            a.description, 
                            a.dibayar,
                            a.id_rek_gl,
                            a.id_cc_project
                    FROM accfin.payment_detail a
                    WHERE a.id_payment= $idd
                    ORDER BY a.id_payment_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['dibayar'] = tegar_num($row['dibayar']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(dibayar) AS total
                FROM accfin.payment_detail
                WHERE id_payment=" . $idd . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['id_rek_gl'] = "TOTAL";
            $row['dibayar'] = tegar_num($row['total']);
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


    public function savePayment()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        // var_dump($datmaster);
        // die;

        $vmm = trim(substr($datmaster['dt_payment'], 3, 2));
        $vyy = trim(substr($datmaster['dt_payment'], 6, 4));
        $idtrans = $datmaster['idtrans'];


        $c = $this->db->get_where('master.cash_bank_acc', ['id_rek_gl' => $datmaster['id_rek_gl']])->row_array();
        $id_kas = $c['id'];

        //get no_trans
        $rNo = $this->db->get("accfin.fn_gen_payment_number('" . $idtrans . "','" . $id_kas . "'," . $vmm . "," . $vyy . ")as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('accfin.sq_payment');

        //build query insert master
        $qrM = "INSERT INTO accfin.payment (
         id_payment, no_payment, 
         dt_payment, due_date,
         kd_rekanan, remarks, 
         nominal, id, iscair,
         usr_ins, usr_upd, prepared_by, 
         dt_prepared, ispost, iscancel, isdelete, id_trans,
         id_rek_gl, id_curr, kurs, istolak,
         bulan, tahun,
         an, bank, jns_ttbg, 
         no_cek_bg_tt)
         VALUES (
          $id, '" . $no_trans . "', 
          to_timestamp('" . $datmaster['dt_payment'] . "','dd/mm/yyyy'), to_timestamp('" . $datmaster['dt_payment'] . "','dd/mm/yyyy'), 
          '" . $datmaster['kd_rekanan'] . "','" . $datmaster['remarks'] . "',
          " . $datmaster['total'] . ",'" . $id_kas . "','0',
          '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', 
          now(), '0', '0', '0', '" . $idtrans . "', 
          '" . $datmaster['id_rek_gl'] . "', 'IDR', 1, '0',
          to_number('" . $vmm . "','99'), to_number('" . $vyy . "','9999'),
          '" . $datmaster['an'] . "', '" . $datmaster['bank'] . "', '" . $datmaster['jns_ttbg'] . "', 
          '" . $datmaster['no_cek_bg_tt'] . "')";

        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('accfin.sq_payment_detail');

            if (($datdetail[$x]['no_reff'])  == '-') {
                $rNo = $this->db->get("accfin.fn_gen_no_reff('accfin.sq_no_reff')as new_no_reff")->row_array();
                $no_reff =  "'" . $rNo['new_no_reff'] . "'";
            } else {
                $no_reff = "'" . ($datdetail[$x]['no_reff']) . "'";
            };
            $sQL = "INSERT INTO accfin.payment_detail
                    (
                        nomor,
                        id_payment,
                        id_payment_detail,
                        no_reff,
                        description,
                        dibayar,
                        dibayar_new,
                        id_rek_gl,
                        id_cc_project)
                    VALUES
                    (
                        $n,    
                        $id,
                        $idd,
                        " . $no_reff . ",
                        '" . $datdetail[$x]['description'] . "',
                        " . $datdetail[$x]['dibayar'] . ",
                        " . $datdetail[$x]['dibayar'] . ",
                        '" . $datdetail[$x]['id_rek_gl'] . "',
                        '" . $datdetail[$x]['id_cc_project'] . "');";
            $qrD = $qrD . $sQL;
        };


        // var_dump($qrM);
        // var_dump(($qrD));
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


    public function editPayment()
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_payment'], 3, 2));
        $vyy = trim(substr($datmaster['dt_payment'], 6, 4));
        $id = $datmaster['id_payment'];

        // var_dump($datmaster['bank']);
        // die;


        $qrM = "UPDATE accfin.payment SET
                    dt_payment = to_timestamp('" . $datmaster['dt_payment'] . "','dd/mm/yyyy'),
                    due_date = to_timestamp('" . $datmaster['dt_payment'] . "','dd/mm/yyyy'),
                    kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                    remarks =  '" . $datmaster['remarks'] . "',  
                    nominal = " . $datmaster['total'] . ",
                    usr_upd ='" .  $this->session->userdata('username') . "',
                    bulan = to_number('" . $vmm . "','99'), 
                    tahun = to_number('" . $vyy . "','9999'),
                    id_rek_gl = '" . $datmaster['id_rek_gl'] . "',
                    an = '" . $datmaster['an'] . "',
                    bank = '" . $datmaster['bank'] . "',
                    no_cek_bg_tt = '" . $datmaster['no_cek_bg_tt'] . "',
                    jns_ttbg = '" . $datmaster['jns_ttbg'] . "'
                    WHERE id_payment =" . $id . ";";


        // var_dump($qrM);
        // die;
        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            //if no_reff null
            if (($datdetail[$x]['no_reff'])  == '') {
                $rNo = $this->db->get("accfin.fn_gen_no_reff('accfin.sq_no_reff')as new_no_reff")->row_array();
                $no_reff = "'" . $rNo['new_no_reff'] . "'";
            } else {
                $no_reff = "'" . ($datdetail[$x]['no_reff']) . "'";
            };

            if (($datdetail[$x]['id_payment_detail']) == '0') {
                $n = $n + 1;
                $idd = $this->getTransid('accfin.sq_payment_detail');


                $sQL = "INSERT INTO accfin.payment_detail
                            (
                                nomor,
                                id_payment,
                                id_payment_detail,
                                no_reff,
                                description,
                                dibayar,
                                id_rek_gl,
                                dibayar_new,
                                id_cc_project)
                            VALUES
                            (
                                $n,
                                $id,
                                $idd,
                                " . $no_reff . ",
                                '" . $datdetail[$x]['description'] . "',
                                " . $datdetail[$x]['dibayar'] . ",
                                '" . $datdetail[$x]['id_rek_gl'] . "',
                                " . $datdetail[$x]['dibayar'] . ",
                                '" . $datdetail[$x]['id_cc_project'] . "');        
                            ";
            } else {
                $idd =  $datdetail[$x]['id_payment_detail'];
                $sQL = "UPDATE accfin.payment_detail SET 
                    nomor = " . $n . ",
                    no_reff = " . $no_reff . ",
                    description = '" . $datdetail[$x]['description'] . "',
                    dibayar =  " . $datdetail[$x]['dibayar'] . ",
                    dibayar_new =  " . $datdetail[$x]['dibayar'] . ",
                    id_cc_project = '" . $datdetail[$x]['id_cc_project'] . "',
                    id_rek_gl = '" . $datdetail[$x]['id_rek_gl'] . "'
                    WHERE id_payment_detail=" . $idd . ";";
            } // of else 

            $qrD = $qrD . $sQL;
        }; // END OF for($x = 0; $x <= $Count - 1; $x++)



        //get deleted record 
        $qrX = "SELECT id_payment_detail AS idd
                FROM accfin.payment_detail
                WHERE id_payment=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'id_payment_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from accfin.payment_detail
                        WHERE id_payment_detail=" . $row['idd'] . ";";
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
        // $data =  array(
        //     'ispost' => '1',
        //     'usr_post' => $this->session->userdata('username'),
        //     'dt_post' => date("d-m-Y")
        // );
        // $this->db->where('id_payment', $id);
        // $this->db->set($data);
        // $hasil = $this->db->update('accfin.payment');
        // return $hasil;

        $sQL = "UPDATE accfin.payment SET
                ispost = '1',
                dt_post = now(), 
                usr_post = '" . $this->session->userdata('username') . "'
                where id_payment =" . $id . ";";

        $this->db->trans_begin();
        $this->db->query($sQL);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }



    public function deletePayment($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('id_payment', $id);
        $this->db->set($data);
        $hasil = $this->db->update('accfin.payment');
        return $hasil;
    }


    // // WHERE a.jenis='SUPPLIER' OR a.jenis='PEGAWAI'
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


    public function getCoaDetail()
    {

        $query = "SELECT a.id_rek_gl, a.descriptions
                FROM master.mrek_gl a
                WHERE a.isdetail='1'";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getCcproData()
    {

        $query = "SELECT a.id_cc_project, a.cc_project_name,
                          (CASE WHEN a.isproject='1' THEN 'Project'
                                WHEN a.isproject='0' THEN 'Cost Center'
                            END)::varchar(30) AS jenis
                FROM master.mcc_project a
                WHERE a.isactive='1'
                ORDER BY a.isproject, a.id_cc_project";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }



    public function getNoReff($kd_rekanan)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredValItem = !is_null($this->input->post('searching_item')) ? $this->input->post('searching_item') : '';


        $qrM = "SELECT  a.no_doc, 
                        to_char(a.dt_doc,'dd-Mon-yyyy') as dt_doc, 
                        a.remarks, a.id_cc_project, a.id_rek_gl, a.sisa, a.sisa_idr,
                        t.description as nama_transaksi
                FROM accfin.vNotaHutang a
                left join master.mtransaction t on t.id_trans=a.id_trans
                WHERE a.kd_rekanan='" . $kd_rekanan . "'
                AND  concat(upper(a.no_doc),'',upper(a.remarks),'',upper(t.description)) like upper('%$getFilteredValItem%') ";


        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT  a.no_doc, 
                        to_char(a.dt_doc,'dd-Mon-yyyy') as dt_doc, 
                        a.remarks, a.id_cc_project, a.id_rek_gl, a.sisa, a.sisa_idr,
                        t.description as nama_transaksi
                FROM accfin.vNotaHutang a
                left join master.mtransaction t on t.id_trans=a.id_trans
                WHERE a.kd_rekanan='" . $kd_rekanan . "'
                AND  concat(upper(a.no_doc),'',upper(a.remarks),'',upper(t.description)) like upper('%$getFilteredValItem%') 
                ORDER BY a.no_doc ASC
                LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
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
}

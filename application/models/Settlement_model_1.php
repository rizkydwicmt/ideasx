<?php

class Settlement_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getSettlement($idtrans)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*, mr.nama_rekanan
                FROM accfin.settlement a 
                LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                WHERE a.isdelete='0' AND a.id_trans='" . $idtrans . "'
                AND a.dt_settlement::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(mr.nama_rekanan),'',upper(a.no_settlement),'',upper(a.no_kasbon)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_settlement,
                        to_char(a.dt_settlement,'dd-Mon-yyyy') as dt_settlement, 
                        to_char(a.dt_settlement,'dd/mm/yyyy') as dt_settlement_str,
                        a.no_settlement,
                        a.kd_rekanan,
                        a.remarks,
                        to_char(a.dt_berangkat,'dd-Mon-yyyy') as dt_berangkat, 
                        to_char(a.dt_berangkat,'dd/mm/yyyy') as dt_berangkat_str,
                        to_char(a.dt_datang,'dd-Mon-yyyy') as dt_datang, 
                        to_char(a.dt_datang,'dd/mm/yyyy') as dt_datang_str,
                        a.id_cc_project,
                        a.ispersonal,
                        a.issettlement,
                        a.total,
                        a.no_kasbon,
                        a.total_kasbon,
                        to_char(a.dt_kasbon,'dd-Mon-yyyy') as dt_kasbon, 
                        to_char(a.dt_kasbon,'dd/mm/yyyy') as dt_kasbon_str,
                        a.usr_ins,
                        a.usr_upd,
                        a.ispost,
                        a.iscancel,
                        a.id_rek_gl,
                        a.id_curr,
                        a.kurs,
                        a.lebih_kurang,
                        mr.nama_rekanan,
                        ca.kasbon_untuk
                    FROM accfin.settlement a 
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    LEFT JOIN accfin.kasbon ca ON ca.no_kasbon=a.no_kasbon
                    WHERE a.isdelete='0' AND a.id_trans='" . $idtrans . "'
                    AND a.dt_settlement::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_settlement),'',upper(a.no_kasbon)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_settlement ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function getSettlementDetail($idd)
    {

        $query = "SELECT    a.id_settlement, 
                            a.id_settlement_detail,  
                            to_char(a.dt_biaya,'yyyy-mm-dd') as dt_biaya,
                            a.diskripsi, 
                            a.biaya,
                            a.isterima as isterima_str,
                            a.id_rek_gl,
                            a.no_mrir,
                            a.kd_item
                    FROM accfin.settlement_detail a
                    WHERE a.id_settlement= $idd
                    ORDER BY a.id_settlement_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        foreach ($qrDetail->result_array() as $row) {
            if (($row['isterima_str']) == '1') {
                $row['isterima'] = true;
            } else {
                $row['isterima'] = false;
            }
            array_push($result, $row);
        }

        return $result;
    }


    public function getDetailSettlement($idd)
    {

        $query = "SELECT    a.id_settlement, 
                            a.id_settlement_detail,
                            to_char(a.dt_biaya,'dd-Mon-yyyy') as dt_biaya,
                            a.diskripsi, 
                            a.biaya,
                            a.id_rek_gl,
                            a.kd_item,
                            a.no_mrir
                    FROM accfin.settlement_detail a
                    WHERE a.id_settlement= $idd
                    ORDER BY a.id_settlement_detail ASC";

        $qrDetail = $this->db->query($query);

        $result = array();

        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['biaya'] = tegar_num($row['biaya']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT SUM(biaya) AS total
                FROM accfin.settlement_detail
                WHERE id_settlement=" . $idd . "";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['id_rek_gl'] = "TOTAL";
            $row['biaya'] = tegar_num($row['total']);
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


    public function saveSettlement($idtrans)
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];



        $vmm = trim(substr($datmaster['dt_settlement'], 3, 2));
        $vyy = trim(substr($datmaster['dt_settlement'], 6, 4));

        //get no_trans
        $rNo = $this->db->get("accfin.fn_gen_settlement_number('" . $idtrans . "'," . $vmm . "," . $vyy . ")as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];



        // get index 
        $id = $this->getTransid('accfin.sq_settlement');

        if ($datmaster['dt_berangkat'] == '-') {
            $dt_berangkat = "NULL";
        } else {
            $dt_berangkat = " to_timestamp('" . $datmaster['dt_berangkat'] . "','dd/mm/yyyy')";
        };
        if ($datmaster['dt_datang'] == '-') {
            $dt_datang = "NULL";
        } else {
            $dt_datang = "to_timestamp('" . $datmaster['dt_datang'] . "','dd/mm/yyyy')";
        }

        if ($idtrans == '406') {

            $nokasbon = "'" . $datmaster['nokasbon'] . "'";
            $dtkasbon = "'" . $datmaster['dt_kasbon'] . "'";
            $ca_value = $datmaster['ca_value'];
            $selisih = $datmaster['selisih'];
            $kasbon = $this->db->get_where('accfin.kasbon', ['no_kasbon' => $datmaster['nokasbon']])->row_array();
            $ispersonal = "'" . $kasbon['ispersonal'] . "'";
        } elseif ($idtrans == '407') {
            $nokasbon = "NULL";
            $dtkasbon = "NULL";
            $ca_value = "0";
            $selisih = "0";
            $ispersonal = "'00'";
        }



        //build query insert master
        $qrM = "INSERT INTO accfin.settlement (
         id_settlement, no_settlement, dt_settlement,  kd_rekanan, 
         remarks, 
         dt_berangkat, 
         dt_datang, 
         id_cc_project, ispersonal,
         issettlement, total, no_kasbon, dt_kasbon, total_kasbon,
         usr_ins, usr_upd, prepared_by, 
         dt_prepared, ispost, iscancel, isdelete, id_trans,
         id_rek_gl, id_curr, kurs, lebih_kurang,
         dt_due, bulan, tahun)
         VALUES (
          $id, '" . $no_trans . "', to_timestamp('" . $datmaster['dt_settlement'] . "','dd/mm/yyyy'), '" . $datmaster['kd_rekanan'] . "',
          '" . $datmaster['remarks'] . "', " . $dt_berangkat . "," . $dt_datang . ",
          '" . $datmaster['id_cc_project'] . "', " . $ispersonal . ", 
          '" . $datmaster['issettle'] . "', " . $datmaster['total'] . "," . $nokasbon . "," . $dtkasbon . ", " . $ca_value . ",
          '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', '" .  $this->session->userdata('username') . "', 
          now(), '0', '0', '0', '" . $idtrans . "',       
          '" . $datmaster['id_rek_gl'] . "', '" . $datmaster['id_curr'] . "', " . $datmaster['kurs'] . ", " . $selisih . ",
          to_timestamp('" . $datmaster['dt_settlement'] . "','dd/mm/yyyy'), to_number('" . $vmm . "','99'), to_number('" . $vyy . "','9999'))";




        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            $n = $n + 1;
            $idd = $this->getTransid('accfin.sq_sttlement_detail');

            if (($datdetail[$x]['kd_item'])  == '-') {
                $kd_item = "NULL";
            } else {
                $kd_item = "'" . ($datdetail[$x]['kd_item']) . "'";
            };
            $sQL = "INSERT INTO accfin.settlement_detail
                    (
                        nomor,
                        id_settlement,
                        id_settlement_detail,
                        dt_biaya,
                        kd_item,
                        diskripsi,
                        biaya,
                        isterima,
                        id_rek_gl,
                        no_mrir)
                    VALUES
                    (
                        $n,    
                        $id,
                        $idd,
                        to_timestamp('" . $datdetail[$x]['dt_biaya'] . "','yyyy-mm-dd'),
                        " . $kd_item . ",
                        '" . $datdetail[$x]['diskripsi'] . "',
                        " . $datdetail[$x]['biaya'] . ",
                        '" . $datdetail[$x]['isterima'] . "',
                        '" . $datdetail[$x]['id_rek_gl'] . "',
                        '" . $datdetail[$x]['no_mrir'] . "');";
            $qrD = $qrD . $sQL;
        };

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


    public function editSettlement($id)
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_settlement'], 3, 2));
        $vyy = trim(substr($datmaster['dt_settlement'], 6, 4));


        if ($datmaster['dt_berangkat'] == '-') {
            $dt_berangkat = "NULL";
        } else {
            $dt_berangkat = " to_timestamp('" . $datmaster['dt_berangkat'] . "','dd/mm/yyyy')";
        };
        if ($datmaster['dt_datang'] == '-') {
            $dt_datang = "NULL";
        } else {
            $dt_datang = "to_timestamp('" . $datmaster['dt_datang'] . "','dd/mm/yyyy')";
        }

        $settlement = $this->db->get_where('accfin.settlement', ['id_settlement' => $id])->row_array();
        $idtrans = $settlement['id_trans'];


        if ($idtrans == '406') {

            $nokasbon = "'" . $datmaster['nokasbon'] . "'";
            $dtkasbon = "'" . $datmaster['dt_kasbon'] . "'";
            $ca_value = $datmaster['ca_value'];
            $selisih = $datmaster['selisih'];
            $kasbon = $this->db->get_where('accfin.kasbon', ['no_kasbon' => $datmaster['nokasbon']])->row_array();
            $ispersonal = "'" . $kasbon['ispersonal'] . "'";
        } elseif ($idtrans == '407') {
            $nokasbon = "NULL";
            $dtkasbon = "NULL";
            $ca_value = "0";
            $selisih = "0";
            $ispersonal = "'00'";
        }



        $qrM = "UPDATE accfin.settlement SET
                dt_settlement = to_timestamp('" . $datmaster['dt_settlement'] . "','dd/mm/yyyy'),
                dt_due = to_timestamp('" . $datmaster['dt_settlement'] . "','dd/mm/yyyy'),
                dt_berangkat = " . $dt_berangkat . ",
                dt_datang = " . $dt_datang . ", 
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                remarks =  '" . $datmaster['remarks'] . "',  
                ispersonal = " . $ispersonal . ",
                id_cc_project = '" . $datmaster['id_cc_project'] . "', 
                total = " . $datmaster['total'] . ",
                total_kasbon = " . $ca_value . ",
                lebih_kurang = " . $selisih . ",
                usr_upd ='" .  $this->session->userdata('username') . "',
                id_curr ='" . $datmaster['id_curr'] . "', 
                kurs = " . $datmaster['kurs'] . ",
                no_kasbon = " . $nokasbon . ",
                dt_kasbon = " . $dtkasbon . ", 
                bulan = to_number('" . $vmm . "','99'), 
                tahun = to_number('" . $vyy . "','9999'),
                id_rek_gl = '" . $datmaster['id_rek_gl'] . "'
                WHERE id_settlement =" . $id . ";";



        $qrD = '';
        $sQL = '';
        $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['kd_item'])  == '-') {
                $kd_item = "NULL";
            } else {
                $kd_item = "'" . ($datdetail[$x]['kd_item']) . "'";
            };


            if (($datdetail[$x]['uid']) == '0') {
                $n = $n + 1;
                $idd = $this->getTransid('accfin.sq_sttlement_detail');


                $sQL = "INSERT INTO accfin.settlement_detail
                        (
                            nomor
                            id_settlement,
                            id_settlement_detail,
                            kd_item,
                            diskripsi,
                            biaya,
                            dt_biaya,
                            isterima,
                            id_rek_gl,
                            no_mrir)
                        VALUES
                        (
                            $n,
                            $id,
                            $idd,
                            " . $kd_item . ",
                            '" . $datdetail[$x]['diskripsi'] . "',
                            " . $datdetail[$x]['biaya'] . ",
                            to_timestamp('" . $datdetail[$x]['dt_biaya'] . "','yyyy-mm-dd'),
                            '" . $datdetail[$x]['isterima'] . "',
                            '" . $datdetail[$x]['id_rek_gl'] . "',        
                            '" . $datdetail[$x]['no_mrir'] . "');        
                        ";
            } else {
                $idd =  $datdetail[$x]['uid'];

                $sQL = "UPDATE accfin.settlement_detail SET 
                            kd_item = " . $kd_item . ",
                            diskripsi = '" . $datdetail[$x]['diskripsi'] . "',
                            biaya =  " . $datdetail[$x]['biaya'] . ",
                            dt_biaya = to_timestamp('" . $datdetail[$x]['dt_biaya'] . "','yyyy-mm-dd'),
                            isterima = '" . $datdetail[$x]['isterima'] . "',
                            id_rek_gl = '" . $datdetail[$x]['id_rek_gl'] . "',
                            no_mrir = '" . $datdetail[$x]['no_mrir'] . "'
                        WHERE id_settlement_detail=" . $idd . ";";
            }

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

    public function deleteSettlement($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('id_settlement', $id);
        $this->db->set($data);
        $hasil = $this->db->update('accfin.settlement');
        return $hasil;;
    }


    public function getSupplier()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis
                    FROM master.mrekanan a
                    WHERE a.jenis='PEGAWAI'
                    ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function fetchCaNumber($id)
    {

        $query = "SELECT a.no_kasbon, a.jumlah as sisa_ca, ca.kasbon_untuk, ca.kd_rekanan,
                                    to_char(ca.dt_purposed,'dd/mm/yyyy')::varchar(30) as dt_kasbon, 
                                    ca.jumlah, ca.id_rek_gl_debet, ca.id_cc_project
                                    from accfin.vcek_kasbon a
                                    join accfin.kasbon ca on ca.no_kasbon=a.no_kasbon
                                    WHERE ca.kd_rekanan='" . $id . "';";


        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getCoaNumberEasyui($idcp)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $qmccpro = $this->db->get_where('master.mcc_project', ['id_cc_project' => $idcp])->row_array();


        $getFilteredValCoa = !is_null($this->input->post('searching_coa')) ? $this->input->post('searching_coa') : '';




        if (($qmccpro['isproject']) == '1') {
            $qrM = "SELECT a.id_rek_gl, a.descriptions
            FROM master.vrek_biaya_project a
            WHERE 1=1
            AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredValCoa%') ";
        } elseif (($qmccpro['isproject']) == '0') {
            $qrM = "SELECT a.id_rek_gl, a.descriptions
            FROM master.vrek_biaya_office a
            WHERE 1=1
            AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredValCoa%') ";
        }

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        if (($qmccpro['isproject']) == '1') {
            $query = "SELECT a.id_rek_gl, a.descriptions
                FROM master.vrek_biaya_project a
                WHERE 1=1
                AND  concat(upper(a.id_rek_gl),'',upper(a.descriptions)) like upper('%$getFilteredValCoa%')
                ORDER BY a.id_rek_gl ASC 
                LIMIT $rows OFFSET $offset";
        } elseif (($qmccpro['isproject']) == '0') {
            $query = "SELECT b.id_rek_gl, b.descriptions
                FROM master.vrek_biaya_office b
                WHERE 1=1
                AND  concat(upper(b.id_rek_gl),'',upper(b.descriptions)) like upper('%$getFilteredValCoa%')
                ORDER BY b.id_rek_gl ASC
                LIMIT $rows OFFSET $offset";
        }

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

<?php

class Pr_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getPr()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';
        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*
                FROM purchasing.pr a 
                WHERE a.isdelete='0'
                AND a.dt_pr::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                AND  concat(upper(a.requester),'',upper(a.no_pr),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%') ";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.kd_pr,
                         to_char(a.dt_pr,'dd-Mon-yyyy') as dt_pr, 
                         to_char(a.dt_pr,'dd/mm/yyyy') as dt_pr_str,
                        a.pr_no,
                        a.no_pr,
                        a.rev_no,
                        a.requester,
                        a.usr_ins,
                        a.usr_upd,
                        a.id_cc_project,
                        a.remarks,
                        a.ispost,
                        a.iscancel
                    FROM purchasing.pr a 
                    WHERE a.isdelete='0'
                    AND a.dt_pr::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(a.requester),'',upper(a.pr_no),'',upper(a.no_pr)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_pr ASC
                    LIMIT $rows OFFSET $offset";



        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function getPrMaster($idd)
    {

        $query = "SELECT a.kd_pr,
                        to_char(a.dt_pr,'dd-mm-yyyy') as dt_pr,
                        a.pr_no,
                        a.no_pr,
                        a.rev_no,
                        a.requester,
                        a.usr_ins,
                        a.usr_upd,
                        a.id_cc_project,
                        a.remarks,
                        a.ispost,
                        a.iscancel,
                        p.cc_project_name
                    FROM purchasing.pr a 
                    left join master.mcc_project p on p.id_cc_project=a.id_cc_project
                    WHERE a.kd_pr= $idd";

        $result = array();

        $result = $this->db->query($query)->result_array();
        // var_dump($result);
        // die;

        return $result;
    }


    public function getPrDetail($idd)
    {

        $query = "SELECT    a.kd_pr, 
                            a.kd_pr_detail, 
                            a.kd_item, 
                            a.kd_pi,
                            a.deskripsi, 
                            a.kd_satuan,
                            a.qty,
                            to_char(a.dt_kebutuhan,'dd-mm-yyyy') as dt_kebutuhan, 
                            a.iscapex
                    FROM purchasing.pr_details a
                    WHERE a.kd_pr=  $idd
                    ORDER BY a.kd_pr_detail ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();

        var_dump($result);
        die;

        //$result  = $this->db->get_where('accfin.jurnal_detail', ['id_jurnal' => $idd])->row_array();
        return $result;
    }


    public function fetchPrDetail($idd)
    {

        $query = "SELECT    a.kd_pr, 
                    a.kd_pr_detail, 
                    a.kd_item, 
                    a.deskripsi, 
                    a.kd_satuan,
                    a.qty,
                    to_char(a.dt_kebutuhan,'dd-Mon-yyyy') as dt_kebutuhan, 
                    to_char(a.dt_kebutuhan,'dd/mm/yyyy') as dt_kebutuhan_str,
                    a.iscapex
                    FROM purchasing.pr_details a
                    WHERE a.kd_pr= $idd
                    ORDER BY a.kd_pr_detail ASC";


        $qrDetail = $this->db->query($query);

        $result = array();
        $rows = array();

        foreach ($qrDetail->result_array() as $row) {
            $row['qty'] = tegar_num($row['qty']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;


        return $result;
    }



    private function getTransid($seq)
    {
        $rIdx = $this->db->get("NEXTVAL('" . $seq . "') as idx")->row_array();
        $id = $rIdx['idx'];

        return $id;
    }


    public function savePr()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        // var_dump($datdetail);
        // die;

        $vmm = trim(substr($datmaster['dt_pr'], 3, 2));
        $vyy = trim(substr($datmaster['dt_pr'], 6, 4));

        //get no_trans
        $rNo = $this->db->get("purchasing.fn_gen_pr_number('" . $datmaster['id_cc_project'] . "','" . $vmm . "','" . $vyy . "') as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('purchasing.sq_pr');

        //build query insert master
        $qrM = "INSERT INTO purchasing.pr (
         kd_pr, pr_no, no_pr, rev_no,  dt_pr, requester,
         status, usr_ins, usr_upd,
         isclosed, id_trans, prepared_by, 
         iscancel, remarks, ispost, islast,
         id_cc_project, status_auth,
         is_send_rfq, isdelete, issubmit, iscapex, isreceived,
         received_date, bulan, tahun, 
         bulan_rom)
         VALUES (
          $id, '" . $id . "', '" . $no_trans . "', '00', to_timestamp('" . $datmaster['dt_pr'] . "','dd/mm/yyyy'), '" . $datmaster['requester'] . "',
          'OPEN', '" .  $this->session->userdata('username') . "','" .  $this->session->userdata('username') . "',
           '0', '" . $datmaster['idtrans'] . "','" . $this->session->userdata('username')  . "',
           '0',  '" . $datmaster['remarks'] . "', '0','1',
           '" . $datmaster['id_cc_project'] . "', 'APPROVAL-ACCEPTED',
           '0', '0', '0', '0', '0',
            to_timestamp('" . $datmaster['dt_pr'] . "','dd/mm/yyyy'),to_number('" . $vmm . "','99'), to_number('" . $vyy . "','9999'), 
            '-');";

        // var_dump($qrM);
        // die;

        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {
            //$n = $n + 1;
            $idd = $this->getTransid('purchasing.sq_pr_details');
            $sQL = "INSERT INTO purchasing.pr_details
                    (
                        kd_pr,
                        kd_pr_detail,
                        kd_item,
                        deskripsi,
                        kd_satuan,
                        dt_kebutuhan,
                        qty,
                        iscapex,
                        isbid,
                        isclosed,
                        isgudang,
                        ispo,
                        islangsung)
                    VALUES
                    (
                        $id,
                        $idd,
                        '" . $datdetail[$x]['kd_item'] . "',
                        '" . $datdetail[$x]['deskripsi'] . "',
                        '" . $datdetail[$x]['kd_satuan'] . "',
                        to_timestamp('" . $datdetail[$x]['dt_kebutuhan'] . "','dd-mm-yyyy'),
                        " . $datdetail[$x]['qty'] . ",
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0');        
                    ";
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
        if ($hasil) {
            $this->_ispost($id);
        } else {
            return $hasil;
        }
    }


    public function editPr($id)
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];
        $datdetail = $this->input->post('info', true)[0]['detail'];

        $vmm = trim(substr($datmaster['dt_pr'], 3, 2));
        $vyy = trim(substr($datmaster['dt_pr'], 6, 4));


        $qrM = "UPDATE purchasing.pr SET
                dt_pr = to_timestamp('" . $datmaster['dt_pr'] . "','dd-mm-yyyy'), 
                requester = '" . $datmaster['requester'] . "',
                remarks = '" . $datmaster['remarks'] . "',
                id_cc_project = '" . $datmaster['id_cc_project'] . "', 
                received_date =  to_timestamp('" . $datmaster['dt_pr'] . "','dd-mm-yyyy'),
                bulan = to_number('" . $vmm . "','99'), 
                tahun = to_number('" . $vyy . "','9999')
                WHERE kd_pr=" . $id . ";";



        $qrD = '';
        $sQL = '';
        // $n = 0;
        $Count  = count($datdetail);
        for ($x = 0; $x <= $Count - 1; $x++) {

            if (($datdetail[$x]['kd_pr_detail']) == '0') {
                //$n = $n + 1;
                $idd = $this->getTransid('purchasing.sq_pr_details');
                $sQL = "INSERT INTO purchasing.pr_details
                        (
                            kd_pr,
                        kd_pr_detail,
                        kd_item,
                        deskripsi,
                        kd_satuan,
                        dt_kebutuhan,
                        qty,
                        iscapex,
                        isbid,
                        isclosed,
                        isgudang,
                        ispo,
                        islangsung)
                    VALUES
                    (
                        $id,
                        $idd,
                        '" . $datdetail[$x]['kd_item'] . "',
                        '" . $datdetail[$x]['deskripsi'] . "',
                        '" . $datdetail[$x]['kd_satuan'] . "',
                        to_timestamp('" . $datdetail[$x]['dt_kebutuhan'] . "','dd-mm-yyyy'),
                        " . $datdetail[$x]['qty'] . ",
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0');        
                        ";
            } else {
                $idd =  $datdetail[$x]['kd_pr_detail'];

                $sQL = "UPDATE purchasing.pr_details SET 
                            kd_item = '" . $datdetail[$x]['kd_item'] . "',
                            deskripsi = '" . $datdetail[$x]['deskripsi'] . "',
                            kd_satuan = '" . $datdetail[$x]['kd_satuan'] . "',
                            dt_kebutuhan = to_timestamp('" . $datdetail[$x]['dt_kebutuhan'] . "','dd-mm-yyyy'),
                            qty =  " . $datdetail[$x]['qty'] . "
                        WHERE kd_pr_detail=" . $idd . ";";
            }

            $qrD = $qrD . $sQL;
        };

        //get deleted record 
        $qrX = "SELECT kd_pr_detail AS idd
                FROM purchasing.pr_details
                WHERE kd_pr=" . $id . "";
        $x = $this->db->query($qrX);
        $sQLX = '';
        foreach ($x->result_array() as $row) {
            $keys = array_keys(array_column($datdetail, 'kd_pr_detail'), $row['idd']);
            if (empty($keys)) {
                $sQLX = "DELETE from purchasing.pr_details
                        WHERE kd_pr_detail=" . $row['idd'] . ";";
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
        $data =  array(
            'ispost' => '1'
        );
        $this->db->where('kd_pr', $id);
        $this->db->set($data);
        $hasil = $this->db->update('purchasing.pr');
        return $hasil;
    }


    public function deletePr($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('kd_pr', $id);
        $this->db->set($data);
        $hasil = $this->db->update('purchasing.pr');
        return $hasil;;
    }


    public function getItem($x)
    {


        $getFilteredValItem = !is_null($this->input->post('searching_item')) ? $this->input->post('searching_item') : '';

        $q = $this->db->get_where('master.mcc_project', ['id_cc_project' =>  $x ])->row_array();
        // $query =='';


        if (($q['isproject']) == '1') { // jika project --> dari contract assignment


            $query = "SELECT cd.kd_item, cd.kd_pi, cd.descriptions as nama_item, cd.qty, cd.kd_satuan, it.item_type_name
                        FROM sales.so_detail cd
                        JOIN sales.so cm ON cm.id_so=cd.id_so
                        LEFT JOIN (SELECT mi.kd_item, 
                                          mi.item_type_id, 
                                          t.item_type_name
                                    FROM master.mitem mi
                                    LEFT JOIN master.mitem_type t ON t.item_type_id=mi.item_type_id) as it on it.kd_item=cd.kd_item
                        WHERE cm.id_cc_project='" . $x . "'
                        AND  concat(upper(cd.kd_item),'',upper(cd.descriptions),'',upper(it.item_type_name)) like upper('%$getFilteredValItem%') 
                        ORDER BY cd.kd_item ASC";

        } elseif (($q['isproject']) == '0') { // jika bukan project (cost center) --> dari master item


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
                ORDER BY a.kd_item ASC";
        }
        //var_dump(($qmccpro['isproject']));
        // var_dump($query);
        // die;

        $result = array();
        $result = $this->db->query($query)->result_array();
        // $result['total'] = $this->db->query($qrM)->num_rows();

        // $data_x = $this->db->query($query)->result_array();
        // $result = array_merge($result, ['rows' => $data_x]);
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

    public function getRekanan()
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
}

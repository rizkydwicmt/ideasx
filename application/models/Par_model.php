<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Par_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }


    public function getPar()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredValItem = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT  a.*,
                        t.description as nama_transaksi,
                        mr.nama_rekanan
                FROM accfin.vNotaHutang a
                left join master.mtransaction t on t.id_trans=a.id_trans
                LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan
                WHERE 1=1
                AND  concat(upper(a.no_doc),'',upper(a.remarks),'',upper(mr.nama_rekanan)) like upper('%$getFilteredValItem%') ";


        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT  a.no_doc, 
                        to_char(a.dt_doc,'dd-Mon-yyyy') as dt_doc, 
                        a.remarks, a.id_cc_project, a.id_rek_gl, a.total_idr,
                        t.description as nama_transaksi,
                        mr.nama_rekanan
                FROM accfin.vNotaHutang a
                left join master.mtransaction t on t.id_trans=a.id_trans
                LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan
                WHERE 1=1
                AND  concat(upper(a.no_doc),'',upper(a.remarks),'',upper(mr.nama_rekanan)) like upper('%$getFilteredValItem%') 
                ORDER BY a.no_doc ASC
                LIMIT $rows OFFSET $offset";

        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //get total

        $qrT = "SELECT SUM(a.total_idr) AS total_nominal
                FROM accfin.vNotaHutang a
                left join master.mtransaction t on t.id_trans=a.id_trans
                LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan
                WHERE 1=1
                AND  concat(upper(a.no_doc),'',upper(a.remarks),'',upper(mr.nama_rekanan)) like upper('%$getFilteredValItem%')";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['remarks'] = "TOTAL";
            $row['total_idr'] = $row['total_nominal'];
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        return $result;
    }
}

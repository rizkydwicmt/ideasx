<?php

class RepProcurement_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getAp()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);

        $qrM = "SELECT a.*
                    FROM accfin.fn_get_repaplist('" . $dt_awal . "', '" . $dt_akhir . "') a
                    --WHERE (a.awal_hutang+a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2)>0
                    WHERE 1=1
                    AND  concat(upper(a.nama_rekanan),'',upper(a.id_rekanan)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*, (a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2) as mutasi_total, 
                        (a.awal_hutang+a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2) as total_hutang                   
                    FROM accfin.fn_get_repaplist('" . $dt_awal . "', '" . $dt_akhir . "') a
                  --  WHERE (a.awal_hutang+a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2)>0
                    WHERE 1=1
                    AND  concat(upper(a.nama_rekanan),'',upper(a.id_rekanan)) like upper('%$getFilteredVal%') 
                    ORDER BY a.id_rekanan ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        //get total

        $qrT = "SELECT SUM(a.awal_hutang) AS total_awal_hutang,
                       SUM(a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2) as total_mutasi_total, 
                       SUM(a.awal_hutang+a.mutasi_hutang-a.mutasi_bayar)::numeric(17,2) as total_total_hutang
                FROM accfin.fn_get_repaplist('" . $dt_awal . "', '" . $dt_akhir . "') a
                WHERE 1=1
                AND  concat(upper(a.nama_rekanan),'',upper(a.id_rekanan)) like upper('%$getFilteredVal%') ";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['nama_rekanan'] = "TOTAL";
            $row['awal_hutang'] = $row['total_awal_hutang'];
            $row['mutasi_total'] = $row['total_mutasi_total'];
            $row['total_hutang'] = $row['total_total_hutang'];
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        return $result;
    }

    public function getApListDetail($idr)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);

        // var_dump($idr);
        // die;

        $qrM = "SELECT a.*
                    FROM accfin.fn_get_repaplist_detail('" . $idr . "','" . $dt_awal . "', '" . $dt_akhir . "') a
                    WHERE 1=1
                    AND  concat(upper(a.ap_number),'',upper(a.invoice_no),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*, to_char(a.dt_ap,'dd-Mon-yyyy') as dt_ap_str                
                    FROM accfin.fn_get_repaplist_detail('" . $idr . "','" . $dt_awal . "', '" . $dt_akhir . "') a
                    WHERE 1=1
                    AND  concat(upper(a.ap_number),'',upper(a.invoice_no),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%') 
                    ORDER BY a.kd_rekanan ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        //get total

        $qrT = "SELECT SUM(a.debet) AS total_debet,
                       SUM(a.kredit) AS total_kredit 
                FROM accfin.fn_get_repaplist_detail('" . $idr . "','" . $dt_awal . "', '" . $dt_akhir . "') a
                WHERE 1=1
                AND  concat(upper(a.ap_number),'',upper(a.invoice_no),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%')";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['id_cc_project'] = "TOTAL";
            $row['debet'] = $row['total_debet'];
            $row['kredit'] = $row['total_kredit'];
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        return $result;
    }
}

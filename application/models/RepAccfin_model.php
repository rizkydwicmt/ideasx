<?php

class RepAccfin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tegar_num');
    }

    public function getMaster($x)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;


        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';


        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);


        $query = "SELECT a.id_rek_gl, 
                        a.descriptions, 
                        coalesce(x.awal,0) as awal, 
                        coalesce(y.berjalan,0) as berjalan,
                        coalesce(coalesce(x.awal,0)+coalesce(y.berjalan,0),0) as total
                        from master.cash_bank_acc a
                        left join (select c.id_rek_gl, coalesce(sum(b.debet-b.kredit),0) as awal 
                            from master.cash_bank_acc c
                            join accfin.vpayment_detail b on b.id_rek_gl=c.id_rek_gl
                            where c.jenis='" . $x . "' and c.isdetail='1'  and b.dt_payment< to_timestamp('" . $dt_awal . "','dd/mm/yyyy')
                            group by c.id_rek_gl) as x on x.id_rek_gl=a.id_rek_gl
                        left join (select d.id_rek_gl, coalesce(sum(b.debet-b.kredit),0) as berjalan
                                from master.cash_bank_acc d
                                join accfin.vpayment_detail b on b.id_rek_gl=d.id_rek_gl
                                where d.jenis='" . $x . "' and d.isdetail='1' 
                                and b.dt_payment between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                                group by d.id_rek_gl) as y on y.id_rek_gl=a.id_rek_gl 
                        where a.jenis='" . $x . "' and a.isdetail='1'
                    ORDER BY a.id_rek_gl ASC";


        $data_x = $this->db->query($query);

        $result = array();
        $rows = array();
        $footers = array();


        foreach ($data_x->result_array() as $row) {
            $row['awal'] = tegar_num($row['awal']);
            $row['berjalan'] = tegar_num($row['berjalan']);
            $row['total'] = tegar_num($row['total']);
            array_push($rows, $row);
        }
        $result["rows"] = $rows;

        //get total

        $qrT = "SELECT a.id_rek_gl, a.descriptions, 
                    SUM(coalesce(x.awal,0)) as awal, 
                    SUM(coalesce(y.berjalan,0)) as berjalan,
                    SUM(coalesce(coalesce(x.awal,0)+coalesce(y.berjalan,0),0)) as total
                    from master.cash_bank_acc a
                    left join (select c.id_rek_gl, coalesce(sum(b.debet-b.kredit),0) as awal 
                        from master.cash_bank_acc c
                        join accfin.vpayment_detail b on b.id_rek_gl=c.id_rek_gl
                        where c.jenis='" . $x . "' and c.isdetail='1'  and b.dt_payment< to_timestamp('" . $dt_awal . "','dd/mm/yyyy')
                        group by c.id_rek_gl) as x on x.id_rek_gl=a.id_rek_gl
                    left join (select d.id_rek_gl, coalesce(sum(b.debet-b.kredit),0) as berjalan
                            from master.cash_bank_acc d
                            join accfin.vpayment_detail b on b.id_rek_gl=d.id_rek_gl
                            where d.jenis='" . $x . "' and d.isdetail='1' 
                            and b.dt_payment between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                            group by d.id_rek_gl) as y on y.id_rek_gl=a.id_rek_gl 
                    where a.jenis='" . $x . "' and a.isdetail='1'
                    GROUP BY a.id_rek_gl, a.descriptions
                ORDER BY a.id_rek_gl ASC";

        $footers = array();
        $c = $this->db->query($qrT);
        foreach ($c->result_array() as $row) {
            $row['descriptions'] = "TOTAL";
            $row['awal'] = tegar_num($row['awal']);
            $row['berjalan'] = tegar_num($row['berjalan']);
            $row['total'] = tegar_num($row['total']);
            array_push($footers, $row);
        }

        $result["footer"] = $footers;

        // var_dump($result);
        // die;

        return $result;
    }

    public function getDetail($idr)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        $dt_awal = str_replace('/', '-', $dt_awal);
        $dt_akhir = str_replace('/', '-', $dt_akhir);

        // var_dump($getFilteredVal);
        // die;

        $qrM = "SELECT a.*
                    FROM accfin.vpayment_detail a
                    WHERE a.id_rek_gl='" . $idr . "'
                    AND a.dt_payment between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                    AND  concat(upper(a.nama_rekanan),'',upper(a.description),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*, to_char(a.dt_payment,'dd/mm/yyyy')::varchar(30) as dt_payment_str
                    FROM accfin.vpayment_detail a
                    WHERE a.id_rek_gl='" . $idr . "'
                    AND a.dt_payment between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                    AND  concat(upper(a.nama_rekanan),'',upper(a.description),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%')
                    ORDER BY a.no_payment ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        //get total

        $qrT = "SELECT SUM(a.debet) AS total_debet,
                       SUM(a.kredit) AS total_kredit 
                       FROM accfin.vpayment_detail a
                    WHERE a.id_rek_gl='" . $idr . "'
                    AND a.dt_payment between to_timestamp('" . $dt_awal . "','dd/mm/yyyy') and to_timestamp('" . $dt_akhir . "','dd/mm/yyyy') +  interval '23 hours 59 min'
                    AND  concat(upper(a.nama_rekanan),'',upper(a.description),'',upper(a.id_cc_project)) like upper('%$getFilteredVal%')";

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

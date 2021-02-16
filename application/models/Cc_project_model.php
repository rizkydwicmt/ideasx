<?php

class Cc_project_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getData($jr)
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        if ($jr == 'Project') {
            $p = '1';
        } else {
            $p = '0';
        };

        $qtotal = "SELECT a.*, 
                            mr.nama_rekanan  
                    FROM master.mcc_project a
                    LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan 
                    WHERE isproject='$p'
                    AND  concat(upper(a.cc_project_name),'',upper(a.id_cc_project),'',upper(mr.nama_rekanan)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qtotal)->num_rows();

        //AND upper($selectFilter) ~ upper('$filterVal')
        $query = "SELECT a.*, mr.nama_rekanan,
                        to_char(a.dt_order, 'dd/mm/yyyy') as dt_order_char,
                        to_char(a.dt_start, 'dd/mm/yyyy') as dt_start_char,
                        to_char(a.dt_finish, 'dd/mm/yyyy') as dt_finish_char,
                        cp.descriptions as project_category
                    FROM master.mcc_project a
                    LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan 
                    LEFT JOIN master.mcat_project cp ON cp.id_cat_project=a.id_cat_project
                     WHERE a.isproject='$p'
                    AND  concat(upper(a.cc_project_name),'',upper(a.id_cc_project),'',upper(mr.nama_rekanan)) like upper('%$getFilteredVal%')
                    ORDER BY a.id_cc_project ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function saveData($jenis)
    {


        if ($jenis == 'Project') {

            $year = substr($this->input->post('dt_order', true), -4);
            //get id
            //-$qNo = "SELECT master.fn_gen_id_supplier() AS new_no_trans";
            $rNo = $this->db->get('master.fn_gen_project_no(' . $year . ') as new_no_trans ')->row_array();
            $id = $rNo['new_no_trans'];

            $qrM = " INSERT INTO master.mcc_project (
                    id_cc_project,
                    cc_project_name,
                    manager,
                    kd_rekanan,
                    po_number,
                    dt_order,
                    dt_start,
                    dt_finish,
                    nilai,
                    id_curr,
                    kurs,
                    id_rek_gl,
                    isproject,
                    id_cat_project,
                    isactive,
                    budget,
                    tahun,
                    usr_ins,
                    usr_upd )
                VALUeS(
                     '" . $id . "',
                     '" . $this->input->post('cc_project_name', true) . "',
                     '" . $this->input->post('manager', true) . "',
                     '" . $this->input->post('kd_rekanan', true) . "',
                     '" . $this->input->post('po_number', true) . "',
                     to_timestamp('" . $this->input->post('dt_order', true) . "','dd/mm/yyyy'),
                     to_timestamp('" . $this->input->post('dt_start', true) . "','dd/mm/yyyy'),
                     to_timestamp('" . $this->input->post('dt_finish', true) . "','dd/mm/yyyy'),
                     " . $this->input->post('nilai', true) . ",
                     '" . $this->input->post('id_curr', true) . "',
                     " . $this->input->post('kurs', true) . ",
                     '" . $this->input->post('id_rek_gl', true) . "',
                     '1',
                     '" . $this->input->post('id_cat_project', true) . "',
                    '1',
                    0,
                    $year,
                    '" . $this->session->userdata('username') . "',
                    '" . $this->session->userdata('username') . "'
                )";
        } elseif ($jenis == 'Cost_center') {  // cost center

            $qrM = " INSERT INTO master.mcc_project (
                id_cc_project,
                cc_project_name,
                manager,
                kd_rekanan,
                po_number,
                dt_order,
                dt_start,
                dt_finish,
                nilai,
                id_curr,
                kurs,
                id_rek_gl,
                isproject,
                isactive,
                budget,
                tahun,
                usr_ins,
                usr_upd )
            VALUeS(
                 '" . $this->input->post('id_cc_project', true) . "',
                 '" . $this->input->post('cc_project_name', true) . "',
                 '" . $this->input->post('manager', true) . "',
                 NULL,
                 NULL,
                 NULL,
                 NULL,
                 NULL,
                 0,
                 'IDR',
                 1,
                 NULL,
                '0',
                '1',
                " . $this->input->post('budget', true) . ",
                NULL,
                '" . $this->session->userdata('username') . "',
                '" . $this->session->userdata('username') . "'
            )";
        };


        //$this->db->insert('master.mcc_project', $data);
        $this->db->query($qrM);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function editData($id)
    {
        //cek wether project or cost center
        $p = $this->db->get_where('master.mcc_project', ['id_cc_project' => $id])->row_array();

        // var_dump($p['isproject']);
        // die;
        if ($this->input->post('id_rek_gl', true) == '') {
            $idrek = 'NULL';
        } else {
            $idrek = "'" . $this->input->post('id_rek_gl', true) . "'";
        }

        if ($p['isproject'] == '1') {

            $year = substr($this->input->post('dt_order', true), -4);

            $qrM = "UPDATE master.mcc_project SET 
                cc_project_name = '" . $this->input->post('cc_project_name', true) . "',
                manager = '" . $this->input->post('manager', true) . "',
                kd_rekanan = '" . $this->input->post('kd_rekanan', true) . "',
                po_number = '" . $this->input->post('po_number', true) . "',
                dt_order = to_timestamp('" . $this->input->post('dt_order', true) . "', 'dd/mm/yyyy'),
                dt_start = to_timestamp('" . $this->input->post('dt_start', true) . "', 'dd/mm/yyyy'),
                dt_finish = to_timestamp('" . $this->input->post('dt_finish', true) . "', 'dd/mm/yyyy'),
                nilai = " . $this->input->post('nilai', true) . ",
                id_curr = '" . $this->input->post('id_curr', true) . "',
                kurs = " . $this->input->post('kurs', true) . ",
                id_rek_gl = " . $idrek . ",
                id_cat_project = '" . $this->input->post('id_cat_project', true) . "',
                isactive= '1',
                budget = 0,
                tahun = " . $year . ",
                usr_upd = '" . $this->session->userdata('username') . "'
                WHERE id_cc_project= '" . $id . "'";
        } else {

            $qrM = "UPDATE master.mcc_project SET 
                cc_project_name = '" . $this->input->post('cc_project_name', true) . "',
                manager = '" . $this->input->post('manager', true) . "',
                budget = " . $this->input->post('budget', true) . ",
                usr_upd = '" . $this->session->userdata('username') . "'
                WHERE id_cc_project= '" . $id . "'";
        };

        //$this->db->where('id_cc_project', $id);
        //$this->db->set($data);
        // var_dump($qrM);
        // die;

        $this->db->query($qrM);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function deleteData($id)
    {
        $this->db->where('id_cc_project', $id);
        $this->db->delete('master.mcc_project');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function getCatProject()
    {


        $query = "SELECT id_cat_project, descriptions 
                    FROM master.mcat_project 
                    WHERE 1=1
                    ORDER BY id_cat_project ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }
}

<?php

class Project_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getData()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qtotal = "SELECT a.*, 
                            mr.nama_rekanan  
                    FROM master.mcc_project a
                    LEFT JOIN master.mrekanan mr on mr.kd_rekanan=a.kd_rekanan 
                    WHERE a.isproject='1'
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
                     WHERE a.isproject='1'
                    AND  concat(upper(a.cc_project_name),'',upper(a.id_cc_project),'',upper(mr.nama_rekanan)) like upper('%$getFilteredVal%')
                    ORDER BY a.id_cc_project ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);
        //$result["rows"] = $rows;
        return $result;
    }


    public function saveData()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];



            $year = substr($datmaster['dt_order'], -4);
            //get id
            //-$qNo = "SELECT master.fn_gen_id_supplier() AS new_no_trans";

            if ($datmaster['id_rek_gl'] == '') {
                $idrek = 'NULL';
            } else {
                $idrek = "'" . $datmaster['id_rek_gl'] . "'";
            }

            if ($datmaster['id_cc_project'] == '') { 
                $rNo = $this->db->get('master.fn_gen_project_no(' . $year . ') as new_no_trans ')->row_array();
                $id = $rNo['new_no_trans'];
            } else {
                $id = $datmaster['id_cc_project'];
            }


            $qrM = " INSERT INTO master.mcc_project (
                    id_cc_project,
                    cc_project_name,
                    manager,
                    kd_rekanan,
                    po_number,
                    dt_announcement,
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
                    lokasi,
                    usr_ins,
                    usr_upd )
                VALUES(
                     '" . $id . "',
                     '" . $datmaster['cc_project_name'] . "',
                     '" . $datmaster['manager'] . "',
                     '" . $datmaster['kd_rekanan'] . "',
                     '" . $datmaster['po_number'] . "',
                     to_timestamp('" . $datmaster['dt_announcement'] . "','dd/mm/yyyy'),
                     to_timestamp('" . $datmaster['dt_order'] . "','dd/mm/yyyy'),
                     to_timestamp('" . $datmaster['dt_start'] . "','dd/mm/yyyy'),
                     to_timestamp('" . $datmaster['dt_finish'] . "','dd/mm/yyyy'),
                     " . $datmaster['nilai'] . ",
                     'IDR',
                     1,
                     " . $idrek . ",
                     '1',
                     '" .  $datmaster['id_cat_project'] . "',
                    '1',
                    0,
                    $year,
                    '" .  $datmaster['lokasi'] . "',
                    '" . $this->session->userdata('username') . "',
                    '" . $this->session->userdata('username') . "'
                )";
        
                // var_dump($qrM);
                // die;

        //$this->db->insert('master.mcc_project', $data);
        $this->db->query($qrM);
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function updatePro()
    {
        $datmaster = $this->input->post('info', true)[0]['master'][0];
        
        if ($datmaster['id_rek_gl'] == '') {
            $idrek = 'NULL';
        } else {
            $idrek = "'" . $datmaster['id_rek_gl'] . "'";
        }


            $year = substr($datmaster['dt_order'], -4);

            $qrM = "UPDATE master.mcc_project SET 
                id_cc_project = '" . $datmaster['id_cc_project'] . "',
                cc_project_name = '" . $datmaster['cc_project_name'] . "',
                manager = '" . $datmaster['manager'] . "',
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                po_number = '" . $datmaster['po_number'] . "',
                dt_announcement = to_timestamp('" . $datmaster['dt_announcement'] . "', 'dd/mm/yyyy'),
                dt_order = to_timestamp('" . $datmaster['dt_order'] . "', 'dd/mm/yyyy'),
                dt_start = to_timestamp('" .$datmaster['dt_start'] . "', 'dd/mm/yyyy'),
                dt_finish = to_timestamp('" . $datmaster['dt_finish'] . "', 'dd/mm/yyyy'),
                nilai = " . $datmaster['nilai'] . ",
                id_rek_gl = " . $idrek . ",
                id_cat_project = '" . $datmaster['id_cat_project'] . "',
                lokasi = '" . $datmaster['lokasi'] . "',
                tahun = " . $year . ",
                usr_upd = '" . $this->session->userdata('username') . "'
                WHERE id_cc_project= '" . $datmaster['idx'] . "'";
 
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

    public function getManager()
    {
        $query = "SELECT    a.nk, 
                            a.full_name
                    FROM master.mpegawai a
                    WHERE a.isactive='1'
                    ORDER BY a.full_name ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }


}

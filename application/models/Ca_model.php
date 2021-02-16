<?php

class Ca_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        //        $this->load->database();
    }

    public function getCa()
    {

        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;

        $dt_awal = !is_null($this->input->post('dt_awal')) ? $this->input->post('dt_awal') : '';
        $dt_akhir = !is_null($this->input->post('dt_akhir')) ? $this->input->post('dt_akhir') : '';

        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';

        if ($this->session->userdata('role') == 'admin') {
            $where_str = '';
        } else {
            $data = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
            $where_str = "AND a.kd_rekanan= '" . $data['nk'] . "'";
        }


        $qrM = "SELECT a.*, mr.nama_rekanan
                    FROM accfin.kasbon a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' " . $where_str . "
                    AND a.dt_purposed::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_kasbon),'',upper(a.kasbon_untuk)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.id_kasbon, 
                            a.no_kasbon, 
                            to_char(a.dt_purposed, 'DD-Mon-YYYY') as dt_purposed,
                            to_char(a.dt_purposed, 'dd/mm/yyyy') as dt_purposed_char,
                            a.kd_rekanan, 
                            mr.nama_rekanan, 
                            a.lampiran,
                            a.kasbon_untuk,
                            a.id_cc_project,
                            a.id_rek_gl_debet,
                            a.id_curr,
                            a.kurs,
                            a.remarks, 
                            a.usr_ins,
                            a.usr_upd,
                            a.ispost, 
                            a.iscancel, 
                            a.jumlah,
                            a.tunggakan,
                            a.po_number,
                            a.ispersonal
                    FROM accfin.kasbon a
                    LEFT JOIN master.mrekanan mr ON mr.kd_rekanan=a.kd_rekanan
                    WHERE a.isdelete='0' " . $where_str . "
                    AND a.dt_purposed::date between to_date ('" . $dt_awal . "', 'dd-mm-yyyy ') AND to_date ('" . $dt_akhir . "', 'dd-mm-yyyy')
                    AND  concat(upper(mr.nama_rekanan),'',upper(a.no_kasbon),'',upper(a.kasbon_untuk)) like upper('%$getFilteredVal%') 
                    ORDER BY a.no_kasbon ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    private function getTransid($seq)
    {
        $rIdx = $this->db->get("NEXTVAL('" . $seq . "') as idx")->row_array();
        $id = $rIdx['idx'];

        return $id;
    }

    // private function getJenisCa($vca)
    // {
    //     switch ($vca) {
    //         case '01':
    //             return "Personal";
    //             break;
    //         case '10':
    //             return "Operational";
    //             break;
    //         case '11':
    //             return "Down Payment";
    //             break;
    //     }
    // }


    public function saveCa()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];

        // var_dump($datmaster);
        // die;

        $vmm = trim(substr($datmaster['dt_purposed'], 3, 2));
        $vyy = trim(substr($datmaster['dt_purposed'], 6, 4));

        //get no_trans
        $rNo = $this->db->get("accfin.fn_gen_kasbon_number('" . $datmaster['idtrans'] . "') as new_no_trans")->row_array();
        $no_trans = $rNo['new_no_trans'];

        // get index 
        $id = $this->getTransid('accfin.sq_kasbon');

        // get jenis ca
        if ($datmaster['kasbon_untuk'] == 'Personal') {
            $jca = '1';
        } else {
            $jca = '0';
        }

        //build query insert master
        $qrM = "INSERT INTO accfin.kasbon (
         id_kasbon, kd_rekanan, no_kasbon, 
         id_cc_project, kasbon_untuk,
         jumlah, prepared_by, usr_ins,
         usr_upd, dt_prepared, dt_purposed,
         status_auth, ispost, iscancel, isdelete, isclosed, id_trans,
         tunggakan, remarks, id_rek_gl_debet,
         id_curr, kurs, ispersonal, po_number,
         bulan, tahun)
         VALUES (
          $id, '" . $datmaster['kd_rekanan'] . "','" . $no_trans . "',
          '" . $datmaster['id_cc_project'] . "', '" . $datmaster['kasbon_untuk'] . "',
          " . $datmaster['jumlah'] . ", '" . $this->session->userdata('username') . "', '" . $this->session->userdata('username') . "',
          '" . $this->session->userdata('username') . "', to_timestamp('" . $datmaster['dt_purposed'] . "','dd/mm/yyyy'), to_timestamp('" . $datmaster['dt_purposed'] . "','dd/mm/yyyy'),
          'PREPARED', '0', '0', '0', '0', '" . $datmaster['idtrans'] . "',
          COALESCE(" . $datmaster['tunggakan'] . ",NULL,NULL),'" . $datmaster['remarks'] . "','" . $datmaster['id_rek_gl_debet'] . "',
          'IDR',1,'" . $jca . "', NULL,
          to_number('" . $vmm . "','99' ),to_number('" . $vyy . "','9999' ) );";

        // var_dump($qrM);
        // die;


        $this->db->trans_begin();
        $this->db->query($qrM);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function editCa($id)
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];


        $vmm = trim(substr($datmaster['dt_purposed'], 3, 2));
        $vyy = trim(substr($datmaster['dt_purposed'], 6, 4));

        // get jenis ca
        if ($datmaster['kasbon_untuk'] == 'Personal') {
            $jca = '1';
        } else {
            $jca = '0';
        }

        $qrM = "UPDATE accfin.kasbon SET
                kd_rekanan = '" . $datmaster['kd_rekanan'] . "',
                id_cc_project ='" . $datmaster['id_cc_project'] . "', 
                lampiran = NULL,
                kasbon_untuk = '" . $datmaster['kasbon_untuk'] . "',
                jumlah =  " . $datmaster['jumlah'] . ",
                prepared_by = '" . $this->session->userdata('username') . "',
                dt_prepared = CURRENT_TIMESTAMP,
                dt_purposed = to_timestamp('" . $datmaster['dt_purposed'] . "','dd/mm/yyyy'),
                tunggakan = COALESCE(" . $datmaster['tunggakan'] . ",NULL,NULL),
                remarks = '" . $datmaster['remarks'] . "',
                id_rek_gl_debet = '" . $datmaster['id_rek_gl_debet'] . "',
                ispersonal = '" . $jca . "',
                bulan = to_number('" . $vmm . "','99' ),
                tahun = to_number('" . $vyy . "','9999' ), 
                usr_upd ='" . $this->session->userdata('username') . "'
                WHERE id_kasbon=" . $id . ";";


        // var_dump($qrM);
        // var_dump($qrD);
        // die;


        $this->db->trans_begin();
        $this->db->query($qrM);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $hasil = $this->db->affected_rows();
        return $hasil;
    }

    public function deleteCa($id)
    {
        $data =  array(
            'isdelete' => '1'
        );
        $this->db->where('id_kasbon', $id);
        $this->db->set($data);
        $hasil = $this->db->update('accfin.kasbon');
        return $hasil;
    }

    public function getRekanan()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan
                    FROM master.mrekanan a
                    WHERE a.jenis='PEGAWAI'
                    ORDER BY a.nama_rekanan ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
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

    public function getCoa()
    {
        $query = "SELECT * 
                    FROM master.vrek_advance 
                    ORDER BY id_rek_gl ASC ";
        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }
}

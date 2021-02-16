<?php

class Emp_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getEmp()
    {


        $page = !is_null($this->input->post('page')) ? $this->input->post('page') : 1;
        $rows = !is_null($this->input->post('rows')) ? $this->input->post('rows') : 10;

        $offset = ($page - 1) * $rows;


        $getFilteredVal = !is_null($this->input->post('searching')) ? $this->input->post('searching') : '';


        $qrM = "SELECT a.*
                    FROM master.mpegawai a
                    WHERE 1=1
                    AND  concat(upper(a.nk),'',upper(a.full_name)) like upper('%$getFilteredVal%')";

        $result = array();
        $result['total'] = $this->db->query($qrM)->num_rows();


        $query = "SELECT a.*,
                        to_char(a.join_date, 'dd/mm/yyyy') as join_date_char,
                        to_char(a.dt_hire, 'dd/mm/yyyy') as dt_hire_char,
                        to_char(a.dt_birth, 'dd/mm/yyyy') as dt_birth_char
                    FROM master.mpegawai a
                    WHERE 1=1
                    AND  concat(upper(a.nk),'',upper(a.full_name)) like upper('%$getFilteredVal%') 
                    ORDER BY a.nk ASC
                    LIMIT $rows OFFSET $offset";


        $data_x = $this->db->query($query)->result_array();
        $result = array_merge($result, ['rows' => $data_x]);

        return $result;
    }


    public function saveEmp()
    {


        $datmaster = $this->input->post('info', true)[0]['master'][0];
        
        // var_dump($datmaster['nk']);
        // die;

        // $d = $this->db->get_where('master.mdivisi', ['kd_divisi' => $datmaster['kd_divisi']])->row_array();
        // $dep =  $d['deskripsi'];

        $qrM = "INSERT INTO master.mpegawai (
                    nk, full_name, initial,
                    email, birth_place, cell_phone,
                    address, state, kota, nik,
                    phone1, negara, postal_code,
                    dt_birth, gender, religion,
                    blood_type, status_kawin,


                    join_date, status_karyawan, isactive,
                    kd_divisi, kd_spv, jabatan,

                    education, dt_hire, universitas,
                    faculty, department,

                    bank, bank_cabang, bank_account,
                    npwp, ptkp, gaji_pokok,
                    usr_ins, usr_upd)
            VALUES (
            '" . $datmaster['nk'] . "','" . $datmaster['full_name'] . "','" . $datmaster['initial'] . "', 
            '" . $datmaster['email'] . "', '" . $datmaster['birth_place'] . "', '" . $datmaster['cell_phone'] . "',
            '" . $datmaster['address'] . "', '" . $datmaster['state'] . "', '" . $datmaster['kota'] . "', '" . $datmaster['nik'] . "',
            '" . $datmaster['phone1'] . "', '" . $datmaster['negara'] . "', '" . $datmaster['postal_code'] . "',
            to_timestamp('" . $datmaster['dt_birth'] . "','dd-mm-yyyy'), '" . $datmaster['gender'] . "', '" . $datmaster['religion'] . "',
            '" . $datmaster['blood_type'] . "', '" . $datmaster['status_kawin'] . "',

            to_timestamp('" . $datmaster['join_date'] . "','dd-mm-yyyy'), '" . $datmaster['status_karyawan'] . "', '" . $datmaster['isactive'] . "',
            '" . $datmaster['kd_divisi'] . "', '" . $datmaster['kd_spv'] . "', '" . $datmaster['jabatan'] . "',

            '" . $datmaster['education'] . "', to_timestamp('" . $datmaster['dt_hire'] . "','dd-mm-yyyy'), '" . $datmaster['universitas'] . "',
            '" . $datmaster['faculty'] . "', '" . $datmaster['department'] . "',

            '" . $datmaster['bank'] . "', '" . $datmaster['bank_cabang'] . "', '" . $datmaster['bank_account'] . "',
            '" . $datmaster['npwp'] . "', '" . $datmaster['ptkp'] . "', " . $datmaster['gaji_pokok'] . ",


            '" . $this->session->userdata('username') . "', '" . $this->session->userdata('username') . "');";

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


    public function updateEmp()
    {

        $datmaster = $this->input->post('info', true)[0]['master'][0];

        // var_dump($datmaster['dt_release']);
        // die;
        if ($datmaster['dt_release'] == '') {
            $dt_release = "NULL";
        } else {
            $dt_release = "to_timestamp('" . $datmaster['dt_release'] . "','dd-mm-yyyy')";
        }


        $qrM = "UPDATE master.mpegawai SET
                nk = '" . $datmaster['nk'] . "',
                initial = '" . $datmaster['initial'] . "',
                full_name = '" . $datmaster['full_name'] . "',
                email = '" . $datmaster['email'] . "',
                address = '" . $datmaster['address'] . "',
                kota = '" . $datmaster['kota'] . "',
                state = '" . $datmaster['state'] . "',
                cell_phone = '" . $datmaster['cell_phone'] . "',
                gender = '" . $datmaster['gender'] . "',
                religion = '" . $datmaster['religion'] . "',
                phone1 = '" . $datmaster['phone1'] . "',
                negara = '" . $datmaster['negara'] . "',
                birth_place = '" . $datmaster['birth_place'] . "',
                dt_birth  = to_timestamp('" . $datmaster['dt_birth'] . "','dd-mm-yyyy'),
                nik = '" . $datmaster['nik'] . "',
                postal_code = '" . $datmaster['postal_code'] . "',
                status_kawin = '" . $datmaster['status_kawin'] . "',
                blood_type = '" . $datmaster['blood_type'] . "',


                join_date  = to_timestamp('" . $datmaster['join_date'] . "','dd-mm-yyyy'),
                kd_divisi =  '" . $datmaster['kd_divisi'] . "',
                isactive = '" . $datmaster['isactive'] . "',
                status_karyawan = '" . $datmaster['status_karyawan'] . "',
                jabatan = '" . $datmaster['jabatan'] . "',
                dt_release = ". $dt_release .",
                kd_spv = '" . $datmaster['kd_spv'] . "',


                department = '" . $datmaster['department'] . "',
                dt_hire = to_timestamp('" . $datmaster['dt_hire'] . "','dd-mm-yyyy'),
                education  = '" . $datmaster['education'] . "',
                universitas  = '" . $datmaster['universitas'] . "',
                faculty  = '" . $datmaster['faculty'] . "',
                keahlian  = '" . $datmaster['keahlian'] . "',

                bank = '" . $datmaster['bank'] . "',
                bank_cabang = '" . $datmaster['bank_cabang'] . "',
                bank_account = '" . $datmaster['bank_account'] . "',
                npwp = '" . $datmaster['npwp'] . "',
                ptkp = '" . $datmaster['ptkp'] . "',
                gaji_pokok = " . $datmaster['gaji_pokok'] . ",
                usr_upd ='" . $this->session->userdata('username') . "'
                WHERE nk='" . $datmaster['id_nk'] . "' ;";

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

    public function destroyEmp($id)
    {
        $this->db->where('nk', $id);
        $this->db->delete('master.mpegawai');
        $hasil = $this->db->affected_rows();
        return $hasil;
    }


    public function getDivisi()
    {
        $query = "SELECT kd_divisi, deskripsi
                    FROM master.mdivisi 
                    -- WHERE isdetail='1'
                    ORDER BY kd_divisi ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getSpv()
    {
        $query = "SELECT nk, full_name
                    FROM master.mpegawai 
                    WHERE 1=1
                    ORDER BY nk ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }
}

<?php

class DataMaster_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getCoa()
    {


        $query = "SELECT * 
                    FROM master.mrek_gl 
                    WHERE isdetail='1'
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getCoaProject()
    {
        $query = "SELECT a.* 
                    FROM master.vrek_biaya_project a    
                     WHERE 1=1
                     ORDER BY a.id_rek_gl ASC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getCoaExpense()
    {
        $query = "SELECT * 
                    FROM master.vrek_biaya_office 
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getCoaPendapatan()
    {


        $query = "SELECT * 
                    FROM master.mrek_gl 
                    WHERE isdetail='1' and id_parent='4100'
                    ORDER BY id_rek_gl ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getCcproject()
    {


        $query = "SELECT *, 
                    (CASE WHEN isproject='1' THEN 'Project'
                          WHEN isproject='0' THEN 'Cost Center'
                    END)::varchar(15) as vccpro 
                    FROM master.mcc_project 
                    WHERE isactive='1' 
                    ORDER BY id_cc_project ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getProject()
    {


        $query = "SELECT * 
                    FROM master.mcc_project 
                    WHERE isactive='1' and isproject='1'
                    ORDER BY id_cc_project ASC ";

        $result = array();
        $result = $this->db->query($query)->result_array();

        return $result;
    }


    public function getVendor()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis
                    FROM master.mrekanan a
                    ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getCustomer()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis,
                            a.alamat
                    FROM master.mrekanan a
                    WHERE a.jenis='CUSTOMER'
                    ORDER BY a.nama_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function getSupplier()
    {
        $query = "SELECT    a.kd_rekanan, 
                            a.nama_rekanan, 
                            a.Jenis
                    FROM master.mrekanan a
                    WHERE a.jenis='SUPPLIER'
                    ORDER BY a.kd_rekanan ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function getEmployee()
    {
        $query = "SELECT    a.nk as kd_rekanan, 
                            a.full_name as nama_rekanan, 
                            'PEGAWAI' as jenis
                    FROM master.mpegawai a
                    WHERE 1=1
                    ORDER BY a.full_name ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getCurrency()
    {
        $query = "SELECT    a.id_curr, 
                            a.description
                    FROM master.mcurrency a
                    ORDER BY a.description ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getUnit()
    {
        $query = "SELECT    a.kd_satuan, 
                            a.deskripsi
                    FROM master.satuan a
                    ORDER BY a.deskripsi ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getItemType()
    {
        $query = "SELECT    a.item_type_id, 
                            a.item_type_name
                    FROM master.mitem_type a
                    ORDER BY a.item_type_name ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getItem()
    {
        $query = "SELECT    a.kd_item, 
                            a.nama_item,
                            a.kd_satuan,
                            a.kd_satuan_beli,
                            a.item_type_id,
                            t.item_type_name
                    FROM master.mitem a
                    LEFT JOIN master.mitem_type t ON t.item_type_id=a.item_type_id
                    ORDER BY a.kd_item ASC";

        $result = array();

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getKasBankAcc($cb)
    {
        $query = "SELECT    a.*
                    FROM master.cash_bank_acc a
                    WHERE a.jenis='" . $cb . "'
                    ORDER BY a.id_rek_gl ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getPaymentTerm()
    {
        $query = "SELECT * from master.mparameter
                    WHERE param_kind='PT' or param_kind='TM'
                    ORDER BY id_param ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function getDeliveryTerm()
    {
        $query = "SELECT description from master.delivery_term
                    ORDER BY delivery_term_id ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getDeliveryPlace()
    {
        $query = "SELECT kd_del_place, descriptions, alamat, kota, propinsi 
                    from master.delivery_place
                    ORDER BY kd_del_place ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getVuser()
    {
        $query = "SELECT vuser, full_name 
                    from master.vuser
                    ORDER BY vuser ASC";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }


    public function getPerusahaan()
    {
        $query = "SELECT *
                    from master.perusahaan
                    WHERE isactive='1'";

        $result = array();
        $result = $this->db->query($query)->result_array();
        return $result;
    }
}

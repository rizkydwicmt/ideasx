<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataMaster extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };
        $this->load->model('DataMaster_model');
    }



    public function getCoa()
    {
        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getCoa();
        echo json_encode($data);
    }


    public function getProject()
    {
        $this->output->set_content_type('application/json');
        $data = $this->DataMaster_model->getProject();
        echo json_encode($data);
    }



    public function getVendor()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getVendor();
        echo json_encode($vdata);
    }

    public function getCustomer()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getCustomer();
        echo json_encode($vdata);
    }

    public function getSupplier()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getSupllier();
        echo json_encode($vdata);
    }

    public function getEmployee()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getEmployee();
        echo json_encode($vdata);
    }

    public function getCurrency()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getCurrency();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getUnit();
        echo json_encode($vdata);
    }

    public function getItemType()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getItemType();
        echo json_encode($vdata);
    }

    public function getItem()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->DataMaster_model->getItem();
        echo json_encode($vdata);
    }
}

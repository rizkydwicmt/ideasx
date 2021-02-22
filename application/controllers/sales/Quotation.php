<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Quotation extends CI_Controller
{
    private $filename = "template";

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("username"))) {
            redirect(site_url(), 'refresh');
        };


        $this->load->model('Quotation_model');
        $this->load->model('DataMaster_model');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->helper('tegar_num');
    }

    public function index()
    {

        $role_id = $this->session->userdata('role');

        // if ($role_id == 'admin') {

        //     $data['user'] = $this->db->get_where('master.vuser', ['vuser' => 'ideas'])->row_array();
        // } elseif ($role_id == 'user') {
        $data['user'] = $this->db->get_where('master.vuser_data', ['vuser' => $this->session->userdata('username')])->row_array();
        // }

        $data['curlx'] = $this->uri->segment(2);

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['notrans'] =  $noTrans['id_trans'];
        $data['tittle'] = $noTrans['menu_name'];


        $ds = $this->session->userdata('qts');
        if ($ds) {
            $data['dtnow'] = $ds['dt'];
            $this->session->unset_userdata('qts');
        } else {
            $data['dtnow'] = "today";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sales/v_quotation', $data);
        $this->load->view('templates/footer');
    }


    public function getQuot()
    {

        $this->output->set_content_type('application/json');
        $data = $this->Quotation_model->getQuot();
        echo json_encode($data);
    }


    public function getQuotDetail($idd)
    {
        $data = $this->Quotation_model->getQuotDetail($idd);
        $this->output->set_content_type('application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getMasterData()
    {
        $idx = $this->input->post("idx", true);

        $q = "SELECT 
                a.id_qt, 
                a.no_qt, 
                a.id_qs, 
                a.no_qs,
                to_char(a.dt_qt,'dd-mm-yyyy') as dt_qt,
                a.kd_rekanan,
                a.nama_rekanan,
                a.proposal_description,
                a.revision,
                a.sub_total,
                a.vat_num,
                a.total,
                a.sub_total_quot,
                a.vat_num_quot,
                a.total_quot,
                a.margin_psn,
                a.nama_kontak,
                a.lampiran,
                a.pterm,
                a.id_cat_project,
                cp.descriptions as cpdescriptions
            from sales.quotation a
            LEFT JOIN master.mcat_project cp ON cp.id_cat_project=a.id_cat_project
            WHERE a.id_qt = " . $idx . ";";

        $xQuot = $this->db->query($q)->result_array();
        // var_dump($xQuot);
        // die;
        if ($xQuot) {
            echo json_encode($xQuot);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getDetailData()
    {
        $idd = $this->input->post("idx", true);

        $query = "SELECT a.id_qt,
                    a.id_qt_detail,
                    a.id_parent,
                    a.kd_item,
                    a.kd_pi,
                    a.descriptions,
                    a.kd_satuan,
                    a.qty,
                    a.unit_price,
                    a.extended,
                    a.margin_psn,
                    a.quot_price,
                    a.quot_extended,
                    p.parentname 
        FROM sales.quotation_detail a
        LEFT JOIN  sales.quote_item_group p ON p.id_parent=a.id_parent
        WHERE a.id_qt= " . $idd . "
        ORDER BY a.id_qt_detail ASC";


        $data_x = $this->db->query($query)->result_array();
        $this->output->set_content_type('application/json');
        if ($data_x) {
            echo json_encode($data_x);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function getQuotRemarks()
    {
        $idd = $this->input->post("idx", true);
        $data = $this->Quotation_model->getQRemarks($idd);
        $this->output->set_content_type('application/json');

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }


    public function loadQuot()
    {
        //var_dump($dtx);

        //$datax = $this->input->post("data", true);
        $datax = $this->session->userdata('qts');
        // var_dump($datax['m']);
        // die;

        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];


        if ($datax['m'] ==  'e') {
            $data['mode'] =  'edit';
            $data['caption'] = 'Edit Quotation [BOQ]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = $datax['id'];
        } elseif ($datax['m'] ==  'a') {
            $data['mode'] =  'add';
            $data['caption'] = 'New Quotation [BOQ]';
            $data['dtx'] = $datax['dt'];
            $data['idx'] = '0';
        }
        $this->load->view('templates/i_topbar', $data);
        $this->load->view('sales/i_quotation', $data);
    }


    public function newQuot()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['m'] = 'a';
        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('qts', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function editQuot()
    {
        $data['dt'] = $this->input->post("dtx", true);
        $data['id'] = $this->input->post("id", true);
        $data['m'] = 'e';

        $this->output->set_content_type('application/json');
        if ($data) {
            $this->session->set_userdata('qts', $data);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function revQuot($datax)
    {
        $noTrans = $this->db->get_where('master.menu_web', ['url_active' => $this->uri->segment(2)])->row_array();
        $data['idtrans'] =  $noTrans['id_trans'];

        $i = strrpos($datax, 'x');
        $dtx = substr($datax, $i + 1);
        $idx = substr($datax, 0, $i);
        $data['dtx'] = $dtx;
        $data['idx'] = $idx;

        $data['mode'] =  'rev';
        $data['caption'] = 'Revision Quotation [BOQ]';

        $this->load->view('sales/i_quotation', $data);
    }

    public function insertQuot()
    {
        $input = $this->Quotation_model->saveQuot('add');

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function revisionQuot()
    {

        $input = $this->Quotation_model->saveQuot('rev');

        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }


    public function updateQuot()
    {
        $input = $this->Quotation_model->editQuot();
        if ($input) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }

    public function updateStatusQuot()
    {
        $input = $this->Quotation_model->editStatusQuot();
        if ($input) {
            echo json_encode(['success' => $input]);
        } else {
            echo json_encode(['Msg' => 'Some Error occured!.']);
        }
    }



    public function destroyQuot()
    {
        $id = $this->input->post("id", true);
        $input = $this->Quotation_model->deleteQuot($id);

        if ($input) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    public function cetakQuot($id)
    {


        $data['g'] = $this->Quotation_model->getParentCetak($id);
        $data['m'] = $this->Quotation_model->getMCetak($id);
        $data['d'] = $this->Quotation_model->getDCetak($id);
        $data['r'] = $this->Quotation_model->getRCetak($id);
        $data['p'] = $this->DataMaster_model->getPerusahaan();

        $this->load->view('sales/r_quotation', $data);
    }


    //look data
    public function getItem()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getItem();
        echo json_encode($vdata);
    }

    public function getUnit()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getUnit();
        echo json_encode($vdata);
    }


    public function getParent()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getParent();
        echo json_encode($vdata);
    }

    public function getCatProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getCatProject();
        echo json_encode($vdata);
    }



    public function getCustomer()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getCustomer();
        echo json_encode($vdata);
    }

    public function getGitem()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getParent();
        echo json_encode($vdata);
    }


    public function getProject()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getProject();
        echo json_encode($vdata);
    }



    public function getQuotsheet()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getQsheet();
        // var_dump($vdata);

        echo json_encode($vdata);
    }


    public function  getDQuotsheet()
    {
        // $idqs = $this->input->post("idqs", true);
        // var_dump('masuk');
        // die;
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getDQuotsheet();
        echo json_encode($vdata);
    }



    public function  getDefaultRemarks()
    {
        $this->output->set_content_type('application/json');
        $vdata = $this->Quotation_model->getDefaultRemarks();
        echo json_encode($vdata);
    }

    //------------------------------IMPORT EXCEL ----------------------------------------

    public function importExcel()
    {
        $data = array(); // Buat variabel $data sebagai array
        $data['sheet'] = [];

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php

            $upload = $this->Quot_model->upload_file($this->filename);
            //var_dump($upload['result']);
            // die;

            if ($upload['result'] == "success") {

                // include APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'PHPExcel' . DIRECTORY_SEPARATOR . 'PHPExcel.php';

                // /*$excelreader = new PHPExcel_Reader_Excel2007();*/
                // $excelreader = new PHPExcel_Reader_Excel5();

                // $loadexcel = $excelreader->load('excel/' . $upload['file']['file_name']); // Load file yang tadi diupload ke folder excel
                // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                // $data['sheet'] = $sheet;
                // var_dump($sheet);
                // die;

                $extension = pathinfo('excel/' . $upload['file']['file_name'], PATHINFO_EXTENSION);


                if ($extension == 'csv') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif ($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }

                // file path
                $spreadsheet = $reader->load('excel/' . $upload['file']['file_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                // array Count
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $createArray = array('No', 'Deskripsi', 'Part_Number', 'Merk', 'Qty', 'Unit', 'Hpp', 'Sub_Total_HPP', 'Margin', 'Price', 'Sub_Total', 'Category', 'Lvl', 'Remarks');
                $makeArray = array(
                    'No' => 'No', 'Deskripsi' => 'Deskripsi', 'Part_Number' => 'Part_Number', 'Merk' => 'Merk', 'Qty' => 'Qty', 'Unit' => 'Unit', 'Hpp' => 'Hpp', 'Sub_Total_HPP' => 'Sub_Total_HPP', 'Margin' => 'Margin', 'Price' => 'Price', 'Sub_Total' => 'Sub_Total', 'Category' => 'Category', 'Lvl' => 'Lvl', 'Remarks' => 'Remarks'
                );

                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        }
                    }
                }
                $dataDiff = array_diff_key($makeArray, $SheetDataKey);
                // var_dump(json_encode($dataDiff));
                // die;

                if (empty($dataDiff)) {
                    $flag = 1;
                }

                // match excel sheet column
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        //$addresses = array();
                        $No = $SheetDataKey['No'];
                        $Deskripsi = $SheetDataKey['Deskripsi'];
                        $Part_Number = $SheetDataKey['Part_Number'];
                        $Merk = $SheetDataKey['Merk'];
                        $Qty = $SheetDataKey['Qty'];

                        $Unit = $SheetDataKey['Unit'];
                        $Hpp = $SheetDataKey['Hpp'];
                        $Sub_Total_HPP = $SheetDataKey['Sub_Total_HPP'];
                        $Margin = $SheetDataKey['Margin'];
                        $Price = $SheetDataKey['Price'];
                        $Sub_Total = $SheetDataKey['Sub_Total'];
                        $Category = $SheetDataKey['Category'];
                        $Lvl = $SheetDataKey['Lvl'];
                        $Remarks = $SheetDataKey['Remarks'];

                        $No = filter_var(trim($allDataInSheet[$i][$No]), FILTER_SANITIZE_STRING);
                        $Deskripsi = filter_var(trim($allDataInSheet[$i][$Deskripsi]), FILTER_SANITIZE_STRING);
                        $Part_Number = filter_var(trim($allDataInSheet[$i][$Part_Number]), FILTER_SANITIZE_EMAIL);
                        $Merk = filter_var(trim($allDataInSheet[$i][$Merk]), FILTER_SANITIZE_STRING);
                        $Qty = filter_var(trim($allDataInSheet[$i][$Qty]), FILTER_SANITIZE_STRING);

                        $Unit = filter_var(trim($allDataInSheet[$i][$Unit]), FILTER_SANITIZE_STRING);
                        $Hpp = filter_var(trim($allDataInSheet[$i][$Hpp]), FILTER_SANITIZE_STRING);
                        $Sub_Total_HPP = filter_var(trim($allDataInSheet[$i][$Sub_Total_HPP]), FILTER_SANITIZE_STRING);
                        $Margin = filter_var(trim($allDataInSheet[$i][$Margin]), FILTER_SANITIZE_STRING);
                        $Price = filter_var(trim($allDataInSheet[$i][$Price]), FILTER_SANITIZE_STRING);
                        $Sub_Total = filter_var(trim($allDataInSheet[$i][$Sub_Total]), FILTER_SANITIZE_STRING);
                        $Category = filter_var(trim($allDataInSheet[$i][$Category]), FILTER_SANITIZE_STRING);
                        $Lvl = filter_var(trim($allDataInSheet[$i][$Lvl]), FILTER_SANITIZE_STRING);
                        $Remarks = filter_var(trim($allDataInSheet[$i][$Remarks]), FILTER_SANITIZE_STRING);

                        $fetchData[] = array(
                            'No' => $No, 'descriptions' => $Deskripsi, 'part_number' => $Part_Number, 'merk' => $Merk,
                            'qty' => $Qty, 'id_unit' => $Unit, 'unit_price' => $Hpp, 'extended' => $Sub_Total_HPP,
                            'margin_psn' => $Margin, 'quot_price' => $Price, 'quot_extended' => $Sub_Total, 'id_parent' => $Category,
                            'lvl' => $Lvl, 'kd_item' => '', 'id_qs_detail' => 0, 'remarks' => $Remarks
                        );
                    }

                    // var_dump($fetchData);
                    // die;


                    //$data['rows'] = $fetchData;
                    // $this->site->setBatchImport($fetchData);
                    // $this->site->importData();
                } else {
                    echo "Please import correct file, did not match excel sheet column";
                }
            } else { // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }

        $resultx = array();
        $resultx['total'] = $arrayCount - 1;
        // $this->output->set_content_type('application/json');
        //$resultx = $data['rows'];
        $resultx = array_merge($resultx, ['rows' => $fetchData]);

        if ($resultx) {
            echo json_encode($resultx);
        } else {
            echo json_encode(array('errorMsg' => 'Some errors occured.'));
        }
    }

    /// ---------------------------- end of excel-----------------------------------

} ///0-0-0000

<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('memory_limit', '-1');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{


    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-35);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $isi_footer = '<hr>
                    <table cellspacing="0" cellpadding="2" width="550" border="0">
                        <tr >
                            <td width="65%" >Perum Surya Residence Cluster Emerald 1.F/02</td>
                            <td width="35%" align="right">www.idetama.id </td>
                        </tr>
                        <tr >
                            <td width="65%">Buduran - Sidoarjo</td>
                            <td width="35%" align="right">Telp. +6231-99681838</td>
                        </tr>
                    </table>';

        $this->writeHTML($isi_footer, true, false, false, false, '');
    }
}


$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Sales Invoice');
$pdf->SetFont("helvetica", "", 10);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Saridin_muhammadinov');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(10);

// remove default header/footer
$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

//var_dump($dpo['rows']);
// var_dump($dpo['rows'][0]['kd_item']);
// die;

$m = $m['rows'];

$pdf->AddPage();
// set JPEG quality
// $pdf->setJPEGQuality(75);
// $pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf ' . $id);
// $id = 'halo';    
//$this->Image('assets/img/logo.jpg', '', 5, '', '', '', '', 'C', true, 300, '', false, false, 0, true, false, true, false);
// $pdf->Image('assets/img/logo.jpg', 120, 25, 75, 25, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
// $pdf->SetFont("helvetica", "U", 14);
// $pdf->Write(100, 'PURCHASE ORDER');
//$pdf->Write(5, $id);

$html = '<table  cellspacing="0" cellpadding="2" width="550" height="209" style="border-bottom: 1px solid #000000;">
            <tr height="50" >
                <td align="left" width="550" height="50"><img src="assets/img/logo.jpg" width="180" height="46" alt=""/>
                </td>
            </tr>            
        </table>

        <table  cellspacing="0" cellpadding="2" width="550" height="209" style="border-bottom: 1px solid #000000;">
            <tr height="56">
            <td align="center" width="550" height="30" style="font-weight: bold; font-size: 20px;">INVOICE </td>
            </tr>
        </table>';

$pdf->SetFont("helvetica", "", 9);
$i = 0;

$html .= '<table  cellspacing="0" cellpadding="2" width="550" height="209" style="border: 1px solid #000000; font-size: 9px;">
            <tr style="font-weight: bold; font-size: 10px;">
                <td align="left" width="150" > INVOICE NO </td>
                <td align="center" width="10" >: </td>
                <td align="left" width="390" >' . $m[0]['no_sales_invoice'] . ' </td>
            </tr>
            <tr>
                <td > PENGUSAHA KENA PAJAK </td>
                <td ></td>
                <td > </td>
             </tr>
            <tr>
                <td> N a m a</td>
                <td>: </td>
                <td >' . $p[0]['perusahaan'] . ' </td>
             </tr>
             <tr>
                <td> A l a m a t</td>
                <td>: </td>
                <td>' . $p[0]['alamat_pajak'] . '</td>
            </tr>
            <tr>
                <td> N.P.W.P</td>
                <td>: </td>
                <td>' . $p[0]['npwp'] . '</td>
            </tr>
            <tr>
                <td> Tanggal Pengukuhan</td>
                <td>: </td>
                <td>' . $p[0]['dt_npwp_char'] . '</td>
            </tr>
        </table>

        <table  cellspacing="0" cellpadding="2" width="550" height="209"  style="border: 1px solid #000000; font-size: 9px;">   
            <tr height="15"  style="font-size: 10px;">
                <td colspan="2" align="left"  height="10" > PEMBELI BARANG KENA PAJAK/PENERIMA JASA KENA PAJAK</td>
                
            </tr>
            <tr>
                <td align="left" width="150" > N a m a</td>
                <td align="center" width="10">:</td>
                <td align="left" width="390">' . $m[0]['nama_rekanan'] . '</td>
             </tr>
             <tr>
                <td> A l a m a t</td>
                <td>: </td>
                <td>' . $m[0]['alamat_rekanan'] . '</td>
            </tr>
            <tr>
                <td> N.P.W.P</td>
                <td>: </td>
                <td>' . $m[0]['npwp'] . '</td>
            </tr>
        </table><br><br>';

$pdf->SetFont("helvetica", "", 9);


$html .= '<table cellspacing="0" cellpadding="2" width="550" >
            <tr style="font-size: 10px;" >
                <th width="5%" align="center" style=" border: 1px solid #000000;" >No Urut</th>
                <th width="55%" align="center" style=" border: 1px solid #000000;">Nama Barang Kena Pajak/
                <br>Jasa Kena Pajak
                </th>
                <th width="10%" align="center" style=" border: 1px solid #000000;">Qty</th>
                <th width="15%" align="center" style=" border: 1px solid #000000;">Harga Satuan
                <br>Unit Price<br>IDR
                </th>
                <th width="15%" align="center" style=" border: 1px solid #000000;">Jumlah Harga
                <br>Total Price<br>IDR
                </th>
            </tr>';


// foreach ($d['rows'] as $row) {
//     $i++;
//     $html .= '<tr>
//                 <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $i . '</td>
//                 <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $row['remarks'] . '</td>
//                 <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $row['qty'] . ' ' . $row['id_unit'] . '</td>
//                 <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $row['unit_price'] . '</td>
//                 <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $row['sub_total'] . '</td>
//             </tr>';
// }

$datdetail = $d['rows'];
$n = 0;
$c  = count($datdetail);
// $c = 5;
for ($x = 0; $x <= $c - 1; $x++) {
    $n = $n + 1;
    $html .= '<tr>
                <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $n . '</td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['remarks'] . '</td>
                <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['qty'] . ' ' . $datdetail[$x]['id_unit'] . '</td>
                <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['unit_price'] . '</td>
                <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['sub_total'] . '</td>
            </tr>';
};


$cx = 8 - $c;
for ($y = 0; $y <= $cx; $y++) {
    if ($y == 7) {
        $html .= '<tr>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">Sesuai PO/Kontrak No. ' . $m[0]['no_kontrak'] . ' Tgl. ' . $m[0]['dt_contract_char'] . '</td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
            </tr>';
    } else {
        $html .= '<tr>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;"></td>
            </tr>';
    };
};


$html .= '<tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;" >Jumlah Harga Jual</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['sub_total'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">Dikurangi potongan harga</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['disc'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">Dasar Pengenaan Pajak</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['dpp'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">Pajak Pertambahan Nilai</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['vat_num'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">Total Invoice</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['total'] . ' </td>
        </tr>
        </table>

        <table cellspacing="0" cellpadding="2" width="550" border="0">
            <tr >
                <td width="85%"></td>
                <td width="15%"> </td>
            </tr>
            <tr >
                <td width="85%" colspan="4" height="15" style="border: none;">Terbilang :</td>
                <td width="15%"> </td>
            </tr>
            <tr >
                <td colspan="4" height="15" align="left" style="font-size: 10px; background-color:#D1D1D1;">' . $m[0]['terbilang'] . '</td>
                <td align="right"></td>
            </tr>
        </table>';


$html .= '<table cellspacing="0" cellpadding="2" width="550" border="0">
            <tr >
                <td width="40%"></td>
                <td width="30%"></td>
                <td width="30%"> </td>
            </tr>
            <tr >
                <td width="40%">Bank Transfer :</td>
                <td width="30%"></td>
                <td width="30%"></td>
            </tr>
            <tr >
                <td width="40%">' . $p[0]['perusahaan'] . ' </td>
                <td width="30%"></td>
                <td width="30%" align="center">Sidoarjo, ' . $m[0]['dt_sales_invoice_char'] . ' </td>
            </tr>
            <tr >
                <td width="40%">' . $m[0]['no_acc'] . ' </td>
                <td width="30%"></td>
                <td width="30%"> </td>
            </tr>
            <tr >
                <td width="40%">' . $m[0]['bank_transfer'] . ' </td>
                <td width="30%"></td>
                <td width="30%"> </td>
            </tr>
            <br>
            <tr >
                <td width="40%">Keterangan :</td>
                <td width="30%"></td>
                <td width="30%" align="center" style="text-decoration: underline;">' . $p[0]['direktur'] . '</td>
            </tr>
            <tr >
                <td width="40%">' . $m[0]['remarks'] . ' </td>
                <td width="30%"></td>
                <td width="30%" align="center">Direktur </td>
            </tr>

            <tr >
                <td width="70%" colspan="2">* Pembayaran dengan cek / giro dianggap lunas setelah cek / giro tersebut dicairkan. </td>
                <td width="30%"></td>
            </tr>
            </table>';




$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("AR.pdf", "I");

<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('memory_limit', '-1');




$pdf = new pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Surat Invoice');
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
$text = '';
foreach ($d['rows'] as $row) {
    if ($text == '') {
        $text = $row['remarks'];
    } else {
        $text = $text  . ', ' . $row['remarks'];
    }
}

$html = '<table  cellspacing="0" cellpadding="2" width="550" height="209" border="0">
            <tr>
                <td rowspan="3" align="left" width="400" height="50"><img src="assets/img/logo.jpg" width="180" height="46" alt=""/>
                </td>
                <td width="150" height="20" align="center" style="font-weight: bold; font-size: 10px; border: 1px solid #000000;">Kwitansi No. ' . $m[0]['no_sales_invoice'] . '
               </td>
            </tr> 
            <tr>
                <td ></td>
            </tr> 
            <tr>
                <td ></td>
            </tr>                       

        </table>';

$pdf->SetFont("helvetica", "", 10);
$i = 0;

$html .= '<table  cellspacing="0" cellpadding="2" width="550" height="209" border="0">
            <tr>
            <td height="10"></td>
            <td height="10"></td>
            <td height="10"></td>
            </tr>
            <tr >
                <td align="left" width="150" >Sudah Terima Dari</td>
                <td align="center" width="10" >: </td>
                <td align="left" width="390" style="font-weight: bold; font-size: 10px;" >' . strtoupper($m[0]['nama_rekanan']) . ' </td>
            </tr>
            <tr>
                <td height="5"></td>
                <td height="5"></td>
                <td height="5"></td>
            </tr>
            <tr>
                <td>Jumlah Uang </td>
                <td>: </td>
                <td rowspan="2" align="left" style="font-size: 10px; background-color:#D1D1D1;">' . $m[0]['terbilang'] . '</></td>
            </tr>
            <tr>
                <td height="5"></td>
                <td height="5"></td>
            </tr>
            <tr>
                <td height="10"></td>
                <td height="10"></td>
                <td height="10"></td>
            </tr>
            <tr>
                <td>Buat Pembayaran </td>
                <td>: </td>
                <td rowspan="4" align="left" style="font-size: 10px;">' . $text . '</td>
            </tr>
            <tr>
                <td height="30"></td>
                <td height="30"></td>
            </tr>  
            
            <tr>
            <td height="30"></td>
            <td height="30"></td>
        </tr> 
        </table><br><br>';

$pdf->SetFont("helvetica", "", 9);



$html .= '<table cellspacing="0" cellpadding="2" width="550" border="0">
            <tr >
                <td width="20%"></td>
                <td width="50%"></td>
                <td width="30%"> </td>
            </tr>
            <tr >
                <td width="20%">Terbilang :</td>
                <td width="30%" align="right" style=" font-weight: bold;  font-size: 11px;  border: 1px solid #000000;">Rp. ' . $m[0]['total'] . ' </td>
                <td width="30%"></td>
            </tr>
            <tr >
                <td colspan="2" align="center" width="70%"> </td>
                <td width="30%" align="center">Sidoarjo, ' . $m[0]['dt_sales_invoice_char'] . '</td>
            </tr>
            <tr >
                <td colspan="2" align="center" width="70%"> </td>
                <td width="30%" align="center">' . $p[0]['perusahaan'] . ' </td>
            </tr>
            <tr >
                <td colspan="2" align="center" width="70%"> </td>
                <td width="30%"> </td>
            </tr>
            <tr >
                <td colspan="2" align="center" width="70%"> </td>
                <td width="30%"> </td>
            </tr>
            <br>
            <tr >
                <td colspan="2" align="left" width="70%"></td>
                <td width="30%" align="center" style="text-decoration: underline;">' . $p[0]['direktur'] . '</td>
            </tr>
            <tr >
                <td width="40%"> </td>
                <td width="30%"></td>
                <td width="30%" align="center">Direktur </td>
            </tr>


            </table>';




$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("AR.pdf", "I");

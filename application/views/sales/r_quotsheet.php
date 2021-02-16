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
        $this->SetY(-22);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $isi_footer = '<table  cellspacing="0" cellpadding="2" width="550" height="209">
                        <tr height="60" >
                            <td align="left" width="550" height="50"><img src="assets/img/footer-ide.jpg" width="540" height="55" alt=""/>
                            </td>
                        </tr>            
                        </table>';

        $this->writeHTML($isi_footer, true, false, false, false, '');
    }
}


$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Quotsheet');
$pdf->SetFont("helvetica", "", 10);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Quotation');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetTopMargin(5);
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

$html = '<table  cellspacing="0" cellpadding="2" width="550" height="209">
            <tr height="60" >
                <td align="left" width="550" height="50"><img src="assets/img/header-ide.jpg" width="540" height="55" alt=""/>
                </td>
            </tr> 

            <tr height="5" >
            <td  >
            </td>
        </tr>            
        </table>';

$pdf->SetFont("helvetica", "", 9);
$i = 0;

$html .= '<table  cellspacing="0" cellpadding="1" width="550" height="209" style="font-size: 10px;">
            <tr style="font-weight: normal; font-size: 11px;">
                <td align="left" width="50" >Nomor </td>
                <td align="center" width="10" >: </td>
                <td align="left" width="250" >' . $m[0]['no_qs'] . ' </td>
                <td align="right" width="240" >Sidoarjo, ' . $m[0]['dt_qs_char'] . ' </td>

            </tr>
            <tr>
                <td>Kepada</td>
                <td>: </td>
                <td >' . $m[0]['nama_kontak'] . ' <br>' . $m[0]['nama_rekanan'] . '</td>
             </tr>

            <tr>
                <td>Hal</td>
                <td>: </td>
                <td>Penawaran' . $m[0]['remarks'] . ' ' . $m[0]['proposal_description'] . '</td>
            </tr>
            <tr>
                <td>Lamp.</td>
                <td>: </td>
                <td>' . $m[0]['lampiran'] . '</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
             </tr>
             <tr>
             <td colspan="4" align="left">Dengan Hormat,
             Sehubungan dengan permintaan penawaran untuk ' . $m[0]['remarks'] . ' : ' . $m[0]['proposal_description'] . '
             di ' . $m[0]['nama_rekanan'] . ' , dengan ini kami mengajukan penawaran dengan rincian sebagai berikut :
             
             </td>
          </tr>
        </table>
        <br><br>';

$pdf->SetFont("helvetica", "", 9);


$html .= '<table cellspacing="0" cellpadding="2" width="550" >
            <tr style="font-size: 10px;" >
                <th width="5%" align="center" style=" border: 1px solid #000000; font-size: 10px; background-color:#D1D1D1;">No</th>
                <th width="55%" align="center" style=" border: 1px solid #000000; font-size: 10px; background-color:#D1D1D1;">Deskripsi</th>
                <th width="10%" align="center" style=" border: 1px solid #000000; font-size: 10px; background-color:#D1D1D1;">Qty</th>
                <th width="15%" align="center" style=" border: 1px solid #000000; font-size: 10px; background-color:#D1D1D1;">Unit Price</th>
                <th width="15%" align="center" style=" border: 1px solid #000000; font-size: 10px; background-color:#D1D1D1;">Sub Total</th>
            </tr>';



$datdetail = $d['rows'];
$n = 0;
$c  = count($datdetail);
// $c = 5;
for ($x = 0; $x <= $c - 1; $x++) {
    $n = $n + 1;
    $html .= '<tr>
                <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $n . '</td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['descriptions'] . '</td>
                <td align="center" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['qty'] . ' ' . $datdetail[$x]['kd_satuan'] . '</td>
                <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['unit_price'] . '</td>
                <td align="right" style=" border-left: 1px solid #000000; border-right: 1px solid #000000;">' . $datdetail[$x]['extended'] . '</td>
            </tr>';
};



$html .= '<tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;" >Jumlah Harga Jual</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['sub_total'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">Pajak Pertambahan Nilai</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['vat_num'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="font-size: 9px;  border: 1px solid #000000;">TOTAL PENAWARAN</td>
            <td align="right" style="font-size: 9px;  border: 1px solid #000000;">' . $m[0]['total'] .  ' </td>
        </tr>
        </table>

        <table cellspacing="0" cellpadding="2" width="550" border="0">
            <tr >
                <td width="100%" height="15px"></td>
            </tr>
            <tr >
                <td width="100%" colspan="2" height="15" style="font-size: 11px; border: none;">Terbilang :</td>
            </tr>
            <tr >
                <td colspan="4" height="15" align="left" style="font-style:italic; font-size: 10px; background-color:#D1D1D1;">' . $m[0]['terbilang'] . ' RUPIAH' . '</td>
            </tr>
        </table>
        
        <table cellspacing="0" cellpadding="0" width="550" border="0">
        <tr >
            <td width="100%" height="15px"></td>
        </tr>
        <tr >
            <td width="100%" colspan="2" height="15" style="font-size: 11px;">Terms & Conditions :</td>
        </tr>';

$datremarks = $r;
$c  = count($datremarks);
for ($x = 0; $x <= $c - 1; $x++) {
    $html .= '
            <tr>
            <td width="20px" height="10px" align="left" style="font-size: 10px;">' .  $datremarks[$x]['nomor'] . '.' . '</td>
            <td width="520px" height="10px" align="left" style="font-size: 10px;">' .  $datremarks[$x]['descriptions'] . '</td>
            </tr>';
};


$html .=   '</table>
            <table cellspacing="0" cellpadding="0" width="550" border="0">
            <tr >
                <td width="100%" height="15px"></td>
            </tr>
            <tr >
                <td width="100%" colspan="2" height="15" style="font-size: 11px;">Payment Terms :</td>
            </tr>';

$datpay = explode('|', $m[0]['pterm']);

$c  = count($datpay);
for ($x = 0; $x <= $c - 1; $x++) {
    $html .= '
    <tr>
    <td width="520px" height="10px" align="left" style="font-size: 10px;">' .  $datpay[$x] . '</td>
    </tr>';
};
$html .=   '</table>
          <table  cellspacing="0" cellpadding="0" width="550" height="209" border="0" style="font-size: 10px;">
            <tr>
                <td></td>
             </tr>
             <tr>
                <td colspan="4" align="left">Demikian Penawaran kami, atas perhatian dan kesempatan yang diberikan kami
                    mengucapkan Terima Kasih yang sebesar-besarnya.
                    Kami tunggu kabar baiknya.
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
            <td>Hormat Kami</td>
            </tr>

            <tr>
            <td>' . $p[0]['perusahaan'] . ' </td>
            </tr>
            <tr>
            <td  height="50"> </td>
            </tr>

            <tr >
            <td width="30%" align="left" style="text-decoration: underline;">' . $p[0]['direktur'] . '</td>
             </tr>
             <tr >
             <td width="30%" align="left">Direktur </td>
         </tr>
        </table>';




$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("QUotation.pdf", "I");

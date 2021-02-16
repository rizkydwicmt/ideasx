<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('memory_limit', '-1');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    // Page footer
    public function Header()
    {
        // Position at 15 mm from bottom
        $this->SetY(3);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $isi_header = '<table  cellspacing="0" cellpadding="0" width="535" height="60" >
                    <tr height="60" >
                        <td align="left" width="530" height="50"><img src="assets/img/header-ide.jpg" width="530" height="55" alt=""/>
                        </td>
                    </tr>            
                </table>';

        $this->writeHTML($isi_header, true, false, false, false, '');
    }


    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $isi_footer = '<table  cellspacing="0" cellpadding="0" width="535" height="55">
                        <tr>
                            <td align="left" width="530" height="50"><img src="assets/img/footer-ide.jpg" width="530" height="55" alt=""/>
                            </td>
                        </tr>            
                        </table>';

        $this->writeHTML($isi_footer, true, false, false, false, '');
    }
}


$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Quotation');
$pdf->SetFont("helvetica", "", 10);
$pdf->SetAuthor($this->session->userdata('full_name'));
$pdf->SetDisplayMode('real', 'default');
// $pdf->SetTopMargin(25);
// $pdf->SetLeftMargin(10);

// remove default header/footer
// $pdf->setPrintHeader(true);
//$pdf->setPrintFooter(false);

// set margins
$pdf->SetMargins(10, 25, 35);
$pdf->SetHeaderMargin(35);
$pdf->SetFooterMargin(35);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// set image scale factor
// $pdf->setImageScale(150);

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

// $html = '<table  cellspacing="0" cellpadding="2" width="550" height="209">
//             <tr height="60" >
//                 <td align="left" width="550" height="50"><img src="assets/img/header-ide.jpg" width="540" height="55" alt=""/>
//                 </td>
//             </tr> 

//             <tr height="5" >
//             <td  >
//             </td>
//         </tr>            
//         </table>';

$pdf->SetFont("helvetica", "", 9);
$i = 0;

$html = '<table  cellspacing="0" cellpadding="1" width="530" height="209" style="font-size: 10px;">
            <tr style="font-weight: normal; font-size: 11px;">
                <td align="left" width="50" >Nomor </td>
                <td align="center" width="10" >: </td>
                <td align="left" width="250" >' . $m[0]['no_qt'] . ' </td>
                <td align="right" width="220" >Sidoarjo, ' . $m[0]['dt_qt_char'] . ' </td>

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


$html .= '<table cellspacing="0" cellpadding="2" width="530" >
            <tr style="font-size: 10px;" >
                <th width="5%" align="center" style=" border: 1px solid #000000; font-weight: bold; font-size: 11px; background-color:#D1D1D1;">No</th>
                <th width="55%" align="center" style=" border: 1px solid #000000; font-weight: bold; font-size: 11px; background-color:#D1D1D1;">Deskripsi</th>
                <th width="10%" align="center" style=" border: 1px solid #000000; font-weight: bold; font-size: 11px; background-color:#D1D1D1;">Qty</th>
                <th width="15%" align="center" style=" border: 1px solid #000000; font-weight: bold; font-size: 11px; background-color:#D1D1D1;">Unit Price</th>
                <th width="15%" align="center" style=" border: 1px solid #000000; font-weight: bold; font-size: 11px; background-color:#D1D1D1;">Sub Total</th>
            </tr>';

$datgroup = $g;
$c  = count($datgroup);

for ($x = 0; $x <= $c - 1; $x++) {
    $parentname = strtoupper($datgroup[$x]['parentname']);

    $html .= '<tr>
                <td align="left" colspan="5" style=" border: 1px solid #000000; font-weight: bold; background-color:#DDEBF7;">' . $datgroup[$x]['id_itemg'] . '. ' .  $parentname . '</td>

            </tr>';

    $qrym1 = "SELECT *
                            FROM sales.quotation_detail 
                            WHERE id_qt=".$m[0]['id_qt']." AND id_parent= '" . $datgroup[$x]['id_parent'] . "'
                            ORDER BY id_qt_detail ASC";
    $item1 = $this->db->query($qrym1)->result_array();
    $n = 0;
    $sum_group = 0;
    foreach ($item1 as $datdetail) {
        $n = $n + 1;
        $sum_group = $sum_group + $datdetail['quot_extended'];
        $html .= '  <tr>
                    <td align="center" style=" border: 1px solid #000000; ">' . $n . '</td>
                    <td style=" border: 1px solid #000000;">' . $datdetail['descriptions'] . '</td>
                    <td align="center" style=" border: 1px solid #000000;">' . tegar_num($datdetail['qty']) . ' ' . $datdetail['kd_satuan'] . '</td>
                    <td align="right" style=" border: 1px solid #000000;">' . tegar_num($datdetail['quot_price']) . '</td>
                    <td align="right" style=" border: 1px solid #000000;">' . tegar_num($datdetail['quot_extended']) . '</td>
                    </tr>';
    }
    $html .= '<tr>
                <td align="centre" colspan="4" style=" border: 1px solid #000000; font-weight: bold; background-color:#DDEBF7;"> Sub Total ' . $parentname . '</td>
                <td align="right"  style=" border: 1px solid #000000; font-weight: bold; background-color:#DDEBF7;"> ' . tegar_num($sum_group) . ' </td>

            </tr>';
};


$c = 0;
if ($c > 0) {
    for ($x = 0; $x <= $c - 1; $x++) {
        $n = $n + 1;


        $html .= '<tr>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000; "></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000; "></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000; "></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000; "></td>
                <td style=" border-left: 1px solid #000000; border-right: 1px solid #000000; "></td>
            </tr>';
    };
};



$html .= '<tr >
            <td colspan="4" height="15" align="left" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;" >Jumlah Harga Jual</td>
            <td align="right" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;">' . $m[0]['sub_total_quot'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;">Pajak Pertambahan Nilai</td>
            <td align="right" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;">' . $m[0]['vat_num_quot'] . ' </td>
        </tr>
        <tr >
            <td colspan="4" height="15" align="left" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;">TOTAL PENAWARAN</td>
            <td align="right" style="border: 1px solid #000000; font-weight: bold; font-size: 10px; background-color:#D1D1D1;">' . $m[0]['total_quot'] .  ' </td>
        </tr>
        </table>

        <table cellspacing="0" cellpadding="2" width="535" border="0">
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
        
        <table cellspacing="1" cellpadding="0" width="535" border="0">
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
    <td width="520px" height="10px" align="left" style="font-size: 10px;">' .  trim($datpay[$x]) . '</td>
    </tr>';
};
$html .=   '</table>
            <table  cellspacing="0" cellpadding="0" width="530" border="0" style="font-size: 10px;">
            <tr>
                <td height="209"></td>
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
$pdf->Output("Quotation.pdf", "I");

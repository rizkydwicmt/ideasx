<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
$pdf = new pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Purchase Order');
$pdf->SetFont("helvetica", "", 10);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Saridin_muhammadinov');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(10);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//var_dump($dpo['rows']);
// var_dump($dpo['rows'][0]['kd_item']);
// die;

$mpo = $mpo['rows'];

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
$pdf->SetFont("helvetica", "", 8);
$i = 0;
$subtable = '<table width="194" border="0" cellspacing="0" cellpadding="1">
		<tr>
        <td><span style="text-decoration: underline; color: rgb(237, 125, 49); font-weight: bold; font-size: 14px;">PT INTI DAYA ENERGITAMA</span>
        </td>
		</tr>
		<tr>
		<td><span style="font-size: large;">Perum. Juanda Regency Blok H-17</span></td>
		</tr>
		<tr>
		<td><span style="font-size: large;">Pabean - Sedati, Sidoarjo 61253</span></td>
		</tr>

		<tr>
		<td><span style="font-size: large;">Phone.+63-31-99681838</span></td>
		</tr>
		<tr>
		<td><span style="font-size: large;">email: ide@idetama.id</span></td>
        </tr>
		<tr>
		<td><span style="font-size: large;">www.idetama.id</span></td>
        </tr>
        
        </table>';


$subtable2 = '<table width="198" border="1" cellspacing="0" cellpadding="1">
		<tr>
            <td><span style="font-size: large;">Date</span></td>
            <td align="right"><span style="font-size: large;">' . $mpo[0]['po_date'] . '</span></td>
		</tr>
		<tr>
		<td><span style="font-size: large;">Currency</span></td>
		<td align="right"><span style="font-size: large;">' . $mpo[0]['id_curr'] . '</span></td>
		</tr>
		<tr>
		<td><span style="font-size: large;">Delivery Time</span></td>
		<td align="right"><span style="font-size: large;">' . $mpo[0]['delivery_terms'] . '</span></td>
		</tr>

		<tr>
		<td><span style="font-size: large;">Ref. Quotation</span></td>
		<td align="right"><span style="font-size: large;">' . $mpo[0]['quotation_reff'] . '</span></td>
		</tr>
		<tr>
		<td><span style="font-size: large;">CC/Project #</span></td>
		<td align="right"><span style="font-size: large;">' . $mpo[0]['id_cc_project'] . '</span></td>
        </tr>


        </table>';

$html = '<table  cellspacing="0" cellpadding="2" width="550" height="209" border="0">
            <tr height="100">
                <td width="200" height="100">' . $subtable . '  </td>
                <td width="140" height="100"> </td>
                <td align="center" width="200" height="100"><img src="assets/img/logo.jpg" width="200" height="56" alt=""/>
                    <br>
                    <span style="text-decoration: underline; font-weight: bold; font-size: 14px;">PURCHASE ORDER</span>
                    <br>
                    <span style="font-weight: bold; font-size: 12px;">' . $mpo[0]['po_number'] . '</span>

                </td>
            </tr>
            <tr>
                <td colspan="3" height="10"> </td>
            </tr>
            <tr>
                <td width="200" height="15" style="font-style: italic; font-weight: bold; font-size: 10px;">Vendor : </td>
                <td width="140" height="15" style="font-style: italic; font-weight: bold; font-size: 10px;">Delivery Place :</td>
                <td rowspan="3" width="200" height="20">' . $subtable2 . '  </td>
            </tr>
            <tr height="500">
                <td width="200" height="50" align="left" style="font-size: 10px;"><span style="font-weight: bold;">' . $mpo[0]['nama_rekanan'] . '</span>
                <br>' . $mpo[0]['alamat_rekanan'] . '
                <br>' . $mpo[0]['negara_rekanan'] . '
                <br>' . $mpo[0]['telp_rekanan'] . '
                <br>Ctc :' . $mpo[0]['kontak_rekanan'] . '
                </td>
                <td width="140" height="50"style="font-size: 9px;">' . $mpo[0]['ship_to'] . '
                <br>Attn :' . $mpo[0]['buyer'] . '
                </td>    
            </tr>
            <tr>
            <td colspan="3" height="30"> </td>
            </tr>
        </table>
        ';

$pdf->SetFont("helvetica", "", 9);


$html .= '<table border="1" cellspacing="0" cellpadding="2">
            <tr bgcolor="#EF8B47" style="font-style: italic; font-weight: bold; font-size: 11px;">
                <th width="5%" align="center" >Line #</th>
                <th width="55%" align="center">Item</th>
                <th width="10%" align="center">Qty</th>
                <th width="15%" align="center">Unit Price</th>
                <th width="15%" align="center">Ammount</th>
            </tr>';
foreach ($dpo['rows'] as $row) {
    $i++;
    $html .= '<tr >
                            <td align="center">' . $i . '</td>
                            <td>' . $row['descriptions'] . '</td>
                            <td align="center">' . $row['qty'] . ' ' . $row['kd_satuan'] . '</td>
                            <td align="right">' . $row['unit_price'] . '</td>
                            <td align="right">' . $row['sub_total'] . '</td>
                        </tr>';
}


$html .= '<tr >
            <td colspan="3" rowspan="3"><span style="font-weight: bold;">Note :</span>
            <br>' . $mpo[0]['remarks'] . '
            </td>
            <td height="20" align="right" style="font-style: italic; font-weight: bold; font-size: 9px;">SUBTOTAL</td>
            <td align="right">' . $mpo[0]['sub_total'] . ' </td>
        </tr>
        <tr >
            <td height="20" align="right" style="font-style: italic; font-weight: bold; font-size: 9px;">VAT</td>
            <td align="right">' . $mpo[0]['vat_num'] . ' </td>
        </tr>
        <tr >
            <td height="20" align="right" style="font-style: italic; font-weight: bold; font-size: 9px;">TOTAL</td>
            <td align="right">' . $mpo[0]['total'] . ' </td>
        </tr>
        </table>
        ';

$html .= '<table border="0" cellspacing="0" cellpadding="2">
            <tr height="50">
                <td width="100%" height="50"></td>
            </tr>
            </table>';

$html .= '<table border="1" cellspacing="0" cellpadding="2">
            <tr>
                <th width="19%">Preparer</th>
                <th width="19%">Technical Reviewer</th>
                <th width="19%">CC/Project Mgmt.</th>
                <th width="19%">Financial Reviewer</th>
                <th width="24%">Approved By</th>
            </tr>
            <tr height="80">
                <td height="80"></td>
                <td height="80"></td>
                <td height="80"></td>
                <td height="80"></td>
                <td height="80"></td>
            </tr>
            <tr>
                <td>' . $mpo[0]['prepared_by'] . '</td>
                <td>' . $mpo[0]['reviewed_by'] . '</td>
                <td>' . $mpo[0]['reviewed_by_2'] . '</td>
                <td>' . $mpo[0]['reviewed_by_3'] . '</td>
                <td>' . $mpo[0]['approved_by'] . '</td>
            </tr>
            <tr>
            <td>Date:</td>
            <td>Date:</td>
            <td>Date:</td>
            <td>Date:</td>
            <td>Date:</td>
        </tr>
            
        </table>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("PO.pdf", "I");

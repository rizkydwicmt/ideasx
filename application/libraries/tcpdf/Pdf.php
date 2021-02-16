<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once dirname(__FILE__) . '/tcpdf/config/lang/eng.php';
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{

	public function Header() {
		// Logo
		$this->Image('assets/img/logo.jpg', '', 5, '', '', '', '', 'C', true, 300, '', false, false, 0, true, false, true, false);
	}

	//Page footer
	function Footer(){
		//Position at 25 mm from bottom
		$this->SetY(-25);
		$this->SetY(-15);
		$this->SetX(0);

        // Set font
        $this->SetFont('helvetica', '', 5);
        // Page number
        $this->Cell(0, 0, 'Waktu Cetak : '.date("d/m/Y").' '.date("H:i:s").' oleh Dedy Prasetyo'.
        	'Halaman '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages().' halaman', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}

}

function tcpdf(){
	return new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
}

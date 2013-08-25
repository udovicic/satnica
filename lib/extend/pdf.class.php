<?php
/** PDF output enabler
 *
 * Manage pdf output
 */

namespace Extend;

class PDF extends tFPDF
{
	// Title used in header
	public $title;

/**
 * Header function override
 *
 * Set default page header
 */
	function Header()
	{
		$this->SetFont('DejaVu','B',20);
		$this->Cell(0, 10, $this->title, 'B', 1, 'C');
		$this->Ln(10);
	}

/**
 * Footer function override
 *
 * Set default page footer
 */
	function Footer()
	{
		$this->SetY(-15);
		$this->Ln(2);
		$this->SetFont('DejaVu', 'I', 8);
		$this->Cell(0, 10, 'Generated by http://satnica.udovicic.org', 'T', 0, 'L');
	}

/**
 * Report generator
 *
 * Generates PDF report
 *
 * @param array $data list of shift with details generated by Shift->report
 * @param array $footer Totals genereated by Shift->reportSum
 */
	function report($data, $footer)
	{
		// new page
		$this->AddPage();
		$this->Ln(20);

		// header color and font setup
		$this->SetFillColor(200, 200, 255);
		$this->SetDrawColor(150, 150, 255);
		$this->SetLineWidth(.3);
		$this->SetFont('DejaVu', 'B', 12);

		// Header info
		$w = array(35, 35, 19, 19, 19, 19, 19, 19, 19, 19);
		$head = array('Datum', 'Vrijeme', 'D.', 'N.', 'Ned.', 'Ned.N.', 'Bl.', 'Bl.N.');
		for ($i=0; $i<count($head); $i++) {
			$this->Cell($w[$i], 7, $head[$i], 1, 0, 'C', true);
		}
		$this->Ln();

		// data color and font setup
		$this->SetFillColor(224, 235, 255);
		$this->SetFont('DejaVu', '', 12);

		// Data
		$fill = false;
		foreach ($data as $shift) {
			$this->Cell($w[0], 6, $shift['date'], 'LR', 0, 'C', $fill);
			$time = $shift['start'] . ' - ' . $shift['end'];
			$this->Cell($w[1], 6, $time, 'LR', 0, 'C', $fill);
			$details = array_keys($shift['details']);
			$i=2;
			foreach ($details as $detail) {
				$this->Cell($w[$i], 6, $shift['details'][$detail], 'LR', 0, 'C', $fill);
				$i++;
			}

			//new line
			$this->ln();

			// toggle fill
			$fill = !$fill;
		}

		// Footer
		$this->SetFillColor(200, 200, 255);
		$this->SetFont('DejaVu', 'B', 12);
		$this->Cell($w[0]+$w[1], 7, $footer['total'] . ' Kn', 1, 0, 'C', 1);
		$details = array_keys($footer['details']);
		$i=2;
		foreach ($details as $detail) {
			$this->Cell($w[$i], 7, $footer['details'][$detail], 1, 0, 'C', 1);
			$i++;
		}

		// revert color setting
		$this->SetDrawColor(0, 0, 0);
	}

/**
 * Class constructor
 */
	function __construct()
	{
		$this->title = ''; // Empty title
		$this->tFPDF(); // Call default constructor
		$this->AliasNbPages();

		// Add a Unicode font
		$this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$this->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
		$this->AddFont('DejaVu','I','DejaVuSansCondensed-Oblique.ttf',true);
		$this->AddFont('DejaVu','BI','DejaVuSansCondensed-BoldOblique.ttf',true);

		// Set default font
		$this->SetFont('DejaVu','',14);

		// Autobrake page
		$this->SetAutoPageBreak(true);
	}

/**
 * Class destructor
 */
	function __destruct()
	{
		// output pdf
		$this->Output();
	}
}
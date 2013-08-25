<?php
/** Managing Shift
 *
 * Handles input and processing
 */
class ShiftsController extends Core\Controller
{
	private $user;

/**
 * Constructor function
 *
 * Extends default constructor
 *
 * @param string $controller Name of controller class to be used
 * @param string $action Name of function to be executed
 */
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
		$this->requireUser = true;
		$this->user = new Core\User;
	}

/**
 * Add new shift_details
 */
	function add()
	{
		$this->set('title', 'Dodavanje smjena');
	}

/**
 * Lists all shifts
 *
 * Generates lists of shift within request period of time
 *
 * @param string $start Begining of period, month or empty
 * @param string $end End of period or empty
 */
	function report($start = '', $end = '')
	{
		// parse input
		$period = $this->Shift->parsePeriodDate($start, $end);

		// retrieve data from database
		$data = $this->Shift->report($period['start']->format('Y-m-d'), $period['end']->format('Y-m-d'));
		$sum = $this->Shift->reportSum($period['start']->format('Y-m-d'), $period['end']->format('Y-m-d'));

		// prepare output
		$this->set('title', 'Sažetak smjena');
		$this->set('data', $data);
		$this->set('sum', $sum);
	}

/**
 * Generate printable version of report
 *
 * Like report, but generates PDF
 *
 * @param string $start Begining of period, month or empty
 * @param string $end End of period or empty
 */
	function printable($start = '', $end = '')
	{
		// parse input
		$period = $this->Shift->parsePeriodDate($start, $end);

		// retrieve data from database
		$data = $this->Shift->report($period['start']->format('Y-m-d'), $period['end']->format('Y-m-d'));
		$sum = $this->Shift->reportSum($period['start']->format('Y-m-d'), $period['end']->format('Y-m-d'));

		// don't output HTML, PDF will be used
		$this->renderPage = false;

		// create PDF object
		$pdf = new Extend\PDF();
		$pdf->title = "Sažetak smjena";

		// generate table
		$pdf->report($data, $sum);
	}	

/**
 * Handles saving new shift
 */
	function save()
	{
		$this->set('title', 'Detalji smjene');

		if ( isset($_POST['submit']) == true) {
			if (isset($_POST['js']) == true) {
				// ajax request
				$this->renderHeader = false;
			}

			// grab form data
			$date = new DateTime($_POST['date']);
			$shift_details['date'] = $date->format('Y-m-d');
			$shift_details['start'] = $_POST['start'];
			$shift_details['end'] = $_POST['end'];
			$shift_details['note'] = $_POST['note'];

			//validate input
			if ($shift_details['date'] == '' || $shift_details['start'] == '' || $shift_details['end'] == '') {
				echo '<p>Niste unjeli sve podatke</p>';
				$this->renderPage = false; // FIXME: page should render, but skip rest of the body
				return;
			}

			$shift_data = $this->Shift->split($shift_details);
			$shift_details['total'] = $this->Shift->calculate($shift_data);

			$this->Shift->save($shift_details, $shift_data);

			//translate data for ui
			$translate = array(
				'day' => 'dnevni',
				'night' => 'noćni',
				'sunday' => 'nedjeljni',
				'sunday_night' => 'nedjeljni noćni',
				'holiday' => 'praznik',
				'holiday_night' => 'praznik noćni'
			);

			// set up variables
			$this->set('translate', $translate);
			$this->set('komentar', $shift_details['note']);
			$this->set('ukupno', $shift_details['total']);
			$this->set('sati', $shift_data);
		} else {
			// form wasn't submited, fallback to shift_details input
			header('location: ' . SITE_URL . '/shifts/add');
		}
	}

/**
 * Handles deleting shift
 */
	function delete() 
	{
		$this->renderPage = false;

		if (isset($_POST['id']) == true) {
			$id = $_POST['id'];

			// execute query
			$result = $this->Shift->delete($id);

			if ($result == true) {
				echo '<p>Smjena je uspješno obrisana.</p>';
			} else {
				echo '<p>Greška prilikom brisanja smjene.</p>';
			}
		} else {
			// form wasn't submited, fallback to report
			header('location: ' . SITE_URL . '/shifts/report');
		}
	}

/**
 * Handles shift update
 */
	function update()
	{
		$this->renderPage = false;

		if ( isset($_POST['shift_id']) == true) {
			// grab form data
			$date = new DateTime($_POST['date']);
			$shift_details['date'] = $date->format('Y-m-d');
			$shift_details['shift_id'] = $_POST['shift_id'];
			$shift_details['start'] = $_POST['start'];
			$shift_details['end'] = $_POST['end'];
			$shift_details['note'] = $_POST['note'];

			//validate input
			if ($shift_details['date'] == '' || $shift_details['start'] == '' || $shift_details['end'] == '') {
				echo '<p>Niste unjeli sve podatk.e</p>';
				return;
			}

			$shift_data = $this->Shift->split($shift_details);
			$shift_details['total'] = $this->Shift->calculate($shift_data);

			$result = $this->Shift->save($shift_details, $shift_data);
			if ($result == true) {
				echo '<p>Izmjene spremljene.</p>';
			} else {
				echo '<p>Greška prilikom spremanja izmjena.</p>';
			}
		} else {
			// form wasn't submited
			echo '<p>Podaci nisu poslani.</p>';
		}
	}
}

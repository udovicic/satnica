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
 * @param array $period Period for listing. If not provided, current month is used
 */
	function report($start = '', $end = '')
	{
		// parse input
		if ($start == '' || $end == '') {
			$start = new DateTime('first day of this month');
			$end = new DateTime('first day of next month');
		} else {
			$start = new DateTime($start);
			$end = new DateTime($end);
		}

		// retrieve data from database
		$data = $this->Shift->report($start->format('Y-m-d'), $end->format('Y-m-d'));
		$sum = $this->Shift->reportSum($start->format('Y-m-d'), $end->format('Y-m-d'));

		// prepare output
		$this->set('title', 'Sažetak smijena za tekući mjesec');
		$this->set('data', $data);
		$this->set('sum', $sum);
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

			$this->set('komentar', $shift_details['note']);
			$this->set('ukupno', $shift_details['total']);
			$this->set('sati', $shift_data);
		} else {
			// form wasn't submited, fallback to shift_details input
			header('location: ' . SITE_URL . '/shift_detailss/add');
		}
	}
}
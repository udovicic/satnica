<?php
/** Managing shifts
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
		$this->requireUser = false;
		$this->user = new Core\User;
	}

/**
 * Add new shift
 */
	function add()
	{

	}

/**
 * Handles saving new shift
 */
	function save()
	{
		if ( isset($_POST['submit']) == true) {
			if (isset($_POST['js']) == true) {
				// ajax request
				$this->renderHeader = false;
			}

			// grab form data
			$date = $_POST['date'];
			$start = $_POST['start'];
			$end = $_POST['end'];
			$comment = $_POST['comment'];

			//validate input
			if ($date == '' || $start == '' || $end == '') {
				echo '<p>Niste unjeli sve podatke</p>';
				$this->renderPage = false;
				return;
			}

			$sati = $this->Shift->split($date, $start, $end);
			$ukupno = $this->Shift->calculate($sati);

			$this->set('komentar', $comment);
			$this->set('ukupno', $ukupno);
			$this->set('sati', $sati);
		} else {
			// form wasn't submited, fallback to shift input
			$this->renderPage = false;
			global $url;
			$url = 'shifts/add';
			callHook();
		}
	}
}
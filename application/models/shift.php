<?php

class Shift extends Core\Model
{

	private $user;

	function __construct()
	{
		parent::__construct();
		$this->user = new Core\User;
	}
/**
 * Creates detailed listing of working hours
 *
 * @param array $shift_details Array containing date, start and end keys
 * @return array Detailed hour listing
 */
	function split($shift_details)
	{
		$holidays = array(
			"01.01." => "Nova Godina",
			"06.01." => "Bogojavljanje ili Sveta tri kralja",
			"01.05." => "Praznik rada",
			"22.06." => "Dan antifašističke borbe",
			"25.06." => "Dan državnosti",
			"05.08." => "Dan domovinske zahvalnosti",
			"15.08." => "Velika Gospa",
			"08.10." => "Dan neovisnosti",
			"01.11." => "Dan svih svetih",
			"25.12." => "Božić",
			"26.12." => "Sveti Stjepan",
			date("d.m.", easter_date()) => "Uskrs",
			date("d.m.", strtotime('+1 day', easter_date())) => "Uskršnji ponedjeljak",
			date("d.m.", strtotime('+60 days', easter_date())) => "Tijelovo"
		);

		$shift = new DateTime($shift_details['date'] . ' ' . $shift_details['start'] . ':00');
		$shift_end = new DateTime($shift_details['date'] . ' ' . $shift_details['end'] . ':00');
		if ($shift >= $shift_end) { // ended on next day
			$shift_end->modify('+1 day');
		}

		$shift_data = array(
			"day" => 0,
			"night" => 0,
			"sunday" => 0,
			"sunday_night" => 0,
			"holiday" => 0,
			"holiday_night" => 0
		);

		while ($shift < $shift_end) { // iterrate through shift
			$hour = intval($shift->format('H')); // grab current hour

			if ($hour < 6 || $hour >= 22) {
				// night hour
				if (array_key_exists($shift->format('d.m.'), $holidays)) {
					$shift_data['holiday_night']++;
				} else if ($shift->format('N') == '7') {
					$shift_data['sunday_night']++;
				} else {
					$shift_data['night']++;
				}
			} else {
				// day hour
				if (array_key_exists($shift->format('d.m.'), $holidays)) {
					$shift_data['holiday']++;
				} else if ($shift->format('N') == '7') {
					$shift_data['sunday']++;
				} else {
					$shift_data['day']++;
				}
			}

			$shift->modify('+1 hour'); // move to next hour
		}

		return $shift_data;
	}

/**
 * Retrieve rates from database
 *
 * @param int $rate_id ID of rate in database
 * @return array shift_dataing rows from database
 */
	function getRates($rate_id)
	{
		$arg = array(
			'id' =>$rate_id
		);

		$rates = $this->query('SELECT * FROM rate where rate_id=:id', $arg);
		return $rates[0];
	}

/**
 * Calculates total income
 *
 * @param array Array returned by split()
 * @return string Number formated to 2 decimal places
 */
	function calculate($shift_data)
	{
		$rates = $this->getRates($this->user->get('rate_id'));

		$total = 0;
		foreach ($shift_data as $key => $value) {
			$total += $rates[$key] * $value;
		}

		return number_format($total, 2);
	}

/**
 * Stores shift details into database
 *
 * @param array $shift_details Array containg shift details (start, end, date, total, note)
 * @param array $shift_data Array returned by split()
 */
	function save($shift_details, $shift_data)
	{
		$arg = array_merge($shift_details, $shift_data);
		$arg['user_id'] = $this->user->get('user_id');
		

		$this->query('INSERT INTO shift (user_id, date, start, end, note, total, day, night, sunday, sunday_night, holiday, holiday_night) ' .
			'VALUES (:user_id, :date, :start, :end, :note, :total, :day, :night, :sunday, :sunday_night, :holiday, :holiday_night)', $arg);
	}

/**
 * Retrieve shift list from database
 *
 * Dates must be in format Y-m-d as required by MySQL
 *
 * @param string $start Start of period
 * @param string $end End of period
 * @return array $report Generated report from database
 */
	function report($start, $end)
	{
		$arg = array(
			'start' => $start,
			'end' => $end,
			'user_id' => $this->user->get('user_id')
		);

		$shifts = $this->query(
			'SELECT * FROM shift ' .
			'WHERE user_id=:user_id ' .
			'AND date BETWEEN :start AND :end ' .
			'ORDER BY date',
			$arg);

		$data = array();
		foreach ($shifts as $shift) {
			$date = new DateTime($shift['date']);

			$data[] = array(
				'date' => $date->format('d.m.Y'),
				'start' => $shift['start'],
				'end' => $shift['end'],
				'total' => $shift['total'],
				'note' => $shift['note'],
				'details' => array(
					'dnevni' => $shift['day'],
					'noćni' => $shift['night'],
					'nedjeljni' => $shift['sunday'],
					'nedjeljni noćni' => $shift['sunday_night'],
					'praznik' => $shift['holiday'],
					'praznik noćni' => $shift['holiday_night'])
			);
		}

		return $data;
	}

/**
 * Retrieve shifts sums
 *
 * Dates must be in format Y-m-d as required by MySQL
 *
 * @param string $start Start of period
 * @param string $end End of period
 * @return array $report Generated report from database
 */
	function reportSum($start, $end)
	{
		$arg = array(
			'start' => $start,
			'end' => $end,
			'user_id' => $this->user->get('user_id')
		);

		$shifts = $this->query(
			'SELECT sum(day) AS day, sum(night) as night, ' .
			'sum(sunday) as sunday, sum(sunday_night) as sunday_night, ' .
			'sum(holiday) as holiday, sum(holiday_night) as holiday_night, ' .
			'sum(total) as total FROM shift ' .
			'WHERE user_id=:user_id ' .
			'AND date BETWEEN :start AND :end ' .
			'ORDER BY date',
			$arg);

		$sum = array();
		foreach ($shifts as $shift) {			
			$sum[] = array(
				'total' => $shift['total'],
				'details' => array(
					'dnevni' => $shift['day'],
					'noćni' => $shift['night'],
					'nedjeljni' => $shift['sunday'],
					'nedjeljni noćni' => $shift['sunday_night'],
					'praznik' => $shift['holiday'],
					'praznik noćni' => $shift['holiday_night'])
			);
		}

		return $sum[0];
	}
}
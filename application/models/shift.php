<?php

class Shift extends Core\Model
{

/**
 * Creates detailed listing of working hours
 *
 * @param string $date Date when shift started
 * @param string $start Hour when shift started
 * @param string $end Hour when shift ended
 * @return array Detailed hour listing
 */
	function split($date, $start, $end)
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

		$shift = new DateTime($date . ' ' . $start . ':00');
		$shift_end = new DateTime($date . ' ' . $end . ':00');
		if ($shift >= $shift_end) { // ended on next day
			$shift_end->modify('+1 day');
		}

		$result = array(
			"day" => 0,
			"night" => 0,
			"sunday" => 0,
			"sunday_night" => 0,
			"holiday" => 0,
			"holiday_night" => 0
		);

		while ($shift < $shift_end) {
			$hour = intval($shift->format('H'));

			if ($hour < 6 || $hour >= 22) {
				// night hour
				if (array_key_exists($shift->format('d.m.'), $holidays)) {
					$result['holiday_night']++;
				} else if ($shift->format('N') == '7') {
					$result['sunday_night']++;
				} else {
					$result['night']++;
				}
			} else {
				// day hour
				if (array_key_exists($shift->format('d.m.'), $holidays)) {
					$result['holiday']++;
				} else if ($shift->format('N') == '7') {
					$result['sunday']++;
				} else {
					$result['day']++;
				}
			}

			$shift->modify('+1 hour');
		}

		return $result;
	}

/**
 * Retrieve rates from database
 *
 * @param int $rate_id ID of rate in database
 * @return array Resulting rows from database
 */
	function getRates($rate_id)
	{
		$arg = array(
			'id' =>$rate_id
		);

		return $this->query('SELECT * FROM rate where rate_id=:id', $arg);
	}

/**
 * Calculates total income
 *
 * @param array Array returned by split()
 * @return string Number formated to 2 decimal places
 */
	function calculate($shift)
	{
		$rates = $this->getRates(1);
		
		$total = 0;
		foreach ($shift as $key => $value) {
			$total += $rates[0][$key] * $value;
		}

		return number_format($total, 2);
	}
}
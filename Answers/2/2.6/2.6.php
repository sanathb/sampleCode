<?php
/*Question #2.6
An online shop can accept orders 24hrs a day, 365 days a year.
However, the shop needs to post the orders to customers and can only do so on business days before 4pm.
Any orders received after 4pm need to be dispatched the next business day.
The deliveries then take 3 business days (including the dispatch date) to be delivered to the customer.

Dispatch Date Example
• #1: Ordered BEFORE 4pm on Monday 2000-01-03 (15:59:59) | Delivery: Wednesday 2000-01-05
• #2: Ordered AFTER 4pm Monday 2000-01-03 (16:00:00) | Delivery: Thursday 2000-01-06

A business day is considered Monday to Friday and does not include the following dates:
• New Year's Day : 1st January
• Australia Day : 26th January
• Good Friday (Easter) : Variable date
• Easter Monday : Variable date
• Anzac Day : 25th April
• Queen's Birthday : Second Monday in June
• Labour Day : First Monday in October
• Christmas Day : 25th December
• Boxing Day : 26th December

Important notes:
• All dates are for NSW public holidays.
• All times are for Sydney Australia.
• The solution must work for all years since the year 2000 onwards (not just this year).
• Orders will not be dispatched on non-business days.
• Dispatched orders will be delayed during transit over non-business days - e.g. an order dispatched on Friday will not arrive until Tuesday (3 day transit).
• If one of the listed holidays falls on a Saturday or Sunday, it must be rolled over to the next Monday - with the exception of Anzac Day (which doesn't).

Create a class that when given a specific date and time formatted YEAR-MONTH-DAY HOUR:MINUTE:SECOND (Y-m-d H:i:s), will return via two separate methods the dispatch date and the delivery date of the order formatted as YEAR-MONTH-DAY. Include unit tests for each date.*/

Class Logistics {

	/**
	 * Get diapatch date in YEAR-MONTH-DAY format
	 *
	 * @param string $orderDate
	 * @param bool $formatted
	 *
	 * @return string|integer
	 */
	public function getDispatchDate($orderDate, $formatted = true) {
		$orderDate = strtotime($orderDate);

		if ($this->isBusinessDay($orderDate) && $this->isBusinessHour($orderDate)) {
			$dispatchDate = $orderDate;
		} else {
			$dispatchDate = $this->getNextBusinessDay($orderDate);
		}

		return $formatted ? $this->getFormatedDate($dispatchDate) : $dispatchDate;
	}

	/**
	 * Get delivery date in YEAR-MONTH-DAY format
	 *
	 * @param string $orderDate
	 *
	 * @return string
	 */
	public function getDeliveryDate($orderDate) {
		$date = $this->getDispatchDate($orderDate, false);
		$transportDays = 2; //3 days including dispatch date

		for ($i=0; $i < $transportDays; $i++) { 
			$date = $this->getNextBusinessDay($date);
		}

		return $this->getFormatedDate($date);
	}

	/**
	 * Chek if it is a working day
	 *
	 * @param integer $date
	 *
	 * @return bool
	 */
	protected function isBusinessDay($date) {
		if (!$this->isPublicHoliday($date) && !$this->isWeekend($date)) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the time is before 4PM
	 *
	 * @param integer $date
	 *
	 * @return bool
	 */
	protected function isBusinessHour($date) {
		$hour = date('G', $date);
		return $hour < 16 ? true : false;
	}

	/**
	 * Get next working day
	 *
	 * @param integer $date
	 *
	 * @return integer
	 */
	protected function getNextBusinessDay($date) {
		$date = $this->getNextDay($date);

		while ($this->isPublicHoliday($date) || $this->isWeekend($date)) {
			$date = $this->getNextDay($date);
		}

		return $date;
	}

	/**
	 * get next day
	 *
	 * @param integer $date
	 *
	 * @return integer
	 */
	protected function getNextDay($date) {
		return strtotime('+1 day', $date);
	}

	/**
	 * Check if it is a public holiday
	 *
	 * @param integer $date
	 *
	 * @return bool
	 */
	protected function isPublicHoliday($date) {
		$queenBirthday = $this->getQueenBirthDay($date);
		$labourDay = $this->getLabourDay($date);
		list($goodFriday, $easterMonday) = $this->getEaster($date);

		$pubilcHolidays = [
			'01 January',
			'26 January',
			$goodFriday,
			$easterMonday,
			'25 April',
			$queenBirthday,
			$labourDay,
			'25 December',
			'26 December',
		];

		$date = date('j F', $date);

		return in_array($date, $pubilcHolidays);
	}

	/**
	 * Get Queen birthday
	 *
	 * @param integer $date
	 *
	 * @return string DD MMMM
	 */
	protected function getQueenBirthDay($date) {
		// Queen's Birthday : Second Monday in June
		$year = date('Y', $date);
		return date('j F', strtotime('Second Monday June ' . $year));

	}

	/**
	 * Get Labour day
	 *
	 * @param integer $date
	 *
	 * @return string DD MMMM
	 */
	protected function getLabourDay($date) {
		// First Monday in October
		$year = date('Y', $date);
		return date('j F', strtotime('First Monday October ' . $year));
	}

	/**
	 * Get easter date
	 *
	 * @param integer $date
	 *
	 * @return array Array of good friday date and easter Monday in DD MMMM
	 */
	protected function getEaster($date) {
		$year = date('Y', $date);
		$date = easter_date($year);
		$goodFriday = date('j F', $date);

		$easterdate = $this->getNextDay($date);
		$easterMonday = date('j F', $easterdate);

		return [$goodFriday, $easterMonday];

	}

	/**
	 * Check if date is a weekend
	 *
	 * @param integer $date
	 *
	 * @return bool
	 */
	protected function isWeekend($date) {
		$day = date('l', $date);

		return in_array($day, ['Saturday', 'Sunday']);
	}

	/**
	 * Decorator for date
	 *
	 * @param integer $date
	 *
	 * @return string
	 */
	protected function getFormatedDate($date) {
		return date('Y-m-d', $date);
	}
}

// Ex:

$logistics = new Logistics();

// $date = '2019-01-26 12:45:41';
$date = '2019-01-18 17:45:41';

echo "\nOrder date: $date";
echo "\nDispatch date is: " . $logistics->getDispatchDate($date);
echo "\nDelivery date is: " . $logistics->getDeliveryDate($date) . "\n\n";
<?php
/*
Question #2.3
Task A
Create a function that will generate a random hand of 5 standard playing cards from a single deck of cards.
The hand of cards must be returned in the format: array('2c', '6d', 'as', 'jh', '10c');
For this test, we are looking for elegant readable code.

Task B
Create a function that will return a boolean result as to whether the hand of cards returned by the above function contains a 'straight' or 'straight flush'.
For this test we are looking for as few code characters as possible (Code elegance is not required). 
Note: This is testing your creativity for coming up with a solution - it is not expected to be easily readable or best-practice.
It has been done with as few as 61 characters, but more commonly between 100-225 chars - the lower the better.

Notes
Aces are high AND low.
The #10 cards are 3 characters (10h, 10c, 10s, 10d)
Reference
Straight : http://en.wikipedia.org/wiki/List_of_poker_hands#Straight
Straight Flush : http://en.wikipedia.org/wiki/List_of_poker_hands#Straight_flush
*/

// Task A

/**
 * Class for cards
 */
class Cards
{
	protected $type = ['s', 'h', 'd', 'c'];
	protected $values = ['2','3','4','5','6','7','8','9','10','j','q','k','a'];
	protected $handOfCards = [];

	/**
	 * Draw a set of 5 cards from the deck.
	 *
	 * @return array
	 */
	public function draw() {
		for ($i=0; $i < 5; $i++) {
			$this->handOfCards[] = $this->getNewCard();
		}

		return $this->handOfCards;
	}

	/**
	 * Get a new card. If the card exists in the hand, get another one.
	 *
	 * @return string
	 */
	protected function getNewCard() {
		$val = $this->getCardVal() . $this->getCardType();
		if (in_array($val, $this->handOfCards)) {
			$val = $this->getNewCard();
		}

		return $val;
	}

	/**
	 * Get a random card type
	 *
	 * @return string
	 */
	protected function getCardType() {
		shuffle($this->type);
		return $this->type[0];
	}

	/**
	 * Get a random card value
	 *
	 * @return string
	 */
	protected function getCardVal() {
		shuffle($this->values);
		return $this->values[0];
	}
}

$cards = new Cards();
$res = $cards->draw();
echo "\nHand of cards\n";
print_r($res);




// Task B

//Check straight
$test = ['10a', 'qh', 'jd', '9s'];
if (checkStraight($test)) {
	echo "\n\n\nTest data is straight\n";
	print_r($test);
};

//Check straight flush
$test = ['10h', 'qh', 'jh', '9h'];
if (checkStraight($test, true)) {
	echo "\n\nTest data is straight flush\n";
	print_r($test);
};

function checkStraight($handOfCards, $flush = false) {
	$cardType = [];
	$cardValues = [];
	foreach ($handOfCards as $val) {
		$cardType[] = substr($val, -1);
		$cardValues[] = substr($val, 0, -1);
	}

	$cardValues = convertNumeric($cardValues);
	sort($cardValues);

	// Check if consiqutive
	for ($i=0; $i < count($cardValues); $i++) { 
		if (isset($cardValues[$i+1]) && ($cardValues[$i+1] != $cardValues[$i] +1) ) {
			return false;
		}
	}

	if ($flush) {
		return count(array_unique($cardType)) == 1 ? true : false;
	}

	return true;
}

function convertNumeric($cardValues) {
	$arr = [
		'a' => 14,
		'k' => 13,
		'q' => 12,
		'j' => 11,
	];

	foreach ($cardValues as $key => $value) {
		if (array_key_exists($value, $arr)) {
			$cardValues[$key] = $arr[$value];
		}
	}

	return $cardValues;
}
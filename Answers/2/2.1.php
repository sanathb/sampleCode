<?php

/*
Question #2.1
The word 'Lorem' is ciphered to the number 121518513.
Provide a function that is able to convert any defined word using the same cipher pattern.
Test the function using the word 'Ipsum' and provide the returned number.
*/


//Method 1
Class SbCipher
{
	/**
	 * Get the cipher for a given string
	 *
	 * @param $string string
	 * @return string
	 */
	public function cipher($string) {
		$string = strtolower($string);
		$chars = str_split($string);
		$res = '';

		foreach ($chars as $char) {
			$res = $res . $this->getCipher($char);
		}

		return $res;
	}

	/**
	 * Get the cipher for a char
	 *
	 * @param $char string
	 * @return int
	 */
	protected function getCipher($char) {
		return ord($char) - ord('a') + 1;
	}
}

echo "\nMethod 1:\n";
$cipher = new SbCipher();
echo "\n Cipher of Lorem is " . $cipher->cipher('Lorem') . "\n";
echo "\n Cipher of Ipsum is " . $cipher->cipher('Ipsum') . "\n";


//Method 2
Class MyCipher
{
	public static $map = [
		'a' => 1,
		'b' => 2,
		'c' => 3,
		'd' => 4,
		'e' => 5,
		'f' => 6,
		'g' => 7,
		'h' => 8,
		'i' => 9,
		'j' => 10,
		'k' => 11,
		'l' => 12,
		'm' => 13,
		'n' => 14,
		'o' => 15,
		'p' => 16,
		'q' => 17,
		'r' => 18,
		's' => 19,
		't' => 20,
		'u' => 21,
		'v' => 22,
		'w' => 23,
		'x' => 24,
		'y' => 25,
		'z' => 26,
	];

	/**
	 * Get the cipher for a given string
	 *
	 * @param $string string
	 * @return string
	 */
	public function cipher($string) {
		$string = strtolower($string);
		$chars = str_split($string);
		$res = '';

		foreach ($chars as $char) {
			$res = $res . $this->getMap($char);
		}

		return $res;
	}

	/**
	 * Get the cipher for a given char
	 *
	 * @param $char string
	 * @return int
	 */
	protected function getMap($char) {
		// We can add checks if the key exists. 
		// Here the assumption is its all chars
		return self::$map[$char];
	}
}


echo "\nMethod 2:\n";
$cipher = new MyCipher();
echo "\n Cipher of Lorem is " . $cipher->cipher('Lorem') . "\n";
echo "\n Cipher of Ipsum is " . $cipher->cipher('Ipsum') . "\n";





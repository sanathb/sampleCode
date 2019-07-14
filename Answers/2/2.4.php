<?php
/*Write a fluent interface that will get and set the following data:
• Name
• Phone Number
• Email*/

class Person
{
	protected $name;
	protected $phone;
	protected $email;

	function setName($name) {
		$this->name = $name;
		return $this;

	}

	function getName() {
		return $this->name;
	}

	function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}

	function getPhone() {
		return $this->phone;
	}

	function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	function getEmail() {
		return $this->email;
	}
}


$person = new Person();
$person
->setName('Sanath')
->setEmail('test@test.com')
->setPhone(123456789);

echo "\n Name is " . $person->getName() . 
"\n Email is " .
$person->getEmail() .
"\n Phone is " .
$person->getPhone() .
"\n";
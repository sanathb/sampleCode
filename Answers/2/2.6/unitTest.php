<?php
use Sanath;
use PHPUnit\Framework\TestCase;

Class LogisticsTest extends TestCase
{
	protected $logistics;

	public function setup() {
		$this->logistics = new Sanath\Logistics();
	}

	public function testQueenBirthday() {
		$date = '2019-06-09 10:45:41'; //queen's birthday on 10
		$expectedDispatch = '2019-06-11';
		$expectedDelivery = '2019-06-13';
		$this->assertEquals($expectedDispatch, $this->logistics->getDispatchDate($date));
		$this->assertEquals($expectedDelivery, $this->logistics->getDeliveryDate($date));
	}

	public function testWeekend() {
		$date = '2018-07-07 10:45:41'; //Saturday
		$expectedDispatch = '2018-07-09';
		$expectedDelivery = '2018-07-11';
		$this->assertEquals($expectedDispatch, $this->logistics->getDispatchDate($date));
		$this->assertEquals($expectedDelivery, $this->logistics->getDeliveryDate($date));
	}

	public function testWorkingDay() {
		$date = '2019-07-18 10:45:41';
		$expectedDispatch = '2019-07-18';
		$expectedDelivery = '2019-07-22';
		$this->assertEquals($expectedDispatch, $this->logistics->getDispatchDate($date));
		$this->assertEquals($expectedDelivery, $this->logistics->getDeliveryDate($date));
	}

	public function testAfterBusiness() {
		$date = '2019-07-18 17:45:41';
		$expectedDispatch = '2019-07-19';
		$expectedDelivery = '2019-07-23';
		$this->assertEquals($expectedDispatch, $this->logistics->getDispatchDate($date));
		$this->assertEquals($expectedDelivery, $this->logistics->getDeliveryDate($date));
	}
}
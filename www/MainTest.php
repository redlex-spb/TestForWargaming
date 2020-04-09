<?php
//require_once 'PHPUnit/Framework.php';
require_once 'Main.php';

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase {

	protected $fixture;

	protected function setUp()
	{
		$this->fixture = new Main();
	}

	protected function tearDown()
	{
		$this->fixture = NULL;
	}

	/**
	 * @dataProvider providerData
	 */

	public function testData($a, $b, $c)
	{
		$this->assertEquals($c, $this->fixture->run($a, $b));
	}

	public function providerData ()
	{
		return array (
			array (0, 5, "0, 1, 1, 2, 3, 5"),
			array (0, 15, "0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610"),
			array (3, 3, ""),
			array (-1, 3, ""),
			array ("qwe1", "qwe2", ""),
		);
	}
}
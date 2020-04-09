<?php

declare(strict_types = 1);

class Main
{

	private $redis;

	public $from;
	public $to;

	public function __construct()
	{

		$this->redis = new Redis();
		$this->redis->connect(
			'redis',
			6379
		);

		$this->redis->auth( $_ENV['REDIS_PASSWORD'] );

	}

	public function __destruct()
	{

		$this->redis->close();

	}

	public function run(int $from, int $to): void
	{

		$this->from = $from;
		$this->to = $to;

		$this->validateData();

		$this->sendResponse("success", $this->getFibonacciNumbers() );

	}

	private function validateData(): void
	{

		if ( empty($this->from) ) $this->sendResponse("error","Начальный элемент последовательности пустой");

		if ( empty($this->to) ) $this->sendResponse("error","Конечный элемент последовательности пустой");

		if ( !is_numeric($this->from) ) $this->sendResponse("error","Начальный элемент последовательности не число");

		if ( !is_numeric($this->to) ) $this->sendResponse("error","Конечный элемент последовательности не число");

		if ( $this->from < 0 ) $this->sendResponse("error","Начальный элемент последовательности меньше нуля");

		if ( $this->to < 0 ) $this->sendResponse("error","Конечный элемент последовательности меньше нуля");

		if ( $this->to <= $this->from ) $this->sendResponse("error","Конечный элемент последовательности меньше начального элемента последовательности");

	}

	private function getFibonacciNumbers(): string
	{

		if ( $this->redis->exists($this->from . "-" . $this->to) ) {

			$result = $this->redis->get( $this->from . "-" . $this->to );

			return $result;

		} else {

			$a = (1 + 5 ** 0.5) / 2;
			$result = [];

			for ( $n = $this->from; $n <= $this->to; $n++ ) {
				$result[] = round($a ** $n / 5 ** 0.5);
			}

			$this->redis->set( $this->from . "-" . $this->to, implode(", ",$result));

			return implode(", ",$result);

		}

	}


	private function sendResponse(string $status,string $message): void
	{

		$response = [
			"Status" => $status,
			"Message" => $message
		];

		header('Content-type: application/json');
		echo json_encode($response,JSON_UNESCAPED_UNICODE);
		$this->redis->close();
		exit();

	}

}
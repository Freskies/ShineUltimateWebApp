<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

use JetBrains\PhpStorm\Pure;

/**
 * this class facilitates the uses of years in the project.
 * Years are represented as strings in the format "2021-2022".
 *
 * @author valerio
 * @version 1.0
 */
class Year
{
	/**
	 * @var int the year when the course is started
	 */
	private int $year_start;
	/**
	 * @var int the year when the course is ended
	 */
	private int $year_end;

	public function __construct()
	{
		// if the current month is before September, the year is the past year
		$this->year_start = date('m') < 9 ?
			((int) date('Y')) - 1 :
			(int) date('Y');
		$this->year_end = $this->year_start + 1;
	}

	/**
	 * @param int $year_to_add the number of years to add to the current year
	 * @return string the year in the format "year_start-year_end"
	 */
	public function addYear(int $year_to_add): string
	{
		$this->year_start += $year_to_add;
		$this->year_end += $year_to_add;
		return $this->__toString();
	}

	/**
	 * @param int $year_start the year when the course is started (default: current year)
	 * @param int $year_end the year when the course is ended (default: current year + 1)
	 * @return string the year in the format "year_start-year_end"
	 */
	private function getString(int $year_start, int $year_end): string
	{
		return $year_start . '-' . $year_end;
	}

	/**
	 * @return string the year in the format "year_start-year_end"
	 */
	#[Pure] public function __toString(): string
	{
		return $this->getString($this->year_start, $this->year_end);
	}
}
<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

/**
 * this class facilitates the uses of years in the project.
 * Years are represented as strings in the format "2021-2022".
 *
 * @author valerio
 * @version 2.0
 */
class Year
{
	/**
	 * @var int the first year of the 2-year period: in case 2021-2022 the year-start is 2021
	 */
	private int $year_start;
	/**
	 * @var int the second year of the 2-year period: in case 2021-2022 the year-end is 2022
	 */
	private int $year_end;

	/**
	 * @return Year the current year
	 */
	public static function getCurrentYear(): Year
	{
		// if the current month is before September, the year is the past year
		return new Year(date('n') < 9 ? date('Y') - 1 : date('Y'));
	}

	public function __construct(string|int $year_start)
	{
		// if the string is not large 4 characters, it is not a valid year
		if (strlen((string)$year_start) != 4)
			throw new InvalidArgumentException('invalid year');

		$this->year_start = (int)$year_start;
		$this->year_end = $this->year_start + 1;
	}

	/**
	 * @return string the year in the format "year_start-year_end"
	 */
	public function __toString(): string
	{
		return $this->year_start . '-' . $this->year_end;
	}
}
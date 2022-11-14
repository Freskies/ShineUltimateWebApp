<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

class Course
{
	private int $id;
	private string $name;
	private Year $year;

	/**
	 * @param int $id
	 * @param string $name
	 * @param Year $year
	 */
	public function __construct(int $id, string $name, Year $year)
	{
		$this->id = $id;
		$this->name = $name;
		$this->year = $year;
	}

	// GETTERS

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return Year
	 */
	public function getYear(): Year
	{
		return $this->year;
	}

	// FUNCTIONS

	/**
	 * an active course is a course that is in the current year
	 * @return bool true if the course is active, false otherwise
	 */
	public function isActive(): bool
	{
		return $this->year == Year::getCurrentYear();
	}

	// STATIC FUNCTIONS

	/**
	 * @param Year $year the year of the courses to get
	 * @param array $courses the courses to filter
	 * @return array the courses of the given year
	 */
	public static function getCoursesFromYear(Year $year, array $courses): array
	{
		$courses_from_year = array();
		foreach ($courses as $course)
			if ($course->getYear() == $year)
				$courses_from_year[] = $course;
		return $courses_from_year;
	}

	/**
	 * @param array $courses the courses to filter
	 * @return array the active courses
	 */
	public static function getActiveCourses(array $courses): array
	{
		$active_courses = array();
		foreach ($courses as $course)
			if ($course->isActive())
				$active_courses[] = $course;
		return $active_courses;
	}

	/**
	 * @param array $courses the courses to filter
	 * @return array the inactive courses
	 */
	public static function getInactiveCourses(array $courses): array
	{
		$inactive_courses = array();
		foreach ($courses as $course)
			if (!$course->isActive())
				$inactive_courses[] = $course;
		return $inactive_courses;
	}
}
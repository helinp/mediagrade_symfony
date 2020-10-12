<?php
namespace App\Utils;

class SchoolYear
{

	private const MMDD_SCHOOL_YEAR_END = '0630';

	/*
	*	Return a schoolyear from current date
	*	ex: 2020-2021
	*	@param $time_stamp
	*/
	public static function getSchoolYear(): string
	{
		$yy = date('Y');
		$md = date('md');

		if($md > self::MMDD_SCHOOL_YEAR_END)
		{
			return $yy . '-' . ($yy + 1);
		}
		else
		{
			return (($yy - 1) . '-' . $yy);
		}
	}

	/**
	 *	Return array of all school year since 2015-2016
	 *
	 */
	public static function getSchoolYearList(): array
	{
		$init_year = '2015';
		$curr_year = date('Y');
		$array_years = array();

		// check if next schoolYear
		$curr_md = date('md');
		if($curr_md > self::MMDD_SCHOOL_YEAR_END)
		{
			$curr_year++;
		}

		for($i = 0; $curr_year - $i > $init_year  ; $i++)
		{
			$school_year = ($curr_year - $i - 1) . '-' . ($curr_year - $i);
			$array_years[$school_year] = $school_year;
		}
		return $array_years;
	}

}

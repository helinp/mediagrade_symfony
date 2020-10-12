<?php
namespace App\Utils;

class CustomRound
{

	/*
	*	Rounds any float on the nearest 0.5 decimal
	*/
	public static function customRound(float $float): float
	{
		// get only decimal part
		$whole = floor($float);
		$decimal = ($float - $whole) * 10;

		if($decimal >= 8)
		{
			return $whole + 1.0;
		}
		elseif($decimal >= 3)
		{
			return $whole + .5;
		}
		else
		{
			return $whole + .0;
		}
	}

	/*
	*	Converts /10 vote to custom max vote
	*/
	public static function customVote(int $user_letter_vote, int $max_vote): float
	{
		return (float) (($user_letter_vote / 10) * $max_vote);
	}

}

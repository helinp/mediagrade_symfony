<?php
namespace App\Utils;

class LettersVote
{

	static public function getNumericFromLetterVote($letter)
	{
		switch ($letter) {
		  case 'A':
			  return 10;
			  break;
		  case 'EA':
			  return 7;
			  break;
		  case 'AR':
			  return 3;
			  break;
		  case 'NR':
			  return 0;
			  break;
		  default:
			  return null;
			  break;
		}
	}


}

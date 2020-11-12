<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;

use App\Utils\CustomRound;

class GradeExtension extends AbstractExtension
{

	public function __construct(FormFactoryInterface $formFactory)
	{
		$this->formFactory = $formFactory;
	}

	public function getFilters(): array
	{
		return [
			// If your filter generates SAFE HTML, you should add a third
			// parameter: ['is_safe' => ['html']]
			// Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
			// new TwigFilter('d', [$this, 'd']),
			new TwigFilter('custom_round', [$this, 'customRound']),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_color_from_letter_vote', [$this, 'getColorFromLetterVote']),
			new TwigFunction('get_text_from_letter_vote', [$this, 'getTextFromLetterVote']),

			new TwigFunction('get_color_from_old_letter_vote', [$this, 'getColorFromOldLetterVote']),
			new TwigFunction('get_text_from_old_letter_vote', [$this, 'getTextFromOldLetterVote']),

			new TwigFunction('get_color_from_percentage', [$this, 'getColorFromPercentage']),
			new TwigFunction('get_title_from_percentage', [$this, 'getTitleFromPercentage']),
			new TwigFunction('get_letter_from_percentage', [$this, 'getLetterFromPercentage']),
		];
	}


	static public function getColorFromOldLetterVote($letter)
	{
		switch ($letter) {
		  case 'M':
			  return 'blue';
			  break;
		  case 'A':
			  return 'green';
			  break;
		  case 'EA':
			  return 'orange';
			  break;
		  case 'NA':
			  return 'red';
			  break;
		}
	}	static public function getTextFromOldLetterVote($letter)
	{
		switch ($letter) {
		  case 'M':
			  return 'Maîtrisé';
			  break;
		  case 'A':
			  return 'Acquis';
			  break;
		  case 'AE':
			  return 'En aquisition';
			  break;
		  case 'NA':
			  return 'Non acquis';
			  break;
		}
	}
	static public function getColorFromLetterVote($letter)
	{
		switch ($letter) {
		  case 'A':
			  return 'blue';
			  break;
		  case 'EA':
			  return 'green';
			  break;
		  case 'AR':
			  return 'orange';
			  break;
		  case 'NR':
			  return 'red';
			  break;
		  case 'ABS':
			  return 'na';
			  break;
		  case 'NE':
			  return 'na';
			  break;
		}
	}	static public function getTextFromLetterVote($letter)
	{
		switch ($letter) {
		  case 'A':
			  return 'Acquis';
			  break;
		  case 'EA':
			  return 'En acquisition';
			  break;
		  case 'AR':
			  return 'À renforcer';
			  break;
		  case 'NR':
			  return 'Non remis';
			  break;
		  case 'ABS':
			  return 'Absent';
			  break;
		  case 'NE':
			  return 'Non évalué';
			  break;
		}
	}
	static public function getColorFromPercentage($percentage)
	{
		if( ! is_numeric($percentage) OR $percentage === null)
		{
			return 'na';
		}
		
		elseif($percentage > 79)
		{
			return 'blue';
		}
		elseif ($percentage > 69)
		{
			return 'green';
		}
		elseif ($percentage > 49)
		{
			return 'orange';
		}
		elseif ($percentage <= 49)
		{
			return 'red';
		}
		
	}

	static public function getTitleFromPercentage($percentage)
	{
		if($percentage > 79)
		{
			$title = 'Maître';
		}
		elseif ($percentage > 69)
		{
			$title = 'Padawan';
		}
		elseif ($percentage > 49)
		{
			$title = 'Novice';
		}
		elseif($percentage <= 49)
		{
			$title = 'Âme égarée';
		}

		if($percentage === '--' OR $percentage === null)
		{
			$title = 'Fantôme';
		}

		return $title . ' de l\'Audiovisuel';
	}

	static public function getLetterFromPercentage($percentage)
	{
		if($percentage > 79)
		{
			$title = 'TB';
		}
		elseif ($percentage > 69)
		{
			$title = 'B';
		}
		elseif ($percentage > 49)
		{
			$title = 'M';
		}
		elseif ($percentage > 30)
		{
			$title = 'I';
		}
		elseif ($percentage <= 30)
		{
			$title = 'TI';
		}
		
		if($percentage === '--')
		{
			$title = 'NE';
		}

		return $title;
	}

	static public function customRound($percentage)
	{
		return customRound::customRound($percentage);
	}
}

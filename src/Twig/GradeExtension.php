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

			new TwigFunction('get_color_from_percentage', [$this, 'getColorFromPercentage']),
			new TwigFunction('get_title_from_percentage', [$this, 'getTitleFromPercentage']),
			new TwigFunction('get_letter_from_percentage', [$this, 'getLetterFromPercentage']),
		];
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
		}
	}
	static public function getColorFromPercentage($percentage)
	{
		if($percentage > 79)
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
		else
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
		else
		{
			$title = 'Âme égarée';
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
		else
		{
			$title = 'TI';
		}

		return $title;
	}

	static public function customRound($percentage)
	{
		return customRound::customRound($percentage);
	}
}

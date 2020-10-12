<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class AttendanceExtension extends AbstractExtension
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
		//	new TwigFilter('custom_round', [$this, 'customRound']),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_color_from_attendance_percentage', [$this, 'getColorFromPercentage']),
		];
	}

	static public function getColorFromPercentage($percentage)
	{
		if($percentage > 95)
		{
			return '#13c613';
		}
		elseif ($percentage > 90)
		{
			return 'OliveDrab';
		}
		elseif ($percentage > 85)
		{
			return 'orange';
		}
		elseif ($percentage > 80)
		{
			return 'orangeRed';
		}
		elseif ($percentage > 75)
		{
			return 'red';
		}
		else
		{
			return 'maroon';
		}
	}


}

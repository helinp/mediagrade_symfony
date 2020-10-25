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
		if($percentage >= 90)
		{
			return '#00ff00';
		}
		elseif ($percentage >= 80)
		{
			return '#aaff00';
		}
		elseif ($percentage >= 70)
		{
			return '#ffff00';
		}
		elseif ($percentage >= 60)
		{
			return '#ff9800';
		}
		elseif ($percentage >= 50)
		{
			return '#ff5600';
		}
		else
		{
			return '#EA0000';
		}
	}


}

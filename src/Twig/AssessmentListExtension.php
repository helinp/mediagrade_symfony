<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class AssessmentListExtension extends AbstractExtension
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
			new TwigFilter('get_submission_status', [$this, 'getSubmissionStatus'], ['is_safe' => ['html']]),
		];
	}

	public function getFunctions(): array
	{
		return [
			//new TwigFunction('get_color_from_attendance_percentage', [$this, 'getColorFromPercentage'], ['is_safe' => ['html']]),
		];
	}

	static public function getSubmissionStatus($status)
	{
		if( array_key_exists('result', $status) && array_key_exists('submission', $status) )
		{
			if($status['result'] !== null)
			{
				return '<i class="fas fa-check-square text-green"></i> <span style="color:lightgray;font-size:smaller">Corrigé</span>';
			}
			elseif($status['submission'] !== null)
			{
				return '<i class="fas fa-plus-square text-orange"></i> <span style="color:lightgray;font-size:smaller">Rendu</span>';
			}
			else
			{
				return '<i class="far fa-square text-muted"></i> <span style="color:lightgray;font-size:smaller">Non remis</span>';
			}

		}
		else
		{
			return '--';
		}
	}


}

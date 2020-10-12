<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class ChartsExtension extends AbstractExtension
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
			new TwigFilter('d', [$this, 'd']),
			new TwigFilter('chart_data_convert', [$this, 'objectToData', ['is_safe' => ['html']]]),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_chart_bar_config', [$this, 'getBarConfig'], ['is_safe' => ['html']]),
			new TwigFunction('get_chart_radar_config', [$this, 'getRadarConfig'], ['is_safe' => ['html']]),
		];
	}

	public function objectToData($object, $column)
	{
		return "'" . implode("', '", array_column($object, $column)) . "'";
	}

	public function getBarConfig()
	{
		return "
			type: 'bar',
			
			options: {
				
				'scales': {
					'yAxes': [
						{
							'ticks': {
								'beginAtZero': true,
								'display': true,
								'scaleOverride' : true,
								'scaleSteps' : 10,
								'scaleStepWidth' : 10,
								'scaleStartValue' : 0,
								'max' : 100,
								'min': 0
							},
							'gridLines': {
								'display': true,
								'lineWidth': 1,
								'drawOnChartArea': true,
								'drawTicks': true,
								'tickMarkLength': 1,
								'offsetGridLines': true,
								'zeroLineColor': '#942192',
								'color': '#d6d6d6',
								'zeroLineWidth': 2
							},
							'scaleLabel': {
								'display': true,
								'labelString': 'Pourcentage'
							},
							'display': true,
							
						}
					],
					'xAxes': [
						{
							'gridLines': {
								'display': false
							},
							'display': true
						}
					]
				},
				'legend': {
					'display': false,
					'fullWidth': true,
					'position': 'top',
				},
				
			}";
	}

	public function getRadarConfig()
	{
		return "
			type: 'polarArea',

			options: {
				
				'legend': {
					'display': true,
					'fullWidth': true,
					'position': 'bottom',
				}
			}";
	}

}

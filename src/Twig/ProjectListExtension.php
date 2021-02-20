<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class ProjectListExtension extends AbstractExtension
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
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_project_topics', [$this, 'getProjectTopics'], ['is_safe' => ['html']])
		];
	}

	static public function getProjectTopics($project)
	{

		// Var
		$assessments = $project->getAssessments();
		$html = '';

		// Colors
		$colors = ['teal', 'purple', 'orange', 'maroon', 'red', 'green'];
		$topics = [];
		// Return labels
		foreach ($assessments as $ass)
		{
			if($ass->getTopic())
			{
				$topics[ (int) $ass->getTopic()->getId()] = $ass->getTopic()->getName();
			}
		}
		
		ksort($topics);

		foreach ($topics as $i => $topic)
		{
			while($i > 5)
			{
				$i = $i - 5;
			}
	
			$html .= '<span class="label bg-'  . $colors[$i] . '">' . $topic . '</span> ';
		}
		return $html;

	}



}

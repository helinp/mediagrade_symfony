<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;


class VersioningExtension extends AbstractExtension
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
			// new TwigFilter('get_submission_status', [$this, 'getSubmissionStatus'], ['is_safe' => ['html']]),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_git_version', [$this, 'getGitVersion'], ['is_safe' => ['html']]),
		];
	}

	static public function getGitVersion()
	{
		$commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

		return sprintf('dev.%s (%s)', $commitHash, $commitDate->format('Y-m-d H:i:s')); 
	}


}

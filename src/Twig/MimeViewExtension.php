<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Mime\MimeTypes;


class MimeViewExtension extends AbstractExtension
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
			new TwigFilter('get_html_media_viewer', [$this, 'getHtmlMediaViewer'], ['is_safe' => ['html']]),
		];
	}

	public function getFunctions(): array
	{
		return [
		];
	}

	/*
	*	Return a html code to display media
	*/
	public static function getHtmlMediaViewer($url, $mimeType): string
	{

		if($mimeType)
		{

			if(strpos($mimeType, 'image') !== false)
			{
					return '<img class="img-fluid" style="border: 1px solid lightgray" src="' . $url . '" />';
			}
			elseif (strpos($mimeType, 'video') !== false)
			{
				return '
				<div class="embed-responsive embed-responsive-16by9">
					<video controls>
					    <source src="' . $url . '" type="' . $mimeType . '">
					    Sorry, your browser doesn\'t support embedded videos.
					</video>
				</div>
				';
			}
			else
			{
				return '<a href="' . $url . '" >' . $url . '</a>';
			}

		}
		else
		{
			return 'Fichier non reconnu';
		}
	}

}

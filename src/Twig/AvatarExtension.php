<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

use App\Form\Type\SchoolYearsType;
use Symfony\Component\Form\FormFactoryInterface;


class AvatarExtension extends AbstractExtension
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
			new TwigFunction('avatar', [$this, 'avatar']),
		];
	}


	public function avatar($url)
	{
		return (empty($url) ? 'https://i.pravatar.cc/300/?u=' : $url);
	}



	public function getClassesForm()
	{

		// TODO get user id
		$user_id = 1;

		// COURSES
		// get courses
		if ($this->teacher_id !== false) {
			$classes = $this->em->findby('user_id', $user_id);
		} else {
			$classes = $this->em->findAll();
		}

		// get classes
		$classes_array = array();
		foreach ($classes as $row) {
			$classes_array[] = $row->getClass();
		}

		// make simple array [id => name]
		$array = array();

		foreach ($classes_array as $classe) {
			$array[$classe->getId()] = $classe->getName();
		}
	}
}

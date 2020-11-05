<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Criterion;
use Symfony\Component\Routing\RouterInterface;

class CriterionType extends AbstractType
{

	private $router;

	public function __construct(RouterInterface $router)
    {
		$this->router = $router;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name', TextType::class, [
			'label' => false,
			'attr' => [
				'class' => 'typeahead typeahead_criterion',
				'data-autocomplete-url' => $this->router->generate('admin_criterion_list')
				]
		]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Criterion::class,
		]);
	}
}

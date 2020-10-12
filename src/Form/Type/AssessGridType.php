<?php
namespace App\Form\Type;

use App\Entity\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\Type\AssessRowType;

class AssessGridType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('results', CollectionType::class, [
				'entry_type'    => AssessRowType::class,
				'allow_add'     => false,
				'allow_delete'  => false,
				'by_reference'	=> false,
				'error_bubbling' => true,
				'label' => false
				])
				;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		/*
		$resolver->setDefaults([
			'data_class' => Result::class
		]);*/
	}

}

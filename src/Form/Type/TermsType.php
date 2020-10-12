<?php
namespace App\Form\Type;

use App\Entity\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TermsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', EntityType::class, [
			'choice_label' => 'description',
			'label' => 'Période',
			'class' => Term::class,
			'required' => false,
			'placeholder' => 'Toutes',
		
		]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		]);
	}
}

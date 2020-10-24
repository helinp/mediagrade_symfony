<?php
namespace App\Form\Type;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CoursesTopbarType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', EntityType::class, [
			'choice_label' => 'name',
			'label' => 'Cours',
			'class' => Course::class,
			'required' => true
		
		]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		]);
	}
}

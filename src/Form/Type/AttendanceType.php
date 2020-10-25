<?php

namespace App\Form\Type;

use App\Entity\Attendance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AttendanceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('status', ChoiceType::class, [
			'expanded' => TRUE,
			'multiple' => FALSE,
			'attr' => ['class' => 'form-check form-check-inline'],
			//'choice_attr' => ['class' => 'form-check-input'],
			'choices'  => [
				'P' => 'P',
				'A' => 'A',
				'R' => 'R'
			],
			'label_attr' => ['class' => 'btn btn-info'],
			//	'attr' => ['class' => 'btn-group',  'data-toggle' => 'buttons']
			]);
		}
		
		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults([
				'data_class' => Attendance::class,
		]);
	}
}

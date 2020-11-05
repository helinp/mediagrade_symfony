<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Utils\SchoolYear;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SchoolYearsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$choices = SchoolYear::getSchoolYearList();

		$builder->add('schoolYear', ChoiceType::class, [
			 'choices'  =>  $choices,
			 'label' => 'Année scolaire'

		]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		]);
	}
}

<?php
namespace App\Form\Type;

use App\Entity\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssessRowManualType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('comment', TextType::class, [
					'required' => false
					])
					->add('userVote', NumberType::class, [
						'required' => false,
						'attr' => ['size' => 3]
				])
					
				/*->add('userLetter', ChoiceType::class, [
			    'choices'  => [
			        'Acquis' => 'A',
			        'En Aquisition' => 'EA',
			        'A Renforcer' => 'AR',
			        'Non Remis' => 'NR',
			        'Absent' => 'ABS',
			        'Non évalué' => 'NE'
			    ]
				])*/
				;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Result::class
		]);
	}
}

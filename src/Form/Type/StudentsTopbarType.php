<?php
namespace App\Form\Type;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class StudentsTopbarType extends AbstractType
{


	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		define('SCHOOLYEAR', $options['schoolYear']);

		$builder->add('id', EntityType::class, [
			'choice_label' => 'displayName',
			'label' => 'Élève',
			'class' => User::class,
			'required' => false,
			'group_by' => 'currentClasse.classe.name', 
			'placeholder' => 'Choisir un élève',
			'query_builder' => function (EntityRepository $er) {
				return $er->findAllStudentsQueryBuilder(SCHOOLYEAR);
			}
		]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'schoolYear' => ''
		]);
	}
}

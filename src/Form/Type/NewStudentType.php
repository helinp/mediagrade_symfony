<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;
use App\Entity\StudentClasse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class NewStudentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('studentClasses', CollectionType::class, [
			'entry_type'    => StudentClassesType::class,
			'allow_add'     => true,
			'allow_delete'  => false,
			'required' => true,
			'by_reference'	=> false,
			'error_bubbling' => true
		])

		->add('firstName', TextType::class, [
				'attr' => [],
				'label' => 'Prénom'
			])
		->add('lastName', TextType::class, [
				'attr' => [],
				'label' => 'Nom'
			])
		->add('email', EmailType::class, [
				'attr' => [],
				'label' => 'Courriel',
				'empty_data' => '',
				'required' => false,
			])
		->add('userName', TextType::class, [
				'attr' => [],
				'label' => 'Nom d\'utilisateur'
			])
		->add('password', PasswordType::class, [
				'attr' => [],
				'label' => 'Mot de passe',
				'required' => false,
				'empty_data' => ''
			])
		->add('active', CheckboxType::class, [
				'attr' => [],
				'required' => false,
				'label' => 'Actif?'
			])
		->add('save', SubmitType::class, [
			'label' => 'Enregistrer',
			'attr' => ['class' => 'btn-primary btn-sm'],
			])

		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class
		]);
	}
}

<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilePasswordType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
				'invalid_message' => 'Les mots de passes ne correspondent pas.',
				'options' => ['attr' => ['class' => 'password-field']],
				'required' => false,
				'first_options'  => ['label' => 'Nouveau mot de passe'],
				'second_options' => ['label' => 'Confirmation'],
			])
			->add('submit', SubmitType::class, [
				'attr' => ['class' => 'btn btn-danger'],
				'label' => 'Sauver'
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

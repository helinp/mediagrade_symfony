<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('motto', TextType::class, [
				'label' => 'Ma devise',
				'required' => false,
			])
			->add('userAvatar', AvatarType::class, [
				'required' => false,
				'label' => false
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

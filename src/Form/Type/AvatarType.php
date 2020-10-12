<?php

namespace App\Form\Type;

use App\Entity\UserAvatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AvatarType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('imageFile', VichFileType::class, [
				'label' => 'Photo de profil',
				'required' => false,
				'allow_delete' => false,
				'delete_label' => 'Supprimer',
				'download_label' => 'Télécharger',
				'download_uri' => true,
				'asset_helper' => true,
			])
			;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => UserAvatar::class
		]);
	}
}

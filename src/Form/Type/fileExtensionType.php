<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class fileExtensionType extends AbstractType
{
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'choices'  => [

				'Image fixe' => [
					'jpg' => 'jpg',
					'gif' => 'gif',
					'psd' => 'psd'
				],
				'Image animée' => [
					'mp4' => 'mp4',
					'avi' => 'avi'
				],
				'Audio' => [
					'mp3' => 'mp3',
					'wav' => 'wav'
				],
				'Texte' => [
					'pdf' => 'pdf',
					'odf' => 'odf'
				]
			]
		]);
	}

	public function getParent()
	{
		return ChoiceType::class;
	}
}

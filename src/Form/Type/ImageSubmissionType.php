<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\SubmissionFile;

use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageSubmissionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('imageFile', VichImageType::class, [
				'required' => false,
	            'allow_delete' => true,
	            'delete_label' => 'Supprimer',
	            'download_label' => 'Télécharger',
	            'download_uri' => true,
	            'image_uri' => true,
	            'imagine_pattern' => '',
	            'asset_helper' => true,
				'label' => ''
				])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => SubmissionFile::class,
		]);
	}
}

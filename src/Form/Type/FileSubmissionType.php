<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use App\Entity\SubmissionFile;
use Vich\UploaderBundle\Form\Type\VichFileType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FileSubmissionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('imageFile', VichFileType::class, [
					'required' => false,
	            'allow_delete' => false,
	            'delete_label' => 'Effacer',
	            'download_uri' => true,
	            'download_label' => 'Télécharger',
	            'asset_helper' => true,
				])
				->add('public', CheckboxType::class, [
				    'label'    => 'Ajouter à la gallerie publique',
				    'required' => false
				]);
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => SubmissionFile::class,
		]);
	}
}

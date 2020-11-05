<?php
namespace App\Form\Type;

use App\Entity\AttendanceGrid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\Type\AttendanceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Component\Form\CallbackTransformer;

class AttendancesGridType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('attendances', CollectionType::class, [
			'entry_type'    => AttendanceType::class,
						'label' => 'Élèves'
		])
		->add('schoolHour', ChoiceType::class, [
			'choices'  => array_combine(range(0,9),range(0,9)),
			'label' => 'Heure de cours'
			]
		)
		->add('imageFile', VichImageType::class, [
			'required' => false,
			'allow_delete' => true,
			'delete_label' => 'Supprimer',
			'download_label' => 'Télécharger',
			'download_uri' => true,
			'image_uri' => false,
			'imagine_pattern' => '',
			'asset_helper' => true,
			'label' => 'Photo de la fiche de présence'
			])
		->add('date', DateType::class, [
			'widget' => 'single_text',
			'format' => 'yyyy-MM-dd'
		])
		->add('save', SubmitType::class, [
			'attr' => ['class' => 'btn btn-success'],
			'label' => 'Sauver les modifications'
		])

		->get('date')->addModelTransformer(new CallbackTransformer(
	 function ($value) {
		  if(!$value) {
			   return new \DateTime();
		  }
		  return $value;
	 },
	 function ($value) {
		  return $value;
	 }
));


	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => AttendanceGrid::class,
		]);
	}

}

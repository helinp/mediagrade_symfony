<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Submission;
use App\Entity\SelfAssessmentAnswer;
use App\Form\Type\ImageSubmissionType;
use App\Form\Type\FileSubmissionType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\File;

class SubmissionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder

		/*
				->add('submission', FileType::class, [
						// unmapped means that this field is not associated to any entity property
						'mapped' => false,

						// make it optional so you don't have to re-upload the PDF file
						// every time you edit the Product details
						'required' => false,
						'multiple' => ($options['numberOfFiles'] > 1 ? true : false),
						// unmapped fields can't define their validation using annotations
						// in the associated entity, so you can use the PHP constraint classes
						'constraints' => [
								new File([
										'maxSize' => '300M',
										'mimeTypes' => $options['mimeTypes'],
										'mimeTypesMessage' => 'Le format du fichier n\'est pas correct',
								])
						]
				])*/

					->add('submissionFiles', CollectionType::class, [
						'entry_type'    => FileSubmissionType::class,
						'allow_add'     => true,
						'allow_delete'  => true,
						'required' => true,
						'by_reference'	=> false,
						'error_bubbling' => true,
						'label' => 'Remise des fichiers'
					])
				->add('submit', SubmitType::class, [
						'attr' => ['class' => 'btn btn-danger'],
						'label' => 'Remettre mon projet'
					])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Submission::class
		]);
	}
}

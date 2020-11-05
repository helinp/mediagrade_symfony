<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\Type\fileExtensionType;
use App\Form\Type\AssessmentGridType;

use App\Entity\Project;
use App\Entity\Term;
use App\Entity\Course;
use App\Entity\Skill;
use App\Entity\selfAssessmentQuestion;
use App\Entity\AssessmentType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;

class ProjectType extends AbstractType
{

	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name', TextType::class)
		->add('assessmentType',  EntityType::class, [
			'class' => AssessmentType::class,
			'choice_label' => 'description',
		])
		->add('term',  EntityType::class, [
			'class' => Term::class,
			'choice_label' => 'description',
		])
		->add('startDate', DateType::class, [
			'widget' => 'single_text',
			'format' => 'yyyy-MM-dd'
		])
		->add('softDeadline', DateType::class, [
			'widget' => 'single_text',
			'format' => 'yyyy-MM-dd'
		])
		->add('hardDeadline', DateType::class, [
			'widget' => 'single_text',
			'format' => 'yyyy-MM-dd'
		])
		->add('course',  EntityType::class, [
			'class' => Course::class,
			'choice_label' => 'name',
			'query_builder' => function (EntityRepository $er) {
				return $er->createQueryBuilder('c')
					->where('c.teacher = :uid')
					->setParameter('uid', $this->security->getUser()->getId())
					->orderBy('c.name', 'ASC');
			},
		])
		->add('trainedSkills',  EntityType::class, [
			'class' => Skill::class,
			'choice_label' => function ($skill) {
				return $skill->getDisplayName();
			},
			'group_by' => 'skillsGroup.name',
			'attr' => ['size' => 10],
			'multiple' => true
		])

		->add('context', TextType::class)

		->add('instructions', TextType::class, [
			'attr' => ['class' => 'tinymce', 'row' => 12]
		])
		->add('fileExtension', fileExtensionType::class, [
			'required' => false
		])
		->add('numberOfFiles', ChoiceType::class, [
			'choices'  => range(0, 20),
			'required' => true
		])
		->add('teacherSubmitted', CheckboxType::class, [
			'label'    => 'Les fichiers seront téléversés par le professeur?',
			'required' => false,
		])
		->add('external', CheckboxType::class, [
			'label'    => 'Encodage manuel des points?',
			'required' => false,
		])
		->add('selfAssessments', EntityType::class, [
			'class' => selfAssessmentQuestion::class,
			'choice_label' => 'question',
			'required' => false,
			'multiple'  => true,
			'attr' => [
				'size' => '10'
			]
		])

		->add('extraSelfAssessment', TextType::class, [
			'mapped' => false,
			'required' => false
		])

		->add('assessments', CollectionType::class, [
			'entry_type'    => AssessmentGridType::class,
			'allow_add'     => true,
			'allow_delete'  => true,
			'required' => true,
			'by_reference'	=> false,
			'error_bubbling' => true
		])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Project::class
		]);
	}
}

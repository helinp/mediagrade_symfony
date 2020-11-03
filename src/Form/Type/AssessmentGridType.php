<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType ;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\Type\CriterionType;

use App\Entity\Skill;
use App\Entity\Topic;
use App\Entity\GradingSystem;
use App\Entity\Achievement;
use App\Entity\Assessment;

use Symfony\Component\Routing\RouterInterface;

class AssessmentGridType extends AbstractType
{

	private $router;

	public function __construct(RouterInterface $router)
    {
		$this->router = $router;
	}
	
	/**
	 * Used to set up a new project 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('skill', EntityType::class, [
			'class' => Skill::class,
			'choice_label' => 'shortDisplayName',
			'group_by' => 'skillsGroup.name',
			'attr' => array('style' => 'width: 5em')
		])
		->add('criterion', CriterionType::class)

		->add('indicator', TextareaType::class, [
			'attr' => [
				'class' => 'typeahead typeahead_indicator',
				'data-autocomplete-url' => $this->router->generate('admin_indicator_list')
				]
		])

		->add('gradingSystem', EntityType::class, [
			'class' => GradingSystem::class,
			'choice_label' => 'name'
		])
		->add('maxVote', IntegerType ::class, [
			'attr' => array('style' => 'width: 5em', 'step' => '1')
		])
		->add('topic', EntityType::class, [
			'class' => Topic::class,
			'required' => false,
			'choice_label' => 'name'
		])
		->add('achievement', EntityType::class, [
			'class' => Achievement::class,
			'required' => false,
			'choice_label' => function ($achievement) {
				return $achievement->getDisplayName();
			},
		])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Assessment::class

		]);
	}
}

<?php
namespace App\Form\Type;

use App\Entity\Course;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CoursesTopbarType extends AbstractType
{
	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('id', EntityType::class, [
			'choice_label' => 'name',
			'label' => 'Cours',
			'class' => Course::class,
			'required' => false,
			'placeholder' => 'Tous',
			'query_builder' => function (EntityRepository $er) {
				return $er->createQueryBuilder('u')
					->where('u.teacher = :uid')
					->setParameter('uid', $this->security->getUser()->getId())
					->orderBy('u.name', 'ASC');
			},
		]);

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		]);
	}
}

<?php

namespace App\Form\Type;

use App\Entity\Classe;
use App\Entity\StudentClasse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		  ->add('classe', EntityType::class, [
		  				'class' => Classe::class,
		  		      'choice_label' => 'name'
		  			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StudentClasse::class,
        ]);
    }
}

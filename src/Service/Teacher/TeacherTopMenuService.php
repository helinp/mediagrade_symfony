<?php
namespace App\Service\Teacher;

use App\Repository\CoursesRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;


class TeacherTopMenuService
{
	    private $em;
		 private $teacher_id = false;

	    public function __construct(CoursesRepository $em)
		 {
	           $this->em = $em;
	    }

    public function getClassesForm()
    {
		 // COURSES
		 // get courses
  		if($this->teacher_id !== false)
  		{
  			$classes = $this->em->findby('user_id', $this->teacher_id);
  		}
  		else
  		{
  			$classes = $this->em->findAll();
  		}

  		// get classes
		$classes_array = array();
		foreach ($classes as $row)
		{
			$classes_array[] = $row->getClass();
		}

		// make simple array [id => name]
  		$array = array();

  		foreach ($classes_array as $classe)
  		{
			$array[$classe->getId()] = $classe->getName();
  		}

		// FORM
		// TODO: MAKE A TWIG SERVICE
		/*
		$form = $this->createForm()->add('numberOfFiles', ChoiceType::class, [
					'choices'  => range(1, 20),
					'required' => false
				]);
  		return $form;
		*/
    }


	 public function getSchoolYearForm()
	 {
		 // TODO
	 }


}

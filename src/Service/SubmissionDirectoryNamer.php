<?php
namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

use Symfony\Component\String\Slugger\AsciiSlugger;

class SubmissionDirectoryNamer implements DirectoryNamerInterface
{
	public function directoryName($object, PropertyMapping $mapping): string
	{
		$slugger = new AsciiSlugger();

		$project_name = mb_strtolower($slugger->slug( $object->getSubmission()->getProject()->getName() ));
		$course = $slugger->slug( $object->getSubmission()->getProject()->getCourse()->getName() );
		$term = $slugger->slug( $object->getSubmission()->getProject()->getTerm()->getName() );

		$school_year =  $object->getSubmission()->getProject()->getSchoolYear();

		$dir = $school_year . '/' . $course .  '/' .  $term . '_' . $project_name . '/';

		return $dir;
	}
}

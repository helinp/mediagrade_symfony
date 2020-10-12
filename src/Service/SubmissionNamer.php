<?php
namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

use Symfony\Component\String\Slugger\AsciiSlugger;

class SubmissionNamer implements NamerInterface
{

	public function name($object, PropertyMapping $mapping): string
	{
		$slugger = new AsciiSlugger();

		$last_name = $slugger->slug($object->getSubmission()->getStudent()->getLastName());
		$first_name = $slugger->slug($object->getSubmission()->getStudent()->getFirstName());
		$project_name = $slugger->slug( $object->getSubmission()->getProject()->getName() );

		$file = $object->getImageFile();
		$extension = $file->guessExtension();

		$filename = mb_strtoupper($last_name) . '_' . $first_name . '_' . $project_name . '_' . ($object->getId() - 1);
		$slug = sprintf('%s.%s', $filename, $extension);


		return $slug;
	}
}

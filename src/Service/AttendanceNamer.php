<?php
namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

use Symfony\Component\String\Slugger\AsciiSlugger;

class AttendanceNamer implements NamerInterface
{

	public function name($object, PropertyMapping $mapping): string
	{
		$slugger = new AsciiSlugger();

		$schoolyear = $object->getSchoolYear();
		$date = $object->getDate()->format('Y-m-d');
		$school_hour = $object->getSchoolHour();

		$file = $object->getImageFile();
		$extension = $file->guessExtension();

		$filename = $schoolyear . '_' . $date . '_' . $school_hour;
		$slug = sprintf('%s.%s', $filename, $extension);

		return $slug;
	}
}

<?php
namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

use Symfony\Component\String\Slugger\AsciiSlugger;

class ProfileNamer implements NamerInterface
{

	public function name($object, PropertyMapping $mapping): string
	{
		$slugger = new AsciiSlugger();

		$last_name = $slugger->slug($object->getUser()->getLastName());
		$first_name = $slugger->slug($object->getUser()->getFirstName());

		$file = $object->getImageFile();
		$extension = $file->guessExtension();

		$filename = mb_strtoupper($last_name) . '_' . $first_name;
		$slug = sprintf('%s.%s', $filename, $extension);


		return $slug;
	}
}

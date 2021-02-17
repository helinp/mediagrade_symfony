<?php
namespace App\Utils;

class TitleFromRole
{


	public static function getTitleFromRoles($roles)
	{

		if(is_array($roles))
		{
			$role = $roles[0];
		}
		else
		{
			$role = $roles;
		}	

		switch ($role) {
			case 'ROLE_ADMIN':
				return 'Administrateur';
				break;
			case 'ROLE_TEACHER':
				return 'Professeur';
				break;
			case 'ROLE_ELEVE':
				return 'Élève';
				break;
			
			default:
				break;
		}
	}


}
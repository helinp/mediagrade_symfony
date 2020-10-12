<?php
namespace App\Utils;

class GradeBook
{

	/*
	*	
	*/
	public static function getGradeBook($projects, $course)
	{
	
		// var 
		$table = ['body', 'header'];
		$n_project = 0;
		$n_student = 0;
		$n_assess = 0;

		// get students 
		$students = $course->getClasse()->getCurrentStudents();

		foreach($projects as $project)
		{
			$table['header'][$n_project] = $project; 


			foreach($project->getAssessments() as $assessment)
			{

				
				foreach($students as $student)
				{
					foreach ($assessment->getResults() as $result)
					{
						if($result->getStudent()->getId() === $student->getId())
						{
							$table['body'][$n_student][$n_project][$n_assess] = $result;
						}
					}
					
					if(empty($table['body'][$n_student][$n_project]))
					{
					//	$table['body'][$n_student][$n_project][$n_assess] = null;
					}

					$n_student++;



				}

				$n_assess++;
			}


			$n_project++;
		}


		return $table;
	}



}

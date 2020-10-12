<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="classe", orphanRemoval=true)
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="classe")
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity=StudentClasse::class, mappedBy="classe")
     */
    private $studentClasses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->studentClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setClasse($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getClasse() === $this) {
                $course->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

		public function getCurrentStudents($schoolyear = null)
		{
				$criteria = Criteria::create()
                        ->andWhere(Criteria::expr()->eq('schoolyear', ($schoolyear ? $schoolyear : \App\Utils\SchoolYear::getSchoolYear())))
                        ;
				return $this->getStudentClasses()->matching($criteria);
		}


    public function addStudent(User $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addClasse($this);
        }

        return $this;
    }

    public function removeStudent(User $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeClasse($this);
        }

        return $this;
    }

    /**
     * @return Collection|StudentClasse[]
     */
    public function getStudentClasses(): Collection
    {
        return $this->studentClasses;
    }

    public function addStudentClass(StudentClasse $studentClass): self
    {
        if (!$this->studentClasses->contains($studentClass)) {
            $this->studentClasses[] = $studentClass;
            $studentClass->setClasse($this);
        }

        return $this;
    }

    public function removeStudentClass(StudentClasse $studentClass): self
    {
        if ($this->studentClasses->contains($studentClass)) {
            $this->studentClasses->removeElement($studentClass);
            // set the owning side to null (unless already changed)
            if ($studentClass->getClasse() === $this) {
                $studentClass->setClasse(null);
            }
        }

        return $this;
    }
}

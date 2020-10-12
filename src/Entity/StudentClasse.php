<?php

namespace App\Entity;

use App\Repository\StudentClasseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentClasseRepository::class)
 */
class StudentClasse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="studentClasses")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="studentClasses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $schoolyear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?user
    {
        return $this->student;
    }

      public function setStudent(?user $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getSchoolyear(): ?string
    {
        return $this->schoolyear;
    }

    public function setSchoolyear(string $schoolyear): self
    {
        $this->schoolyear = $schoolyear;

        return $this;
    }
}

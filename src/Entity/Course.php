<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="course")
     */
    private $projects;


    /**
     * @ORM\OneToMany(targetEntity=AttendanceGrid::class, mappedBy="course")
     */
    private $attendanceGrids;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->attendanceGrids = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getclasse(): ?classe
    {
        return $this->classe;
    }

    public function setclasse(?classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCourse($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCourse() === $this) {
                $project->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attendance[]
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setCourse($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->contains($attendance)) {
            $this->attendances->removeElement($attendance);
            // set the owning side to null (unless already changed)
            if ($attendance->getCourse() === $this) {
                $attendance->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttendanceGrid[]
     */
    public function getAttendanceGrids(): Collection
    {
        return $this->attendanceGrids;
    }

    public function addAttendanceGrid(AttendanceGrid $attendanceGrid): self
    {
        if (!$this->attendanceGrids->contains($attendanceGrid)) {
            $this->attendanceGrids[] = $attendanceGrid;
            $attendanceGrid->setCourse($this);
        }

        return $this;
    }

    public function removeAttendanceGrid(AttendanceGrid $attendanceGrid): self
    {
        if ($this->attendanceGrids->contains($attendanceGrid)) {
            $this->attendanceGrids->removeElement($attendanceGrid);
            // set the owning side to null (unless already changed)
            if ($attendanceGrid->getCourse() === $this) {
                $attendanceGrid->setCourse(null);
            }
        }

        return $this;
    }
}

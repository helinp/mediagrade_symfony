<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $schoolYear;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $instructions;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $hardDeadline;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $softDeadline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $external;

    /**
     * @ORM\Column(type="text")
     */
    private $context;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="projects")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Assessment::class, mappedBy="project", orphanRemoval=true, cascade={"persist"})
     */
    private $assessments;

    /**
     * @ORM\ManyToOne(targetEntity=AssessmentType::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assessmentType;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class)
     */
    private $trainedSkills;

    /**
     * @ORM\ManyToMany(targetEntity=SelfAssessmentQuestion::class)
     */
    private $selfAssessments;

    /**
     * @ORM\ManyToOne(targetEntity=Term::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $term;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $fileExtension;

    /**
     * @ORM\Column(type="smallint")
     */
    private $numberOfFiles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $teacherSubmitted;

    /**
     * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="project", orphanRemoval=true)
     */
    private $submissions;

    /**
     * @ORM\OneToMany(targetEntity=SelfAssessmentAnswer::class, mappedBy="project", orphanRemoval=true)
     */
    private $selfAssessmentAnswers;

    public function __construct()
    {
        $this->assessments = new ArrayCollection();
        $this->trainedSkills = new ArrayCollection();
        $this->selfAssessments = new ArrayCollection();
        $this->submissions = new ArrayCollection();
        $this->selfAssessmentAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchoolYear(): ?string
    {
        return $this->schoolYear;
    }

    public function setSchoolYear(string $schoolYear): self
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getHardDeadline(): ?\DateTimeInterface
    {
        return $this->hardDeadline;
    }

    public function setHardDeadline(\DateTimeInterface $hardDeadline): self
    {
        $this->hardDeadline = $hardDeadline;

        return $this;
    }

    public function getSoftDeadline(): ?\DateTimeInterface
    {
        return $this->softDeadline;
    }

    public function setSoftDeadline(?\DateTimeInterface $softDeadline): self
    {
        $this->softDeadline = $softDeadline;

        return $this;
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

    public function getActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    public function getExternal(): ?bool
    {
        return $this->external;
    }

    public function setExternal(bool $external): self
    {
        $this->external = $external;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

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
     * @return Collection|Assessment[]
     */
    public function getAssessments(): Collection
    {
        return $this->assessments;
    }

    public function addAssessment(Assessment $assessment): self
    {
        if (!$this->assessments->contains($assessment)) {
            $this->assessments[] = $assessment;
            $assessment->setProject($this);
        }

        return $this;
    }

    public function removeAssessment(Assessment $assessment): self
    {
        if ($this->assessments->contains($assessment)) {
            $this->assessments->removeElement($assessment);
            // set the owning side to null (unless already changed)
            if ($assessment->getProject() === $this) {
                $assessment->setProject(null);
            }
        }

        return $this;
    }

    public function getAssessmentType(): ?AssessmentType
    {
        return $this->assessmentType;
    }

    public function setAssessmentType(?AssessmentType $assessmentType): self
    {
        $this->assessmentType = $assessmentType;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getTrainedSkills(): Collection
    {
        return $this->trainedSkills;
    }

    public function addTrainedSkill(Skill $trainedSkill): self
    {
        if (!$this->trainedSkills->contains($trainedSkill)) {
            $this->trainedSkills[] = $trainedSkill;
        }

        return $this;
    }

    public function removeTrainedSkill(Skill $trainedSkill): self
    {
        if ($this->trainedSkills->contains($trainedSkill)) {
            $this->trainedSkills->removeElement($trainedSkill);
        }

        return $this;
    }

    /**
     * @return Collection|SelfAssessmentQuestion[]
     */
    public function getSelfAssessments(): Collection
    {
        return $this->selfAssessments;
    }

    public function addSelfAssessment(SelfAssessmentQuestion $selfAssessment): self
    {
        if (!$this->selfAssessments->contains($selfAssessment)) {
            $this->selfAssessments[] = $selfAssessment;
        }

        return $this;
    }

    public function removeSelfAssessment(SelfAssessmentQuestion $selfAssessment): self
    {
        if ($this->selfAssessments->contains($selfAssessment)) {
            $this->selfAssessments->removeElement($selfAssessment);
        }

        return $this;
    }

    public function getTerm(): ?Term
    {
        return $this->term;
    }

    public function setTerm(?Term $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    public function setFileExtension(?string $fileExtension): self
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    public function getNumberOfFiles(): ?int
    {
        return $this->numberOfFiles;
    }

    public function setNumberOfFiles(int $numberOfFiles): self
    {
        $this->numberOfFiles = $numberOfFiles;

        return $this;
    }

    public function getTeacherSubmitted(): ?bool
    {
        return $this->teacherSubmitted;
    }

    public function setTeacherSubmitted(bool $teacherSubmitted): self
    {
        $this->teacherSubmitted = $teacherSubmitted;

        return $this;
    }

    /**
     * @return Collection|Submission[]
     */
    public function getSubmissions(): Collection
    {
        return $this->submissions;
    }

    public function addSubmission(Submission $submission): self
    {
        if (!$this->submissions->contains($submission)) {
            $this->submissions[] = $submission;
            $submission->setProject($this);
        }

        return $this;
    }

    public function removeSubmission(Submission $submission): self
    {
        if ($this->submissions->contains($submission)) {
            $this->submissions->removeElement($submission);
            // set the owning side to null (unless already changed)
            if ($submission->getProject() === $this) {
                $submission->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SelfAssessmentAnswer[]
     */
    public function getSelfAssessmentAnswers(): Collection
    {
        return $this->selfAssessmentAnswers;
    }

    public function addSelfAssessmentAnswer(SelfAssessmentAnswer $selfAssessmentAnswer): self
    {
        if (!$this->selfAssessmentAnswers->contains($selfAssessmentAnswer)) {
            $this->selfAssessmentAnswers[] = $selfAssessmentAnswer;
            $selfAssessmentAnswer->setProject($this);
        }

        return $this;
    }

    public function removeSelfAssessmentAnswer(SelfAssessmentAnswer $selfAssessmentAnswer): self
    {
        if ($this->selfAssessmentAnswers->contains($selfAssessmentAnswer)) {
            $this->selfAssessmentAnswers->removeElement($selfAssessmentAnswer);
            // set the owning side to null (unless already changed)
            if ($selfAssessmentAnswer->getProject() === $this) {
                $selfAssessmentAnswer->setProject(null);
            }
        }

        return $this;
    }
}

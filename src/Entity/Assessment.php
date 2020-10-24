<?php

namespace App\Entity;

use App\Repository\AssessmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssessmentRepository::class)
 */
class Assessment
{

    const GRADING_3_LETTRES = 1;
    const GRADING_POINTS = 2;
    const GRADING_OLD_LETTRES = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indicator;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxVote;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="assessments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * @ORM\ManyToOne(targetEntity=Criterion::class, inversedBy="assessments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $criterion;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="assessments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=Achievement::class, inversedBy="assessments")
     */
    private $achievement;

    /**
     * @ORM\ManyToOne(targetEntity=GradingSystem::class)
     */
    private $gradingSystem;

    /**
     * @ORM\ManyToOne(targetEntity=Topic::class, inversedBy="assessments")
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="assessment", orphanRemoval=true)
     */
    private $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndicator(): ?string
    {
        return $this->indicator;
    }

    public function setIndicator(string $indicator): self
    {
        $this->indicator = $indicator;

        return $this;
    }

    public function getMaxVote(): ?int
    {
        return $this->maxVote;
    }

    public function setMaxVote(int $maxVote): self
    {
        $this->maxVote = $maxVote;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getCriterion(): ?Criterion
    {
        return $this->criterion;
    }

    public function setCriterion(?Criterion $criterion): self
    {
        $this->criterion = $criterion;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getAchievement(): ?Achievement
    {
        return $this->achievement;
    }

    public function setAchievement(?Achievement $achievement): self
    {
        $this->achievement = $achievement;

        return $this;
    }

    public function getGradingSystem(): ?GradingSystem
    {
        return $this->gradingSystem;
    }

    public function setGradingSystem(?GradingSystem $gradingSystem): self
    {
        $this->gradingSystem = $gradingSystem;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return Collection|Result[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setAssessment($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getAssessment() === $this) {
                $result->setAssessment(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use App\Repository\SelfAssessmentQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SelfAssessmentQuestionRepository::class)
 */
class SelfAssessmentQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="selfAssessmentQuestions")
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=SelfAssessmentAnswer::class, mappedBy="selfAssessmentQuestion", orphanRemoval=true)
     */
    private $selfAssessmentAnswers;

    public function __construct()
    {
        $this->selfAssessmentAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

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
            $selfAssessmentAnswer->setSelfAssessmentQuestion($this);
        }

        return $this;
    }

    public function removeSelfAssessmentAnswer(SelfAssessmentAnswer $selfAssessmentAnswer): self
    {
        if ($this->selfAssessmentAnswers->contains($selfAssessmentAnswer)) {
            $this->selfAssessmentAnswers->removeElement($selfAssessmentAnswer);
            // set the owning side to null (unless already changed)
            if ($selfAssessmentAnswer->getSelfAssessmentQuestion() === $this) {
                $selfAssessmentAnswer->setSelfAssessmentQuestion(null);
            }
        }

        return $this;
    }
}

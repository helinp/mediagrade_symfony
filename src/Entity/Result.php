<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultRepository::class)
 */
class Result
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Assessment::class, inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assessment;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxVote;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $userVote;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $userLetter;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $wasAbsent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getAssessment(): ?Assessment
    {
        return $this->assessment;
    }

    public function setAssessment(?Assessment $Assessment): self
    {
        $this->assessment = $Assessment;

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

    public function getUserVote(): ?float
    {
        return $this->userVote;
    }

    public function setUserVote(float $userVote): self
    {
        $this->userVote = $userVote;

        return $this;
    }

    public function getUserLetter(): ?string
    {
        return $this->userLetter;
    }

    public function setUserLetter(?string $userLetter): self
    {
        $this->userLetter = $userLetter;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getWasAbsent(): ?bool
    {
        return $this->wasAbsent;
    }

    public function setWasAbsent(?bool $wasAbsent): self
    {
        $this->wasAbsent = $wasAbsent;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}

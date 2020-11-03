<?php

namespace App\Entity;

use App\Repository\SubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubmissionRepository::class)
 */
class Submission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="submissions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="submissions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=SubmissionFile::class, mappedBy="submission", orphanRemoval=true, cascade={"persist"})
     */
    private $submissionFiles;

    public function __construct()
    {
        $this->submissionFiles = new ArrayCollection();
		  $this->datetime = new \DateTimeImmutable();
    }

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

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getProject(): ?project
    {
        return $this->project;
    }

    public function setProject(?project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|SubmissionFile[]
     */
    public function getSubmissionFiles(): Collection
    {
        return $this->submissionFiles;
    }

    public function addSubmissionFile(SubmissionFile $submissionFile): self
    {
        if (!$this->submissionFiles->contains($submissionFile)) {
            $this->submissionFiles[] = $submissionFile;
            $submissionFile->setSubmission($this);
        }

        return $this;
    }

    public function removeSubmissionFile(SubmissionFile $submissionFile): self
    {
        if ($this->submissionFiles->contains($submissionFile)) {
            $this->submissionFiles->removeElement($submissionFile);
            // set the owning side to null (unless already changed)
            if ($submissionFile->getSubmission() === $this) {
                $submissionFile->setSubmission(null);
            }
        }

        return $this;
    }
}

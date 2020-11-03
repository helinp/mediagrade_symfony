<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CriterionRepository::class)
 */
class Criterion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=512)
     * @Groups("main")
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity=Assessment::class, mappedBy="criterion")
     */
    private $assessments;
    
    public function __construct()
    {
        $this->assessments = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @Groups("main")
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $assessment->setCriterion($this);
        }

        return $this;
    }

    public function removeAssessment(Assessment $assessment): self
    {
        if ($this->assessments->contains($assessment)) {
            $this->assessments->removeElement($assessment);
            // set the owning side to null (unless already changed)
            if ($assessment->getCriterion() === $this) {
                $assessment->setCriterion(null);
            }
        }

        return $this;
    }
}

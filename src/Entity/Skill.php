<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
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
    private $shortName;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=SkillsGroup::class, inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skillsGroup;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $transverseSkill;

    /**
     * @ORM\OneToMany(targetEntity=Assessment::class, mappedBy="skill")
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

    public function getShortName(): ?string
    {
        return $this->shortName;
    }
    
    public function getShortDisplayName(): ?string
    {
        return $this->shortName . ' - ' .  mb_substr($this->getDescription(), 0, 25) . '...';
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

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

    public function getSkillsGroup(): ?SkillsGroup
    {
        return $this->skillsGroup;
    }

    public function setSkillsGroup(?SkillsGroup $skillsGroup): self
    {
        $this->skillsGroup = $skillsGroup;

        return $this;
    }

    public function getTransverseSkill(): ?string
    {
        return $this->transverseSkill;
    }

    public function setTransverseSkill(?string $transverseSkill): self
    {
        $this->transverseSkill = $transverseSkill;

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
            $assessment->setSkill($this);
        }

        return $this;
    }

    public function removeAssessment(Assessment $assessment): self
    {
        if ($this->assessments->contains($assessment)) {
            $this->assessments->removeElement($assessment);
            // set the owning side to null (unless already changed)
            if ($assessment->getSkill() === $this) {
                $assessment->setSkill(null);
            }
        }

        return $this;
    }

		public function getDisplayName()
		{
			return $this->shortName . ' ' . $this->description;
		}
}

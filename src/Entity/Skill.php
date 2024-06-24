<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "skills")]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $slug;

    #[ORM\OneToMany(targetEntity: SkillTranslation::class, mappedBy: 'skill')]
    private Collection $skillTranslation;
    public function __construct(){
        $this->skillTranslation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addTranslation(SkillTranslation $skillTranslation): self
    {
        if (!$this->skillTranslation->contains($skillTranslation)) {
            $this->skillTranslation[] = $skillTranslation;
            $skillTranslation->setSkill($this);
        }

        return $this;
    }

    public function removeTranslation(SkillTranslation $skillTranslation): self
    {
        $this->skillTranslation->removeElement($skillTranslation);

        return $this;
    }
}

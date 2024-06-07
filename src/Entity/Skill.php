<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    private ?SluggerInterface $slugger = null;

    public function __construct()
    {
        // Initialize properties if needed
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlugger(SluggerInterface $slugger): void
    {
        $this->slugger = $slugger;
    }

    public function generateSlug(): void
    {
        if ($this->slugger !== null && $this->name !== null) {
            $this->slug = $this->slugger->slug($this->name)->lower();
        }
    }
}

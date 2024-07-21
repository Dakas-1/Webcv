<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

#[ORM\Entity]
#[ORM\Table(name: "skills")]
class Skill implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;
    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $slug;

    public function __get($name)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $name);
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}

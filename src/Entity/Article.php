<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PropertyAccess\PropertyAccess;

#[ORM\Entity]
#[ORM\Table(name: "articles")]
#[ORM\UniqueConstraint(name: "article_slug_uidx", columns: ['slug'])]
#[UniqueEntity(['slug'])]
class Article implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;
    #[ORM\Column(type: "string", length: 255,)]
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

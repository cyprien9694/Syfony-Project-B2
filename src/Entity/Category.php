<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Star;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Star::class, orphanRemoval: true)]
    private Collection $stars;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

    // -------- GETTERS & SETTERS --------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Star>
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Star $star): static
    {
        if (!$this->stars->contains($star)) {
            $this->stars->add($star);
            $star->setCategory($this);
        }
        return $this;
    }

    public function removeStar(Star $star): static
    {
        if ($this->stars->removeElement($star)) {
            if ($star->getCategory() === $this) {
                $star->setCategory(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}

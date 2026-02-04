<?php

namespace App\Entity;

use App\Repository\StarOfTheDayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarOfTheDayRepository::class)]
class StarOfTheDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom de l’étoile
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    // Image
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    // Catégorie (string simple pour rester clean)
    #[ORM\Column(length: 100)]
    private ?string $category = null;

    // Visible le soir ?
    #[ORM\Column(type: 'boolean')]
    private bool $visibleTonight = true;

    // Checklist : vue ou non
    #[ORM\Column(type: 'boolean')]
    private bool $seen = false;

    // Date du jour (très important)
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    /* ===================== GETTERS / SETTERS ===================== */

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function isVisibleTonight(): bool
    {
        return $this->visibleTonight;
    }

    public function setVisibleTonight(bool $visibleTonight): static
    {
        $this->visibleTonight = $visibleTonight;
        return $this;
    }

    public function isSeen(): bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): static
    {
        $this->seen = $seen;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }
}

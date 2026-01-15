<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Recette
{
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        min: 3, 
        max: 100, 
        minMessage: "Le titre doit faire au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $titre = null;

    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(min: 10, minMessage: "La description doit faire au moins {{ limit }} caractères.")]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Les ingrédients sont obligatoires.")]
    private ?string $ingredients = null;

    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(string $titre): self { $this->titre = $titre; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }

    public function getIngredients(): ?string { return $this->ingredients; }
    public function setIngredients(string $ingredients): self { $this->ingredients = $ingredients; return $this; }
}

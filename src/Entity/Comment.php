<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank]
    private ?string $author = null;

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank]
    private ?string $content = null;

    #[ORM\Column(type:"string", length:50)]
    private ?string $category = null;

    #[ORM\Column(type:"datetime")]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $image = null;

    // RELATION AVEC USER
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable:false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    // --- GETTERS / SETTERS ---
    public function getId(): ?int { return $this->id; }
    public function getAuthor(): ?string { return $this->author; }
    public function setAuthor(string $author): self { $this->author = $author; return $this; }
    public function getContent(): ?string { return $this->content; }
    public function setContent(string $content): self { $this->content = $content; return $this; }
    public function getCategory(): ?string { return $this->category; }
    public function setCategory(string $category): self { $this->category = $category; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self { $this->image = $image; return $this; }
    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }
}

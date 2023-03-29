<?php

namespace App\Entity;

use App\Repository\DetailsArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsArticleRepository::class)]
class DetailsArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $estAchete = null;

    #[ORM\ManyToOne()]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'detailsArticles')]
    private ?ListeCourse $listeCourse = null;

    #[ORM\Column]
    private ?bool $estImportant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEstAchete(): ?bool
    {
        return $this->estAchete;
    }

    public function setEstAchete(bool $estAchete): self
    {
        $this->estAchete = $estAchete;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getListeCourse(): ?ListeCourse
    {
        return $this->listeCourse;
    }

    public function setListeCourse(?ListeCourse $listeCourse): self
    {
        $this->listeCourse = $listeCourse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->article->getNom();
    }

    public function isEstImportant(): ?bool
    {
        return $this->estImportant;
    }

    public function setEstImportant(bool $estImportant): self
    {
        $this->estImportant = $estImportant;

        return $this;
    }
}

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
    private ?int $quantité = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $estAcheté = null;

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

    public function getQuantité(): ?int
    {
        return $this->quantité;
    }

    public function setQuantité(int $quantité): self
    {
        $this->quantité = $quantité;

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

    public function isEstAcheté(): ?bool
    {
        return $this->estAcheté;
    }

    public function setEstAcheté(bool $estAcheté): self
    {
        $this->estAcheté = $estAcheté;

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

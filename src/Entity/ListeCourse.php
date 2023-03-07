<?php

namespace App\Entity;

use App\Repository\ListeCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeCourseRepository::class)]
class ListeCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'listeCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateurs = null;

    #[ORM\OneToMany(mappedBy: 'listeCourse', targetEntity: DetailsArticle::class)]
    private Collection $detailsArticles;

    #[ORM\ManyToOne(inversedBy: 'listesDeCourses')]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->detailsArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUtilisateurs(): ?Utilisateur
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?Utilisateur $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    /**
     * @return Collection<int, DetailsArticle>
     */
    public function getDetailsArticles(): Collection
    {
        return $this->detailsArticles;
    }

    public function addDetailsArticle(DetailsArticle $detailsArticle): self
    {
        if (!$this->detailsArticles->contains($detailsArticle)) {
            $this->detailsArticles->add($detailsArticle);
            $detailsArticle->setListeCourse($this);
        }

        return $this;
    }

    public function removeDetailsArticle(DetailsArticle $detailsArticle): self
    {
        if ($this->detailsArticles->removeElement($detailsArticle)) {
            // set the owning side to null (unless already changed)
            if ($detailsArticle->getListeCourse() === $this) {
                $detailsArticle->setListeCourse(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}

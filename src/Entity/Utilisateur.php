<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'utilisateurs', targetEntity: ListeCourse::class, orphanRemoval: true)]
    private Collection $listeCourses;

    public function __construct()
    {
        $this->listeCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, ListeCourse>
     */
    public function getListeCourses(): Collection
    {
        return $this->listeCourses;
    }

    public function addListeCourse(ListeCourse $listeCourse): self
    {
        if (!$this->listeCourses->contains($listeCourse)) {
            $this->listeCourses->add($listeCourse);
            $listeCourse->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeListeCourse(ListeCourse $listeCourse): self
    {
        if ($this->listeCourses->removeElement($listeCourse)) {
            // set the owning side to null (unless already changed)
            if ($listeCourse->getUtilisateurs() === $this) {
                $listeCourse->setUtilisateurs(null);
            }
        }

        return $this;
    }
}

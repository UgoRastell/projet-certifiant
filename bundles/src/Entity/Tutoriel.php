<?php

namespace App\Entity;

use App\Entity\Historique;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TutorielRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TutorielRepository::class)]
class Tutoriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier_PDF = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier_video = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'tutoriels')]
    #[ORM\JoinTable(name: 'tutoriel_categorie')]
    private ?Collection $categories = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'id_tutoriel', cascade: ['remove'])]
    private $historiques;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFichierPDF(): ?string
    {
        return $this->fichier_PDF;
    }

    public function setFichierPDF(?string $fichier_PDF): self
    {
        $this->fichier_PDF = $fichier_PDF;

        return $this;
    }

    public function getFichierVideo(): ?string
    {
        return $this->fichier_video;
    }

    public function setFichierVideo(?string $fichier_video): self
    {
        $this->fichier_video = $fichier_video;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */

     public function getCategoryNames(): string
    {
        $categoryNames = $this->categories->map(fn ($category) => $category->getNom())->toArray();
        return implode(', ', $categoryNames);
    }


    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if ($this->categories === null) {
            $this->categories = new ArrayCollection();
        }
    
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addTutoriel($this);
        }
    
        return $this;
    }
    
    public function removeCategory(Categorie $category): self
    {
        if ($this->categories !== null) {
            $this->categories->removeElement($category);
            $category->removeTutoriel($this);
        }
    
        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
}

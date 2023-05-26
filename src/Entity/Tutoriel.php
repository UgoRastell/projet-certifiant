<?php

namespace App\Entity;

use App\Repository\TutorielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    
}

<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tutoriel $id_tutoriel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_finish = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdTutoriel(): ?Tutoriel
    {
        return $this->id_tutoriel;
    }

    public function setIdTutoriel(?Tutoriel $id_tutoriel): self
    {
        $this->id_tutoriel = $id_tutoriel;

        return $this;
    }

    public function getDateFinish(): ?\DateTimeInterface
    {
        return $this->date_finish;
    }

    public function setDateFinish(\DateTimeInterface $date_finish): self
    {
        $this->date_finish = $date_finish;

        return $this;
    }
}

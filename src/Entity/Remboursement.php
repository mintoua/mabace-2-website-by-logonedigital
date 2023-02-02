<?php

namespace App\Entity;

use App\Repository\RemboursementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemboursementRepository::class)]
class Remboursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'remboursements')]
    private ?Emprunt $emprunt = null;

    #[ORM\Column(length: 15)]
    private ?string $date = null;

    #[ORM\Column]
    private ?float $interet = null;

    #[ORM\Column]
    private ?float $amortissement = null;

    #[ORM\Column]
    private ?float $hebdomadaire = null;

    #[ORM\Column]
    private ?bool $etat = null;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmprunt(): ?Emprunt
    {
        return $this->emprunt;
    }

    public function setEmprunt(?Emprunt $emprunt): self
    {
        $this->emprunt = $emprunt;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getInteret(): ?float
    {
        return $this->interet;
    }

    public function setInteret(float $interet): self
    {
        $this->interet = $interet;

        return $this;
    }

    public function getAmortissement(): ?float
    {
        return $this->amortissement;
    }

    public function setAmortissement(float $amortissement): self
    {
        $this->amortissement = $amortissement;

        return $this;
    }

    public function getHebdomadaire(): ?float
    {
        return $this->hebdomadaire;
    }

    public function setHebdomadaire(float $hebdomadaire): self
    {
        $this->hebdomadaire = $hebdomadaire;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}

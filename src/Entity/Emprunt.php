<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 50)]
    private ?string $createdAt = null;

    #[ORM\Column(length: 50)]
    private ?string $endedAt = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $tauxInteret = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $tauxInteretDelai = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Member $membre = null;

    #[ORM\Column]
    private ?bool $etat = null;

    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: Remboursement::class)]
    private Collection $remboursements;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?int $duree = null;

    public function __construct()
    {
        $this->remboursements = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEndedAt(): ?string
    {
        return $this->endedAt;
    }

    public function setEndedAt(string $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getTauxInteret(): ?float
    {
        return $this->tauxInteret;
    }

    public function setTauxInteret(float $tauxInteret): self
    {
        $this->tauxInteret = $tauxInteret;

        return $this;
    }

    public function getTauxInteretDelai(): ?float
    {
        return $this->tauxInteretDelai;
    }

    public function setTauxInteretDelai(float $tauxInteretDelai): self
    {
        $this->tauxInteretDelai = $tauxInteretDelai;

        return $this;
    }

    public function getMembre(): ?Member
    {
        return $this->membre;
    }

    public function setMembre(?Member $membre): self
    {
        $this->membre = $membre;

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

    public function getRemboursements(): Collection
    {
        return $this->remboursements;
    }

    public function addRemboursement(Remboursement $remboursement): self
    {
        if (!$this->remboursements->contains($remboursement)) {
            $this->remboursements->add($remboursement);
            $remboursement->setEmprunt($this);
        }

        return $this;
    }

    public function removeRemboursement(Remboursement $remboursement): self
    {
        if ($this->remboursements->removeElement($remboursement)) {
            // set the owning side to null (unless already changed)
            if ($remboursement->getEmprunt() === $this) {
                $remboursement->setEmprunt(null);
            }
        }

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

}

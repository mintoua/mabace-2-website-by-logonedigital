<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
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

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(\DateTime::class)]
    private ?\DateTime $endedAt = null;

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

    #[ORM\OneToOne(mappedBy: 'emprunt', cascade: ['persist', 'remove'])]
    private ?Remboursement $remboursement = null;

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTime
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTime $endedAt): self
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

    public function getRemboursement(): ?Remboursement
    {
        return $this->remboursement;
    }

    public function setRemboursement(?Remboursement $remboursement): self
    {
        // unset the owning side of the relation if necessary
        if ($remboursement === null && $this->remboursement !== null) {
            $this->remboursement->setEmprunt(null);
        }

        // set the owning side of the relation if necessary
        if ($remboursement !== null && $remboursement->getEmprunt() !== $this) {
            $remboursement->setEmprunt($this);
        }

        $this->remboursement = $remboursement;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CycleRepository::class)]
class Cycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $nomCycle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $dateDeb = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $dateFin = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

   

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\OneToMany(mappedBy: 'cycle', targetEntity: CalendrierBenef::class, orphanRemoval: true)]
    private Collection $calendrierBenefs;

    public function __construct()
    {
        $this->calendrierBenefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnomCycle(): ?string
    {
        return $this->nomCycle;
    }

    public function setnomCycle(string $nomCycle): self
    {
        $this->nomCycle = $nomCycle;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection<int, CalendrierBenef>
     */
    public function getCalendrierBenefs(): Collection
    {
        return $this->calendrierBenefs;
    }

    public function addCalendrierBenef(CalendrierBenef $calendrierBenef): self
    {
        if (!$this->calendrierBenefs->contains($calendrierBenef)) {
            $this->calendrierBenefs->add($calendrierBenef);
            $calendrierBenef->setCycle($this);
        }

        return $this;
    }

    public function removeCalendrierBenef(CalendrierBenef $calendrierBenef): self
    {
        if ($this->calendrierBenefs->removeElement($calendrierBenef)) {
            // set the owning side to null (unless already changed)
            if ($calendrierBenef->getCycle() === $this) {
                $calendrierBenef->setCycle(null);
            }
        }

        return $this;
    }
}

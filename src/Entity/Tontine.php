<?php

namespace App\Entity;

use App\Repository\TontineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TontineRepository::class)]
class Tontine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $typeTontine = null;

    #[ORM\Column(length: 100)]
    private ?int $montant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $obligatoire = null;



    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __toString()
    {
        return $this->getIntituleTontine();
    }

    #[ORM\Column(length: 100)]
    private ?string $intituleTontine = null;

    #[ORM\OneToMany(mappedBy: 'tontine', targetEntity: CalendrierBenef::class)]
    private Collection $calendrierBenefs;

    public function __construct()
    {
        $this->calendrierBenefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTontine(): ?string
    {
        return $this->typeTontine;
    }

    public function setTypeTontine(string $typeTontine): self
    {
        $this->typeTontine = $typeTontine;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function isObligatoire(): ?bool
    {
        return $this->obligatoire;
    }

    public function setObligatoire(?bool $obligatoire): self
    {
        $this->obligatoire = $obligatoire;

        return $this;
    }

    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIntituleTontine(): ?string
    {
        return $this->intituleTontine;
    }

    public function setIntituleTontine(string $intituleTontine): self
    {
        $this->intituleTontine = $intituleTontine;

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
            $calendrierBenef->setTontine($this);
        }

        return $this;
    }

    public function removeCalendrierBenef(CalendrierBenef $calendrierBenef): self
    {
        if ($this->calendrierBenefs->removeElement($calendrierBenef)) {
            // set the owning side to null (unless already changed)
            if ($calendrierBenef->getTontine() === $this) {
                $calendrierBenef->setTontine(null);
            }
        }

        return $this;
    }
}

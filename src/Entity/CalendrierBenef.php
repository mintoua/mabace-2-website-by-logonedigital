<?php

namespace App\Entity;

use App\Repository\CalendrierBenefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendrierBenefRepository::class)]
class CalendrierBenef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateBenef = null;

    #[ORM\OneToMany(mappedBy: 'calendrierBenef', targetEntity: Tontine::class)]
    private Collection $totine;

    #[ORM\ManyToOne(inversedBy: 'calendrierBenefs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $membre = null;

    #[ORM\ManyToOne(inversedBy: 'calendrierBenefs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tontine $tontine = null;

  

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBenef(): ?\DateTimeInterface
    {
        return $this->dateBenef;
    }

    public function setDateBenef(\DateTimeInterface $dateBenef): self
    {
        $this->dateBenef = $dateBenef;

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

    public function getTontine(): ?Tontine
    {
        return $this->tontine;
    }

    public function setTontine(?Tontine $tontine): self
    {
        $this->tontine = $tontine;

        return $this;
    }
}

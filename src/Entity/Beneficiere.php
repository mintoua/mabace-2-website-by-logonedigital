<?php

namespace App\Entity;

use App\Repository\BeneficiereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BeneficiereRepository::class)]
class Beneficiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\ManyToOne(inversedBy: 'beneficieres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CalendrierBenef $calendrierBenef = null;

    #[ORM\ManyToOne(inversedBy: 'benefs')]
    private ?Member $membres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalendrierBenef(): ?CalendrierBenef
    {
        return $this->calendrierBenef;
    }

    public function setCalendrierBenef(?CalendrierBenef $calendrierBenef): self
    {
        $this->calendrierBenef = $calendrierBenef;

        return $this;
    }

    public function getMembres(): ?Member
    {
        return $this->membres;
    }

    public function setMembres(?Member $membres): self
    {
        $this->membres = $membres;

        return $this;
    }
}

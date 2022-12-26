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
    private ?Member $membre = null;

    #[ORM\ManyToOne(inversedBy: 'beneficieres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CalendrierBenef $calendrierBenef = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCalendrierBenef(): ?CalendrierBenef
    {
        return $this->calendrierBenef;
    }

    public function setCalendrierBenef(?CalendrierBenef $calendrierBenef): self
    {
        $this->calendrierBenef = $calendrierBenef;

        return $this;
    }
}

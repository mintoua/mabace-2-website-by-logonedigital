<?php

namespace App\Entity;

use App\Repository\SanctionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SanctionRepository::class)]
class Sanction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[Assert\Length(
        min: 5,
        max: 1000,
    )]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\Range(
        min: 1,
        max: 24,
        notInRangeMessage: 'Vous devez être entre 1 à 24 semaines',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $raison = null;

    #[ORM\ManyToOne(inversedBy: 'sanctions')]
    private ?Member $membre = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 3,
        max: 32,
    )]
    #[Assert\NotBlank]
    private ?string $intitule = null;

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

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(string $raison): self
    {
        $this->raison = $raison;

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

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\AideRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AideRepository::class)]
class Aide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $typeAide;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $idMembre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAide(): string
    {
        return $this->typeAide;
    }

    public function setTypeAide(string $typeAide): self
    {
        $this->typeAide = $typeAide;

        return $this;
    }

    public function getIdMembre(): ?String
    {
        return $this->idMembre;
    }

    public function setIdMembre(?String $idMembre): self
    {
        $this->idMembre = $idMembre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}

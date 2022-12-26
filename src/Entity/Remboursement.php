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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $refundAt = null;

    #[ORM\OneToOne(inversedBy: 'remboursement', cascade: ['persist', 'remove'])]
    private ?Emprunt $emprunt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefundAt(): ?\DateTimeInterface
    {
        return $this->refundAt;
    }

    public function setRefundAt(\DateTimeInterface $refundAt): self
    {
        $this->refundAt = $refundAt;

        return $this;
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
}

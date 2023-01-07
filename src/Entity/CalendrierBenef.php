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

    #[ORM\OneToMany(mappedBy: 'calendrierBenef', targetEntity: Beneficiere::class)]
    private Collection $beneficieres;

    #[ORM\Column]
    private ?bool $etat = null;

    public function __construct()
    {
        $this->beneficieres = new ArrayCollection();
    }
    

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

    /**
     * @return Collection<int, Beneficiere>
     */
    public function getBeneficieres(): Collection
    {
        return $this->beneficieres;
    }

    public function addBeneficiere(Beneficiere $beneficiere): self
    {
        if (!$this->beneficieres->contains($beneficiere)) {
            $this->beneficieres->add($beneficiere);
            $beneficiere->setCalendrierBenef($this);
        }

        return $this;
    }

    public function removeBeneficiere(Beneficiere $beneficiere): self
    {
        if ($this->beneficieres->removeElement($beneficiere)) {
            // set the owning side to null (unless already changed)
            if ($beneficiere->getCalendrierBenef() === $this) {
                $beneficiere->setCalendrierBenef(null);
            }
        }

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
}

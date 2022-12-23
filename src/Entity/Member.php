<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column(length: 100)]
    private ?string $cni = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: CalendrierBenef::class)]
    private Collection $calendrierBenefs;

    public function __construct()
    {
        $this->calendrierBenefs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getLastname()." ".$this->getFirstname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
            $calendrierBenef->setMembre($this);
        }

        return $this;
    }

    public function removeCalendrierBenef(CalendrierBenef $calendrierBenef): self
    {
        if ($this->calendrierBenefs->removeElement($calendrierBenef)) {
            // set the owning side to null (unless already changed)
            if ($calendrierBenef->getMembre() === $this) {
                $calendrierBenef->setMembre(null);
            }
        }

        return $this;
    }
}

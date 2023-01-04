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

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Sanction::class)]
    private Collection $sanctions;

   
    // public function __toString () : string
    // {
    //    return $this->lastname.' '.$this->firstname;
    // }
    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: CalendrierBenef::class)]
    private Collection $calendrierBenefs;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Beneficiere::class)]
    private Collection $beneficieres;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->sanctions = new ArrayCollection();
        $this->calendrierBenefs = new ArrayCollection();
        $this->beneficieres = new ArrayCollection();
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
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setMembre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getMembre() === $this) {
                $emprunt->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sanction>
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions->add($sanction);
            $sanction->setMembre($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getMembre() === $this) {
                $sanction->setMembre(null);
            }
        }

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
            $beneficiere->setMembre($this);
        }

        return $this;
    }

    public function removeBeneficiere(Beneficiere $beneficiere): self
    {
        if ($this->beneficieres->removeElement($beneficiere)) {
            // set the owning side to null (unless already changed)
            if ($beneficiere->getMembre() === $this) {
                $beneficiere->setMembre(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['matricule'], message: 'Ce membre existe déjà')]
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

    

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToMany(mappedBy: 'membres', targetEntity: Beneficiere::class)]
    private Collection $benefs;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\ManyToMany(targetEntity: Aide::class, mappedBy: 'membres')]
    private Collection $aides;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->sanctions = new ArrayCollection();
        $this->calendrierBenefs = new ArrayCollection();
        $this->benefs = new ArrayCollection();
        $this->aides = new ArrayCollection();
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

 
   


    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Beneficiere>
     */
    public function getBenefs(): Collection
    {
        return $this->benefs;
    }

    public function addBenef(Beneficiere $benef): self
    {
        if (!$this->benefs->contains($benef)) {
            $this->benefs->add($benef);
            $benef->setMembres($this);
        }

        return $this;
    }

    public function removeBenef(Beneficiere $benef): self
    {
        if ($this->benefs->removeElement($benef)) {
            // set the owning side to null (unless already changed)
            if ($benef->getMembres() === $this) {
                $benef->setMembres(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Aide>
     */
    public function getAides(): Collection
    {
        return $this->aides;
    }

    public function addAide(Aide $aide): self
    {
        if (!$this->aides->contains($aide)) {
            $this->aides->add($aide);
            $aide->addMembre($this);
        }

        return $this;
    }

    public function removeAide(Aide $aide): self
    {
        if ($this->aides->removeElement($aide)) {
            $aide->removeMembre($this);
        }

        return $this;
    }
}

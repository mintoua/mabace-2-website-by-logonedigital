<?php

namespace App\Entity;

use App\Repository\CategorieAideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieAideRepository::class)]
class CategorieAide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $intitule = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;


    #[ORM\OneToMany(mappedBy: 'categorieAides', targetEntity: Aide::class, orphanRemoval: true)]
    private Collection $aide;

    public function __toString()
    {
        return $this->intitule;
    }

    public function __construct()
    {
        $this->aide = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Aide>
     */
    public function getAide(): Collection
    {
        return $this->aide;
    }

    public function addAide(Aide $aide): self
    {
        if (!$this->aide->contains($aide)) {
            $this->aide->add($aide);
            $aide->setCategorieAides($this);
        }

        return $this;
    }

    public function removeAide(Aide $aide): self
    {
        if ($this->aide->removeElement($aide)) {
            // set the owning side to null (unless already changed)
            if ($aide->getCategorieAides() === $this) {
                $aide->setCategorieAides(null);
            }
        }

        return $this;
    }
}

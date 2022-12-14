<?php

namespace App\Entity;

use App\Repository\AideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AideRepository::class)]
class Aide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'aide')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieAide $categorieAides = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Member::class, inversedBy: 'aides')]
    private Collection $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
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

    public function getCategorieAides(): ?CategorieAide
    {
        return $this->categorieAides;
    }

    public function setCategorieAides(?CategorieAide $categorieAides): self
    {
        $this->categorieAides = $categorieAides;

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
     * @return Collection<int, Member>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Member $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
        }

        return $this;
    }

    public function removeMembre(Member $membre): self
    {
        $this->membres->removeElement($membre);

        return $this;
    }
}

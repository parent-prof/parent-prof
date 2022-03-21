<?php

namespace App\Entity;

use App\Repository\ParentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParentsRepository::class)
 */
class Parents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"},fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Eleve::class, mappedBy="parents",fetch="EAGER")
     */
    private $eleves;

    /**
     * @ORM\OneToMany(targetEntity=Reserver::class, mappedBy="parent")
     */
    private $reservers;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->reservers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setParents($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getParents() === $this) {
                $elefe->setParents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reserver[]
     */
    public function getReservers(): Collection
    {
        return $this->reservers;
    }

    public function addReserver(Reserver $reserver): self
    {
        if (!$this->reservers->contains($reserver)) {
            $this->reservers[] = $reserver;
            $reserver->setParent($this);
        }

        return $this;
    }

    public function removeReserver(Reserver $reserver): self
    {
        if ($this->reservers->removeElement($reserver)) {
            // set the owning side to null (unless already changed)
            if ($reserver->getParent() === $this) {
                $reserver->setParent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}

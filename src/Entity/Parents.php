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
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="parents", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $connexion;

    /**
     * @ORM\OneToMany(targetEntity=Reserver::class, mappedBy="id_parent")
     */
    private $parent;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnexion(): ?Utilisateur
    {
        return $this->connexion;
    }

    public function setConnexion(Utilisateur $connexion): self
    {
        $this->connexion = $connexion;

        return $this;
    }

    /**
     * @return Collection|Reserver[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(Reserver $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setIdParent($this);
        }

        return $this;
    }

    public function removeParent(Reserver $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getIdParent() === $this) {
                $parent->setIdParent(null);
            }
        }

        return $this;
    }
}

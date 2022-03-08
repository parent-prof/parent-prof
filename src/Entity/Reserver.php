<?php

namespace App\Entity;

use App\Repository\ReserverRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReserverRepository::class)
 */
class Reserver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmation;

    /**
     * @ORM\ManyToOne(targetEntity=Creneau::class,fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creneau;

    /**
     * @ORM\ManyToOne(targetEntity=Parents::class, inversedBy="reservers",fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienReunion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfirmation(): ?bool
    {
        return $this->confirmation;
    }

    public function setConfirmation(bool $confirmation): self
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getLienReunion(): ?string
    {
        return $this->lienReunion;
    }

    public function setLienReunion(string $lienReunion): self
    {
        $this->lienReunion = $lienReunion;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ReserverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="time")
     */
    private $H_debut;

    /**
     * @ORM\Column(type="time")
     */
    private $H_fin;

    /**
     
     * @ORM\Column(type="boolean")
     */
    private $confirmation;

    /**
     * @ORM\ManyToOne(targetEntity=parents::class, inversedBy="parent")
     */
    private $id_parent;

    /**
     * @ORM\ManyToMany(targetEntity=Disponibilite::class, inversedBy="reservers")
     */
    private $heure_fin;

    /**
     * @ORM\ManyToMany(targetEntity=Disponibilite::class, inversedBy="reservers")
     */
    private $Date_dispo;

    /**
     * @ORM\ManyToMany(targetEntity=Disponibilite::class, inversedBy="reservers")
     */
    private $Heure_debut;

    public function __construct()
    {
        $this->heure_fin = new ArrayCollection();
        $this->Date_dispo = new ArrayCollection();
        $this->Heure_debut = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHDebut(): ?\DateTimeInterface
    {
        return $this->H_debut;
    }

    public function setHDebut(\DateTimeInterface $H_debut): self
    {
        $this->H_debut = $H_debut;

        return $this;
    }

    public function getHFin(): ?\DateTimeInterface
    {
        return $this->H_fin;
    }

    public function setHFin(\DateTimeInterface $H_fin): self
    {
        $this->H_fin = $H_fin;

        return $this;
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

    public function getIdParent(): ?parents
    {
        return $this->id_parent;
    }

    public function setIdParent(?parents $id_parent): self
    {
        $this->id_parent = $id_parent;

        return $this;
    }

    /**
     * @return Collection|Disponibilite[]
     */
    public function getHeureFin(): Collection
    {
        return $this->heure_fin;
    }

    public function addHeureFin(Disponibilite $heureFin): self
    {
        if (!$this->heure_fin->contains($heureFin)) {
            $this->heure_fin[] = $heureFin;
        }

        return $this;
    }

    public function removeHeureFin(Disponibilite $heureFin): self
    {
        $this->heure_fin->removeElement($heureFin);

        return $this;
    }

    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->date_dispo;
    }

    public function setDateDispo(\DateTimeInterface $date_dispo): self
    {
        $this->date_dispo = $date_dispo;

        return $this;
    }

    public function addDateDispo(Disponibilite $dateDispo): self
    {
        if (!$this->Date_dispo->contains($dateDispo)) {
            $this->Date_dispo[] = $dateDispo;
        }

        return $this;
    }

    public function removeDateDispo(Disponibilite $dateDispo): self
    {
        $this->Date_dispo->removeElement($dateDispo);

        return $this;
    }

    /**
     * @return Collection|Disponibilite[]
     */
    public function getHeureDebut(): Collection
    {
        return $this->Heure_debut;
    }

    public function addHeureDebut(Disponibilite $heureDebut): self
    {
        if (!$this->Heure_debut->contains($heureDebut)) {
            $this->Heure_debut[] = $heureDebut;
        }

        return $this;
    }

    public function removeHeureDebut(Disponibilite $heureDebut): self
    {
        $this->Heure_debut->removeElement($heureDebut);

        return $this;
    }
}

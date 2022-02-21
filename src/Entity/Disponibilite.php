<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisponibiliteRepository::class)
 */
class Disponibilite
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
    private $heure_fin;

    /**
     * @ORM\Column(type="date")
     */
    private $date_dispo;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_debut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_plage;

    /**
     * @ORM\OneToOne(targetEntity=Professeur::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_professeur;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="disponibilite")
     */
    private $id_Promotion;

    /**
     * @ORM\ManyToMany(targetEntity=Reserver::class, mappedBy="heure_fin")
     */
    private $reservers;

    public function __construct()
    {
        $this->id_Promotion = new ArrayCollection();
        $this->reservers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

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

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNbPlage(): ?int
    {
        return $this->nb_plage;
    }

    public function setNbPlage(int $nb_plage): self
    {
        $this->nb_plage = $nb_plage;

        return $this;
    }

    public function getIdProfesseur(): ?Professeur
    {
        return $this->id_professeur;
    }

    public function setIdProfesseur(Professeur $id_professeur): self
    {
        $this->id_professeur = $id_professeur;

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getIdPromotion(): Collection
    {
        return $this->id_Promotion;
    }

    public function addIdPromotion(Promotion $idPromotion): self
    {
        if (!$this->id_Promotion->contains($idPromotion)) {
            $this->id_Promotion[] = $idPromotion;
            $idPromotion->setDisponibilite($this);
        }

        return $this;
    }

    public function removeIdPromotion(Promotion $idPromotion): self
    {
        if ($this->id_Promotion->removeElement($idPromotion)) {
            // set the owning side to null (unless already changed)
            if ($idPromotion->getDisponibilite() === $this) {
                $idPromotion->setDisponibilite(null);
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
            $reserver->addHeureFin($this);
        }

        return $this;
    }

    public function removeReserver(Reserver $reserver): self
    {
        if ($this->reservers->removeElement($reserver)) {
            $reserver->removeHeureFin($this);
        }

        return $this;
    }
}

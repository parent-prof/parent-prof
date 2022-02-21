<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_Promotion;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_Promotion;

    /**
     * @ORM\ManyToOne(targetEntity=Professeur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_professeur;

    /**
     * @ORM\ManyToOne(targetEntity=Disponibilite::class, inversedBy="id_Promotion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $disponibilite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPromotion(): ?int
    {
        return $this->id_Promotion;
    }

    public function setIdPromotion(int $id_Promotion): self
    {
        $this->id_Promotion = $id_Promotion;

        return $this;
    }

    public function getNomPromotion(): ?string
    {
        return $this->nom_Promotion;
    }

    public function setNomPromotion(string $nom_Promotion): self
    {
        $this->nom_Promotion = $nom_Promotion;

        return $this;
    }

    public function getIdProfesseur(): ?Professeur
    {
        return $this->id_professeur;
    }

    public function setIdProfesseur(?Professeur $id_professeur): self
    {
        $this->id_professeur = $id_professeur;

        return $this;
    }

    public function getDisponibilite(): ?Disponibilite
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?Disponibilite $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }
}

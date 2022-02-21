<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfesseurRepository::class)
 */
class Professeur
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
    private $id_Professeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_connexion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProfesseur(): ?int
    {
        return $this->id_Professeur;
    }

    public function setIdProfesseur(int $id_Professeur): self
    {
        $this->id_Professeur = $id_Professeur;

        return $this;
    }

    public function getIdConnexion(): ?int
    {
        return $this->id_connexion;
    }

    public function setIdConnexion(int $id_connexion): self
    {
        $this->id_connexion = $id_connexion;

        return $this;
    }
}

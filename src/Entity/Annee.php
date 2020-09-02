<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnneeRepository")
 */
class Annee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreEtudiant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prefixe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNombreEtudiant(): ?int
    {
        return $this->nombreEtudiant;
    }

    public function setNombreEtudiant(?int $nombreEtudiant): self
    {
        $this->nombreEtudiant = $nombreEtudiant;

        return $this;
    }

    public function getPrefixe(): ?int
    {
        return $this->prefixe;
    }

    public function setPrefixe(?int $prefixe): self
    {
        $this->prefixe = $prefixe;

        return $this;
    }
}

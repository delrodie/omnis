<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $correspondant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveauEtude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dernierDiplome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $baccalaureat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileIdentite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileDiplome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Filiere", inversedBy="inscriptions")
     */
    private $filiere;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annee;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valid;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getCorrespondant(): ?string
    {
        return $this->correspondant;
    }

    public function setCorrespondant(?string $correspondant): self
    {
        $this->correspondant = $correspondant;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(?string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getDernierDiplome(): ?string
    {
        return $this->dernierDiplome;
    }

    public function setDernierDiplome(?string $dernierDiplome): self
    {
        $this->dernierDiplome = $dernierDiplome;

        return $this;
    }

    public function getBaccalaureat(): ?string
    {
        return $this->baccalaureat;
    }

    public function setBaccalaureat(?string $baccalaureat): self
    {
        $this->baccalaureat = $baccalaureat;

        return $this;
    }

    public function getFileIdentite(): ?string
    {
        return $this->fileIdentite;
    }

    public function setFileIdentite(?string $fileIdentite): self
    {
        $this->fileIdentite = $fileIdentite;

        return $this;
    }

    public function getFileDiplome(): ?string
    {
        return $this->fileDiplome;
    }

    public function setFileDiplome(?string $fileDiplome): self
    {
        $this->fileDiplome = $fileDiplome;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}

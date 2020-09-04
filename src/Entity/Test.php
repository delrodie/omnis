<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $lundi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mardi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mercredi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $jeudi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vendredi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $samedi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dimanche;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annee")
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompositionTest", mappedBy="test")
     */
    private $compositions;

    public function __construct()
    {
        $this->compositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(?int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getLundi(): ?bool
    {
        return $this->lundi;
    }

    public function setLundi(?bool $lundi): self
    {
        $this->lundi = $lundi;

        return $this;
    }

    public function getMardi(): ?bool
    {
        return $this->mardi;
    }

    public function setMardi(?bool $mardi): self
    {
        $this->mardi = $mardi;

        return $this;
    }

    public function getMercredi(): ?bool
    {
        return $this->mercredi;
    }

    public function setMercredi(?bool $mercredi): self
    {
        $this->mercredi = $mercredi;

        return $this;
    }

    public function getJeudi(): ?bool
    {
        return $this->jeudi;
    }

    public function setJeudi(?bool $jeudi): self
    {
        $this->jeudi = $jeudi;

        return $this;
    }

    public function getVendredi(): ?bool
    {
        return $this->vendredi;
    }

    public function setVendredi(?bool $vendredi): self
    {
        $this->vendredi = $vendredi;

        return $this;
    }

    public function getSamedi(): ?bool
    {
        return $this->samedi;
    }

    public function setSamedi(?bool $samedi): self
    {
        $this->samedi = $samedi;

        return $this;
    }

    public function getDimanche(): ?bool
    {
        return $this->dimanche;
    }

    public function setDimanche(?bool $dimanche): self
    {
        $this->dimanche = $dimanche;

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?string $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->dateFin;
    }

    public function setDateFin(?string $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|CompositionTest[]
     */
    public function getCompositions(): Collection
    {
        return $this->compositions;
    }

    public function addComposition(CompositionTest $composition): self
    {
        if (!$this->compositions->contains($composition)) {
            $this->compositions[] = $composition;
            $composition->setTest($this);
        }

        return $this;
    }

    public function removeComposition(CompositionTest $composition): self
    {
        if ($this->compositions->contains($composition)) {
            $this->compositions->removeElement($composition);
            // set the owning side to null (unless already changed)
            if ($composition->getTest() === $this) {
                $composition->setTest(null);
            }
        }

        return $this;
    }
}

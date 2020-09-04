<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompositionTestRepository")
 */
class CompositionTest
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
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resultat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscription")
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Test", inversedBy="compositions")
     */
    private $test;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(?string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getCandidat(): ?Inscription
    {
        return $this->candidat;
    }

    public function setCandidat(?Inscription $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }
}

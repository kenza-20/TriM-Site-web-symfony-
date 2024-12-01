<?php

namespace App\Entity;

use App\Repository\MaladieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: MaladieRepository::class)]
class maladie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $symptome = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: patient::class, mappedBy: 'idMaladie')]
    private Collection $idPatients;

    public function __construct()
    {
        $this->idPatients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSymptome(): ?string
    {
        return $this->symptome;
    }

    public function setSymptome(string $symptome): static
    {
        $this->symptome = $symptome;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, patient>
     */
    public function getIdPatients(): Collection
    {
        return $this->idPatients;
    }

    public function addIdPatient(patient $idPatient): static
    {
        if (!$this->idPatients->contains($idPatient)) {
            $this->idPatients->add($idPatient);
            $idPatient->addIdMaladie($this);
        }

        return $this;
    }

    public function removeIdPatient(patient $idPatient): static
    {
        if ($this->idPatients->removeElement($idPatient)) {
            $idPatient->removeIdMaladie($this);
        }

        return $this;
    }
}

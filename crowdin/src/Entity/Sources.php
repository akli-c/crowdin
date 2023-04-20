<?php

namespace App\Entity;

use App\Repository\SourcesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourcesRepository::class)]
class Sources
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'sources')]
    private ?Projects $idProject = null;

    #[ORM\Column(length: 255)]
    private ?string $langueOrigin = null;

    #[ORM\Column(length: 255)]
    private ?string $LangueTraduction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $traduction = null;

    public function __toString()
    {
    return $this->titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIdProject(): ?Projects
    {
        return $this->idProject;
    }

    public function setIdProject(?Projects $idProject): self
    {
        $this->idProject = $idProject;

        return $this;
    }

    public function getLangueOrigin(): ?string
    {
        return $this->langueOrigin;
    }

    public function setLangueOrigin(string $langueOrigin): self
    {
        $this->langueOrigin = $langueOrigin;

        return $this;
    }

    public function getLangueTraduction(): ?string
    {
        return $this->LangueTraduction;
    }

    public function setLangueTraduction(string $LangueTraduction): self
    {
        $this->LangueTraduction = $LangueTraduction;

        return $this;
    }

    public function getTraduction(): ?string
    {
        return $this->traduction;
    }

    public function setTraduction(?string $traduction): self
    {
        $this->traduction = $traduction;

        return $this;
    }
}

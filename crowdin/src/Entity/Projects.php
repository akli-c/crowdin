<?php

namespace App\Entity;

use App\Entity\Sources;
use App\Entity\Language;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?User $userId = null;

    #[ORM\ManyToMany(targetEntity: Language::class)]
    private Collection $langueOrigine;

    #[ORM\OneToMany(mappedBy: 'idProject', targetEntity: Sources::class)]
    private Collection $sources;


    public function __construct()
    {
        $this->sources = new ArrayCollection();
        $this->langueOrigine = new ArrayCollection();

    }

    public function __toString()
    {
    return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


    /**
     * @return Collection<int, language>
     */
    public function getLangueOrigine(): Collection
    {
        return $this->langueOrigine;
    }

    public function addLangueOrigine(language $langueOrigine): self
    {
        if (!$this->langueOrigine->contains($langueOrigine)) {
            $this->langueOrigine->add($langueOrigine);
        }

        return $this;
    }

    public function removeLanguage(language $langueOrigine): self
    {
        $this->langueOrigine->removeElement($langueOrigine);

        return $this;
    }


    /**
     * @return Collection<int, Sources>
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(Sources $source): self
    {
        if (!$this->sources->contains($source)) {
            $this->sources->add($source);
            $source->setIdProject($this);
        }

        return $this;
    }

    public function removeSource(Sources $source): self
    {
        if ($this->sources->removeElement($source)) {
            // set the owning side to null (unless already changed)
            if ($source->getIdProject() === $this) {
                $source->setIdProject(null);
            }
        }

        return $this;
    }
}

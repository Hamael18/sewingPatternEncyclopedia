<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SizeRepository")
 */
class Size
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
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="sizeMin")
     */
    private $versions_size_min;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="sizeMax")
     */
    private $versions_size_max;

    public function __construct()
    {
        $this->versions_size_min = new ArrayCollection();
        $this->versions_size_max = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->libelle;
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

    /**
     * @return Collection|Version[]
     */
    public function getVersionsSizeMin(): Collection
    {
        return $this->versions_size_min;
    }

    public function addVersionsSizeMin(Version $versionsSizeMin): self
    {
        if (!$this->versions_size_min->contains($versionsSizeMin)) {
            $this->versions_size_min[] = $versionsSizeMin;
            $versionsSizeMin->setSize�Min($this);
        }

        return $this;
    }

    public function removeVersionsSizeMin(Version $versionsSizeMin): self
    {
        if ($this->versions_size_min->contains($versionsSizeMin)) {
            $this->versions_size_min->removeElement($versionsSizeMin);
            // set the owning side to null (unless already changed)
            if ($versionsSizeMin->getSize�Min() === $this) {
                $versionsSizeMin->setSize�Min(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersionsSizeMax(): Collection
    {
        return $this->versions_size_max;
    }

    public function addVersionsSizeMax(Version $versionsSizeMax): self
    {
        if (!$this->versions_size_max->contains($versionsSizeMax)) {
            $this->versions_size_max[] = $versionsSizeMax;
            $versionsSizeMax->setSizeMax($this);
        }

        return $this;
    }

    public function removeVersionsSizeMax(Version $versionsSizeMax): self
    {
        if ($this->versions_size_max->contains($versionsSizeMax)) {
            $this->versions_size_max->removeElement($versionsSizeMax);
            // set the owning side to null (unless already changed)
            if ($versionsSizeMax->getSizeMax() === $this) {
                $versionsSizeMax->setSizeMax(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function canBeDeleted()
    {
        $canBeDeleted = ($this->getVersionsSizeMax()->count() + $this->getVersionsSizeMin()->count() == 0);
        return $canBeDeleted;
    }
}

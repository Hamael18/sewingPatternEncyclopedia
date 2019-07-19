<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VersionRepository")
 * @Vich\Uploadable()
 */
class Version
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pattern", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pattern;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Collar", inversedBy="versions")
     */
    private $collar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Length", inversedBy="versions")
     */
    private $length;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Handle", inversedBy="versions")
     */
    private $handle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fabric", inversedBy="versions")
     */
    private $fabric;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Style", inversedBy="versions")
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="version_image", fileNameProperty="image")
     * @var File
     * @Assert\File(
     *     maxSize="1M",
     *     maxSizeMessage="La taille du fichier doit être inférieure à 1Mo !",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage="Le fichier doit être un .png ou un .jpg/jpeg !"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Size", inversedBy="versions")
     */
    private $sizes;

    public function __construct()
    {
        $this->sizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPattern(): ?Pattern
    {
        return $this->pattern;
    }

    public function setPattern(?Pattern $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getCollar(): ?Collar
    {
        return $this->collar;
    }

    public function setCollar(?Collar $collar): self
    {
        $this->collar = $collar;

        return $this;
    }

    public function getLength(): ?Length
    {
        return $this->length;
    }

    public function setLength(?Length $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getHandle(): ?Handle
    {
        return $this->handle;
    }

    public function setHandle(?Handle $handle): self
    {
        $this->handle = $handle;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getFabric(): ?Fabric
    {
        return $this->fabric;
    }

    public function setFabric(?Fabric $fabric): self
    {
        $this->fabric = $fabric;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return bool
     */
    public function canBeDeleted()
    {
        $canBeDeleted = ($this->getPattern() != null);
        return $canBeDeleted;
    }

    /**
     * @return Collection|Size[]
     */
    public function getSizes(): Collection
    {
        return $this->sizes;
    }

    public function addSize(Size $size): self
    {
        if (!$this->sizes->contains($size)) {
            $this->sizes[] = $size;
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->sizes->contains($size)) {
            $this->sizes->removeElement($size);
        }

        return $this;
    }
}

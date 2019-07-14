<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Size", inversedBy="versions_size_min")
     */
    private $sizeMin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Size", inversedBy="versions_size_max")
     */
    private $sizeMax;

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

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSizeMin(): ?Size
    {
        return $this->sizeMin;
    }

    public function setSizeMin(?Size $sizeMin): self
    {
        $this->sizeMin = $sizeMin;

        return $this;
    }

    public function getSizeMax(): ?Size
    {
        return $this->sizeMax;
    }

    public function setSizeMax(?Size $sizeMax): self
    {
        $this->sizeMax = $sizeMax;

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
}

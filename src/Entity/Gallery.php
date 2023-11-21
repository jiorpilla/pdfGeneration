<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'gallery', targetEntity: Images::class, orphanRemoval: true)]
    private Collection $Images;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    public function __construct()
    {
        $this->Images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->Images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->Images->contains($image)) {
            $this->Images->add($image);
            $image->setGallery($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->Images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getGallery() === $this) {
                $image->setGallery(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}

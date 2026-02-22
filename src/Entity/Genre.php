<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $releaseDate = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $price = null;

    #[ORM\ManyToOne]
    private ?Editor $editor = null;

    #[ORM\ManyToMany(targetEntity: Genre::class)]
    private Collection $genres;

    // Vich fields
    #[Vich\UploadableField(mapping: 'games', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getReleaseDate(): ?\DateTimeImmutable { return $this->releaseDate; }
    public function setReleaseDate(?\DateTimeImmutable $releaseDate): static { $this->releaseDate = $releaseDate; return $this; }

    public function getPrice(): ?int { return $this->price; }
    public function setPrice(?int $price): static { $this->price = $price; return $this; }

    public function getEditor(): ?Editor { return $this->editor; }
    public function setEditor(?Editor $editor): static { $this->editor = $editor; return $this; }

    /** @return Collection<int, Genre> */
    public function getGenres(): Collection { return $this->genres; }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) $this->genres->add($genre);
        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);
        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) $this->updatedAt = new \DateTimeImmutable();
    }

    public function getImageFile(): ?File { return $this->imageFile; }

    public function setImageName(?string $imageName): void { $this->imageName = $imageName; }
    public function getImageName(): ?string { return $this->imageName; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function __toString(): string
{
    return (string) $this->name;
}
}
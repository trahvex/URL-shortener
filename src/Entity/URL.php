<?php

namespace App\Entity;

use App\Repository\URLRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: URLRepository::class)]
class URL
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $shortUrlCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customAlias = null;

    #[ORM\ManyToOne(inversedBy: 'shortenedURLs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'url', cascade: ['persist', 'remove'])]
    private ?Analytics $analytics = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): static
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortUrlCode(): ?string
    {
        return $this->shortUrlCode;
    }

    public function setShortUrlCode(string $shortUrlCode): static
    {
        $this->shortUrlCode = $shortUrlCode;

        return $this;
    }

    public function getCustomAlias(): ?string
    {
        return $this->customAlias;
    }

    public function setCustomAlias(?string $customAlias): static
    {
        $this->customAlias = $customAlias;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAnalytics(): ?Analytics
    {
        return $this->analytics;
    }

    public function setAnalytics(Analytics $analytics): static
    {
        // set the owning side of the relation if necessary
        if ($analytics->getUrl() !== $this) {
            $analytics->setUrl($this);
        }

        $this->analytics = $analytics;

        return $this;
    }
}

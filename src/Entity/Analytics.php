<?php

namespace App\Entity;

use App\Repository\AnalyticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyticsRepository::class)]
class Analytics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'analytics', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?URL $url = null;

    #[ORM\Column]
    private ?int $accessCount = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?URL
    {
        return $this->url;
    }

    public function setUrl(URL $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAccessCount(): ?int
    {
        return $this->accessCount;
    }

    public function setAccessCount(int $accessCount): static
    {
        $this->accessCount = $accessCount;

        return $this;
    }

    public function incrementAccessCount(): static
    {
        $this->accessCount++;
        return $this;
    }
}

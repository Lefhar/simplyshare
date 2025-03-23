<?php

namespace App\Entity;

use App\Repository\FacebookAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacebookAccountRepository::class)]
class FacebookAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $facebookId = null;

    #[ORM\Column(type: 'text')]
    private ?string $accessToken = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $pages = [];

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(string $facebookId): self
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getPages(): ?array
    {
        return $this->pages;
    }

    public function setPages(?array $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}

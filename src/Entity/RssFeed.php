<?php
// src/Entity/RssFeed.php
namespace App\Entity;

use App\Repository\RssFeedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RssFeedRepository::class)]
class RssFeed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $url = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rssFeeds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}

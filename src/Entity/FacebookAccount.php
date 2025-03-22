<?php
// src/Entity/FacebookAccount.php
namespace App\Entity;

use App\Repository\FacebookAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacebookAccountRepository::class)
 */
class FacebookAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="text")
     */
    private $accessToken;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $pages = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    // Getters et setters…
}

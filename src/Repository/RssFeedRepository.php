<?php
// src/Repository/RssFeedRepository.php
namespace App\Repository;

use App\Entity\RssFeed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RssFeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RssFeed::class);
    }

    // Ajoutez ici vos méthodes personnalisées
}
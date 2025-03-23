<?php

namespace App\Repository;

use App\Entity\FacebookAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacebookAccount>
 *
 * @method FacebookAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacebookAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacebookAccount[]    findAll()
 * @method FacebookAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacebookAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacebookAccount::class);
    }

    // Vous pouvez ajouter ici vos méthodes personnalisées
}

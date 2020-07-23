<?php

namespace App\Repository;

use App\Entity\RapperCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RapperCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapperCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapperCard[]    findAll()
 * @method RapperCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapperCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapperCard::class);
    }

    // /**
    //  * @return RapperCard[] Returns an array of RapperCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RapperCard
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

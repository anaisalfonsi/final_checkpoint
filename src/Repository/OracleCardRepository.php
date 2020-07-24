<?php

namespace App\Repository;

use App\Entity\OracleCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OracleCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method OracleCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method OracleCard[]    findAll()
 * @method OracleCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OracleCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OracleCard::class);
    }

    // /**
    //  * @return OracleCard[] Returns an array of OracleCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OracleCard
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

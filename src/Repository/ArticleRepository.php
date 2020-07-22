<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllRecent()
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('a')
            ->orderBy('a.published_at', 'DESC')
            ->getQuery();

        return $qb->execute();
    }

    public function findAllByAnimals()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.category = :identifier')
            ->orderBy('a.published_at', 'DESC')
            ->setParameter('identifier', 1)
            ->getQuery();

        return $qb->execute();
    }

    public function findAllByCosmos()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.category = :identifier')
            ->orderBy('a.published_at', 'DESC')
            ->setParameter('identifier', 2)
            ->getQuery();

        return $qb->execute();
    }

    public function findAllByMagic()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.category = :identifier')
            ->orderBy('a.published_at', 'DESC')
            ->setParameter('identifier', 3)
            ->getQuery();

        return $qb->execute();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

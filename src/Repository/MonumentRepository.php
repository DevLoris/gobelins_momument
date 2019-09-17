<?php

namespace App\Repository;

use App\Entity\Monument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Monument|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monument|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monument[]    findAll()
 * @method Monument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Monument::class);
    }

    public function findRandoms($limit)
    {
        return $this->createQueryBuilder('m')
            ->orderBy("RAND()")
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findLasts($limit)
    {
        return $this->createQueryBuilder('m')
            ->orderBy("m.id", "DESC")
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Monument[] Returns an array of Monument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Monument
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

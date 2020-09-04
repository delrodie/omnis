<?php

namespace App\Repository;

use App\Entity\CompositionTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompositionTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompositionTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompositionTest[]    findAll()
 * @method CompositionTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompositionTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompositionTest::class);
    }

    // /**
    //  * @return CompositionTest[] Returns an array of CompositionTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompositionTest
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

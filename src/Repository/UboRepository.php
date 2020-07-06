<?php

namespace App\Repository;

use App\Entity\Ubo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ubo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ubo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ubo[]    findAll()
 * @method Ubo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UboRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ubo::class);
    }

    // /**
    //  * @return Ubo[] Returns an array of Ubo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ubo
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

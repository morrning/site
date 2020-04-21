<?php

namespace App\Repository;

use App\Entity\NewsKyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsKyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsKyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsKyword[]    findAll()
 * @method NewsKyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsKywordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsKyword::class);
    }

    // /**
    //  * @return NewsKyword[] Returns an array of NewsKyword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsKyword
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

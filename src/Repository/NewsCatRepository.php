<?php

namespace App\Repository;

use App\Entity\NewsCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsCat[]    findAll()
 * @method NewsCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsCat::class);
    }

    // /**
    //  * @return NewsCat[] Returns an array of NewsCat objects
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
    public function findOneBySomeField($value): ?NewsCat
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

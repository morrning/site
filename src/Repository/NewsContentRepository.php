<?php

namespace App\Repository;

use App\Entity\NewsContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsContent[]    findAll()
 * @method NewsContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsContent::class);
    }

    // /**
    //  * @return NewsContent[] Returns an array of NewsContent objects
    //  */

    public function findtop($count)
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.viewCount', 'ASC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?NewsContent
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

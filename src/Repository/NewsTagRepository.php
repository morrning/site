<?php

namespace App\Repository;

use App\Entity\NewsTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsTag[]    findAll()
 * @method NewsTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsTag::class);
    }

    public function topTags()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.tagUseCount', 'ASC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?NewsTag
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

<?php

namespace App\Repository;

use App\Entity\ImageZoo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageZoo>
 *
 * @method ImageZoo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageZoo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageZoo[]    findAll()
 * @method ImageZoo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageZooRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageZoo::class);
    }

//    /**
//     * @return ImageZoo[] Returns an array of ImageZoo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageZoo
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

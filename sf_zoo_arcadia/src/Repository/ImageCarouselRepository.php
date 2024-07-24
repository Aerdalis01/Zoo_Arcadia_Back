<?php

namespace App\Repository;

use App\Entity\ImageCarousel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageCarousel>
 *
 * @method ImageCarousel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageCarousel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageCarousel[]    findAll()
 * @method ImageCarousel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageCarouselRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageCarousel::class);
    }

//    /**
//     * @return ImageCarousel[] Returns an array of ImageCarousel objects
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

//    public function findOneBySomeField($value): ?ImageCarousel
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

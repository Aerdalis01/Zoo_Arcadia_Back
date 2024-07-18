<?php

namespace App\Repository;

use App\Entity\ZooArcadia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ZooArcadia>
 *
 * @method ZooArcadia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZooArcadia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZooArcadia[]    findAll()
 * @method ZooArcadia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZooArcadiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZooArcadia::class);
    }

//    /**
//     * @return ZooArcadia[] Returns an array of ZooArcadia objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('z.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ZooArcadia
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

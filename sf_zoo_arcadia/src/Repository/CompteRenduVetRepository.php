<?php

namespace App\Repository;

use App\Entity\CompteRenduVet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteRenduVet>
 *
 * @method CompteRenduVet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteRenduVet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteRenduVet[]    findAll()
 * @method CompteRenduVet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRenduVetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteRenduVet::class);
    }

//    /**
//     * @return CompteRenduVet[] Returns an array of CompteRenduVet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompteRenduVet
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

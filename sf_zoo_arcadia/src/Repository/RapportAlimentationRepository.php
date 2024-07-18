<?php

namespace App\Repository;

use App\Entity\RapportAlimentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RapportAlimentation>
 *
 * @method RapportAlimentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportAlimentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportAlimentation[]    findAll()
 * @method RapportAlimentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportAlimentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportAlimentation::class);
    }

//    /**
//     * @return RapportAlimentation[] Returns an array of RapportAlimentation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RapportAlimentation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

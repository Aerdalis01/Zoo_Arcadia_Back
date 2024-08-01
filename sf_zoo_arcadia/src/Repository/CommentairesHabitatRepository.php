<?php

namespace App\Repository;

use App\Entity\CommentairesHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentairesHabitat>
 *
 * @method CommentairesHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentairesHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentairesHabitat[]    findAll()
 * @method CommentairesHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentairesHabitat::class);
    }

//    /**
//     * @return CommentairesHabitat[] Returns an array of CommentairesHabitat objects
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

//    public function findOneBySomeField($value): ?CommentairesHabitat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 *
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    /**
    * @param int $animalId
    * @return Consultation []
    */
        public function filtreParAnimal(int $animalId): array
        {
                return $this->createQueryBuilder('c')
                    ->andWhere('c.animal = :animalId')
                    ->setParameter('animalId', $animalId)
                    ->orderBy('c.date', 'DESC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult();
        }

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return Consultation[]
     */
        public function filtreParDate(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
        {
                return $this->createQueryBuilder('c')
                    ->andWhere('c.date BETWEEN :startDate AND :endDate')
                    ->setParameter('startDate', $startDate)
                    ->setParameter('endDate', $endDate)
                    ->orderBy('c.date', 'DESC')
                    ->getQuery()
                    ->getResult();
        }
        /**
     * @param int $animalId
     * @param \DateHeureInterface $startDate
     * @param \DateHeureInterface $endDate
     * @return Consultation[]
     */
    public function findByAnimalAndDateRange(int $animalId, \DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.animal = :animalId')
            ->andWhere('c.date BETWEEN :startDate AND :endDate')
            ->setParameter('animalId', $animalId)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
    
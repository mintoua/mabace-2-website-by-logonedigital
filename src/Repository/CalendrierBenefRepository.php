<?php

namespace App\Repository;

use App\Entity\CalendrierBenef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalendrierBenef>
 *
 * @method CalendrierBenef|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendrierBenef|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendrierBenef[]    findAll()
 * @method CalendrierBenef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendrierBenefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendrierBenef::class);
    }

    public function add(CalendrierBenef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CalendrierBenef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CalendrierBenef[] Returns an array of CalendrierBenef objects
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

//    public function findOneBySomeField($value): ?CalendrierBenef
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

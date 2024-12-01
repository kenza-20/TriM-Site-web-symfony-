<?php

namespace App\Repository;

use App\Entity\maladie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<maladie>
 *
 * @method maladie|null find($id, $lockMode = null, $lockVersion = null)
 * @method maladie|null findOneBy(array $criteria, array $orderBy = null)
 * @method maladie[]    findAll()
 * @method maladie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaladieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, maladie::class);
    }

//    /**
//     * @return maladie[] Returns an array of maladie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?maladie
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

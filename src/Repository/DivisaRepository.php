<?php

namespace App\Repository;

use App\Entity\Divisa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Divisa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Divisa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Divisa[]    findAll()
 * @method Divisa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DivisaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Divisa::class);
    }

    // /**
    //  * @return Divisa[] Returns an array of Divisa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Divisa
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

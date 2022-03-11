<?php

namespace App\Repository;

use App\Entity\ServerSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServerSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerSetting[]    findAll()
 * @method ServerSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServerSetting::class);
    }

    // /**
    //  * @return ServerSetting[] Returns an array of ServerSetting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServerSetting
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

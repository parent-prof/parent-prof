<?php

namespace App\Repository;

use App\Entity\Creneau;
use App\Entity\Parents;
use App\Entity\Reserver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reserver|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserver|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserver[]    findAll()
 * @method Reserver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReserverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserver::class);
    }

    /**
     * @param bool $status
     * @param Creneau $crenaux[]
     * @return Reserver[]
     */
    public function findMesReunions(bool $status, $crenaux)
    {
        /** @var Reserver $reunionsConfirme[] */
        $reunions = array();
        /** @var Creneau $crenau */


        foreach ($crenaux as $crenau){
            $reunion = $this->findOneBy(array('creneau'=>$crenau,'confirmation'=>$status));
            if (!is_null($reunion)){
                array_push($reunions, $reunion );

            }
        }
        return $reunions;
    }
    // /**
    //  * @return Reserver[] Returns an array of Reserver objects
    //  */

    public function findByIdParent(Parents $parent)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.parent = :val')
            ->setParameter('val', $parent)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField(Parents $parent): ?Reserver
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.parent_id = :val')
            ->setParameter('val', $parent->getid())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}

<?php

namespace App\Repository;

use App\Entity\Creneau;
use App\Entity\Disponibilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Creneau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creneau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creneau[]    findAll()
 * @method Creneau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneau::class);
    }

    /**
     * @param Disponibilite $disponibilites[]
     * @return Creneau|Creneau[]
     */
    public function findCrenauxByDisp($disponibilites)
    {
        /** @var Creneau $crenaux[] */
        $crenaux = array();

        /** @var Disponibilite $disponibilite */

        foreach ($disponibilites as $disponibilite){
            /** @var Creneau $creneau */

            foreach ($disponibilite->getCreneaux() as $creneau){
                if ($creneau->getOccupe() == true){
                    array_push($crenaux,$creneau);
                }
            }
        }

        return $crenaux;

    }

    /**
     * @param $status
     * @param Disponibilite $disponibilite[]
     * @return int|mixed|string
     */
    public function findCrenauxOccuped($status)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.occupe = :status')
            ->setParameter('status', $status)
            ->andWhere('c.disponibilite = :dispo')
            ->setParameter('dispo', $disponibilite[0])
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Creneau[] Returns an array of Creneau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Creneau
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

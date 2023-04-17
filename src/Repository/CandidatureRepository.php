<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 *
 * @method Candidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidature[]    findAll()
 * @method Candidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureRepository extends ServiceEntityRepository
{

    public function  getCandidatureForAnnonce(){
     //  $result=$this->createQueryBuilder("c")->where('c.annonceAssocier.idAnnonce= 1 ') ->getQuery()->getResult();
        $result =$this->createQueryBuilder('c')
            ->join('c.utilisateurAssocier', 'u')
            ->join('c.annonceAssocier', 'a')
             ->join('u.listePostulationInUser', 'p')
            ->addSelect('p')
            ->addSelect('a')
            ->addSelect('u')
            ->where('p.etat = :etat')

            ->andWhere('a.idAnnonce = :idAnnonce')
            ->setParameter('etat', 'passer quiz')
            ->setParameter('idAnnonce', 1)
            ->getQuery()
            ->getResult();

        return $result;
    }
    public function  getCandidatureForAnnonceSearch($data){
     //  $result=$this->createQueryBuilder("c")->where('c.annonceAssocier.idAnnonce= 1 ') ->getQuery()->getResult();
        $result =$this->createQueryBuilder('c')
            ->join('c.utilisateurAssocier', 'u')
            ->join('c.annonceAssocier', 'a')
             ->join('u.listePostulationInUser', 'p')
            ->addSelect('p')
            ->addSelect('a')
            ->addSelect('u')
            ->where('p.etat = :etat')

            ->andWhere('a.idAnnonce = :idAnnonce')
            ->andWhere('c.username LIKE :data')
            ->setParameter('data', '%' . $data . '%')
            ->setParameter('etat', 'passer quiz')
            ->setParameter('idAnnonce', 1)
            ->getQuery()
            ->getResult();

        return $result;
    }
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    public function save(Candidature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidature $entity, bool $flush = false): void
    {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Candidature[] Returns an array of Candidature objects
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

//    public function findOneBySomeField($value): ?Candidature
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

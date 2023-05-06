<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 *
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function save(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUtilisateur(User $utilisateur): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.listePostulationInAnnonce', 'p')

            ->andWhere('p.userPostulation = :utilisateur')
            ->setParameter('utilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }
    public function findAnnonceByCategorie($nomcategorie)
    {
        return $this->createQueryBuilder('a')
            ->join('a.categorieAnnonce', 'c')
            ->andWhere('c.nomCategorie = :nomcategorie')
            ->setParameter('nomcategorie', $nomcategorie)
            ->getQuery()
            ->getResult();
    }
    public function findAnnonceByPOstForUserTriee($id)
    {
        return $this->createQueryBuilder('a')
            ->leftjoin('a.listePostulationInAnnonce', 'p')
            ->leftjoin('p.userPostulation', 'u2')
            ->  Where('u2.id != :id')
            ->orWhere("p is null")
            ->setParameter("id",$id)
            ->orderBy('a.titre', "ASC")

            ->getQuery()
            ->getResult();
    }   public function findAnnonceByPOstForUser($id)
{
    echo "fdsdss ".$id;
    return $this->createQueryBuilder('a')
        ->leftjoin('a.listePostulationInAnnonce', 'p')
        ->leftjoin('p.userPostulation', 'u2')
       ->  Where('u2.id != :id')
        ->orWhere("p is null")
        ->setParameter("id",$id)

        ->getQuery()
        ->getResult();
}

    /*public function findByTitre(string $order = 'ASC')
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.titre', $order);

        return $qb->getQuery()->getResult();
    }*/

    public function findByTitreAlphabetically($user)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.utilisateur', 'u')

            ->where('u.id = :idUse')
            ->setParameter('idUse', $user->getId())

            ->orderBy('a.titre', "ASC");
            //->addOrderBy('a.titre', 'ASC');

        return $qb->getQuery()->getResult();
    }


    /*  public function findFavoritesByUser($userId)
      {
          $entityManager = $this->getEntityManager();

          $query = $entityManager->createQuery(
              'SELECT a
              FROM App\Entity\Annonce a
              INNER JOIN a.favoriteUtilisateurs u
              WHERE u.id = :userId'
          )->setParameter('userId', $userId);

          return $query->getResult();
      }*/
//    /**
//     * @return Annonce[] Returns an array of Annonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonce
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\NoteEpreuve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Etudiant;
use App\Entity\Ue;

/**
 * @extends ServiceEntityRepository<NoteEpreuve>
 */
class NoteEpreuveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteEpreuve::class);
    }

    /**
    * Retourne les notes d'épreuves d'un étudiant pour une UE donnée.
    *
    * @return NoteEpreuve[]
    */
    public function findByEtudiantAndUe(Etudiant $etudiant, Ue $ue): array
    {
        return $this->createQueryBuilder('ne')
            ->join('ne.epreuve', 'e')
            ->andWhere('ne.etudiant = :etudiant')
            ->andWhere('e.ue = :ue')
            ->setParameter('etudiant', $etudiant)
            ->setParameter('ue', $ue)
            ->orderBy('e.numero', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return NoteEpreuve[] Returns an array of NoteEpreuve objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NoteEpreuve
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

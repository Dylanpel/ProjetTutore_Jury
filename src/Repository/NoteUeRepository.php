<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\Groupe;
use App\Entity\NoteUe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NoteUe>
 */
class NoteUeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteUe::class);
    }

    /**
     * @return NoteUe[]
     */
    public function findByEtudiantAndGroupe(Etudiant $etudiant, Groupe $groupe): array
    {
        return $this->createQueryBuilder('nu')
            ->join('nu.ue', 'u')
            ->join('u.groupeUes', 'gu')
            ->andWhere('gu.groupe = :groupe')
            ->andWhere('nu.etudiant = :etudiant')
            ->setParameter('etudiant', $etudiant)
            ->setParameter('groupe', $groupe)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return NoteUe[] Returns an array of NoteUe objects
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

//    public function findOneBySomeField($value): ?NoteUe
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

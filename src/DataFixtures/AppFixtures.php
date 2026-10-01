<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\AnneeUser;
use App\Entity\Calcul;
use App\Entity\Config;
use App\Entity\Diplome;
use App\Entity\Division;
use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\Groupe;
use App\Entity\GroupeUe;
use App\Entity\Mention;
use App\Entity\Nature;
use App\Entity\NoteAnnee;
use App\Entity\NoteDivision;
use App\Entity\NoteEpreuve;
use App\Entity\NoteGroupe;
use App\Entity\NoteUe;
use App\Entity\Parcour;
use App\Entity\Ue;
use App\Entity\User;
use App\Enum\StatutAbsence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Jeu de donnees minimal mais coherent pour le projet Jury.
 *
 * Reproduit l'exemple du semestre 1 de L1 info decrit dans la spec :
 * un groupe racine "S1" obligatoire, avec 3 UEs obligatoires directes
 * et un sous-groupe "Ouverture" en choix parmi.
 *
 * IMPORTANT : adapte les noms de proprietes/methodes ci-dessous si ton
 * entite User ou une autre entite a ete generee avec des champs differents
 * (par exemple "email" au lieu de "login").
 */
class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // ---------------------------------------------------------------
        // Config (une seule ligne)
        // ---------------------------------------------------------------
        $config = new Config();
        $config->setAnnee('2024-2025');
        $config->setResponsable('Jean Dupont');
        $config->setWebmaster('Marie Curie');
        $config->setIsActif(true);
        $config->setRemarque('');
        $manager->persist($config);

        // ---------------------------------------------------------------
        // Utilisateurs
        // ---------------------------------------------------------------
        $admin = new User();
        $admin->setLogin('admin');
        $admin->setEmail('admin@exemple.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setRemarque('');
        $manager->persist($admin);

        $manager1 = new User();
        $manager1->setLogin('prof.martin');
        $manager1->setEmail('martin@exemple.fr');
        $manager1->setRoles(['ROLE_MANAGER']);
        $manager1->setPassword($this->passwordHasher->hashPassword($manager1, 'password'));
        $manager1->setRemarque('');
        $manager->persist($manager1);

        // ---------------------------------------------------------------
        // Structure pedagogique : Diplome > Mention > Parcour > Annee
        // ---------------------------------------------------------------
        $diplome = new Diplome();
        $diplome->setNom('Licence');
        $diplome->setNomCourt('L');
        $diplome->setRang(10);
        $diplome->setRemarque('');
        $manager->persist($diplome);

        $mention = new Mention();
        $mention->setNom('Informatique');
        $mention->setNomCourt('Info');
        $mention->setRang(10);
        $mention->setDiplome($diplome);
        $mention->setRemarque('');
        $manager->persist($mention);

        $parcour = new Parcour();
        $parcour->setNom('Informatique generale');
        $parcour->setNomCourt('Info Gen');
        $parcour->setRang(10);
        $parcour->setMention($mention);
        $parcour->setRemarque('');
        $manager->persist($parcour);

        $annee = new Annee();
        $annee->setAn(1);
        $annee->setNom('L1 Informatique');
        $annee->setNomCourt('L1');
        $annee->setIsCompensable(true);
        $annee->setMoyenneValidation(10.0);
        $annee->setParcour($parcour);
        $annee->setRemarque('');
        $manager->persist($annee);

        // ---------------------------------------------------------------
        // Calcul et natures d'epreuves
        // ---------------------------------------------------------------
        $calcul = new Calcul();
        $calcul->setFormule('moyenne_ponderee');
        $calcul->setRemarque('');
        $manager->persist($calcul);

        $natureEcrit = new Nature();
        $natureEcrit->setNom('Ecrit');
        $manager->persist($natureEcrit);

        $natureOral = new Nature();
        $natureOral->setNom('Oral');
        $manager->persist($natureOral);

        // ---------------------------------------------------------------
        // UEs
        // ---------------------------------------------------------------
        $ueAlgo = new Ue();
        $ueAlgo->setNom('Algorithmique');
        $ueAlgo->setNomCourt('Algo');
        $ueAlgo->setEcts(6.0);
        $ueAlgo->setMoyenneValidation(10.0);
        $ueAlgo->setCalcul($calcul);
        $ueAlgo->setRemarque('');
        $manager->persist($ueAlgo);

        $ueAlgebre = new Ue();
        $ueAlgebre->setNom('Algebre');
        $ueAlgebre->setNomCourt('Algebre');
        $ueAlgebre->setEcts(6.0);
        $ueAlgebre->setMoyenneValidation(10.0);
        $ueAlgebre->setCalcul($calcul);
        $ueAlgebre->setRemarque('');
        $manager->persist($ueAlgebre);

        $ueAnglais = new Ue();
        $ueAnglais->setNom('Anglais');
        $ueAnglais->setNomCourt('Anglais');
        $ueAnglais->setEcts(3.0);
        $ueAnglais->setMoyenneValidation(10.0);
        $ueAnglais->setCalcul($calcul);
        $ueAnglais->setRemarque('');
        $manager->persist($ueAnglais);

        $ueTennis = new Ue();
        $ueTennis->setNom('Tennis');
        $ueTennis->setNomCourt('Tennis');
        $ueTennis->setEcts(3.0);
        $ueTennis->setMoyenneValidation(10.0);
        $ueTennis->setCalcul($calcul);
        $ueTennis->setRemarque('');
        $manager->persist($ueTennis);

        $ueDroit = new Ue();
        $ueDroit->setNom('Droit des entreprises');
        $ueDroit->setNomCourt('Droit');
        $ueDroit->setEcts(3.0);
        $ueDroit->setMoyenneValidation(10.0);
        $ueDroit->setCalcul($calcul);
        $ueDroit->setRemarque('');
        $manager->persist($ueDroit);

        // ---------------------------------------------------------------
        // Epreuves (uniquement pour Algo et Anglais, pour rester minimal)
        // ---------------------------------------------------------------
        $epreuveAlgoCC = new Epreuve();
        $epreuveAlgoCC->setNumero(1);
        $epreuveAlgoCC->setNom('Controle continu');
        $epreuveAlgoCC->setCoefficient(1.0);
        $epreuveAlgoCC->setUe($ueAlgo);
        $epreuveAlgoCC->setNature($natureEcrit);
        $epreuveAlgoCC->setRemarque('');
        $manager->persist($epreuveAlgoCC);

        $epreuveAlgoExamen = new Epreuve();
        $epreuveAlgoExamen->setNumero(2);
        $epreuveAlgoExamen->setNom('Examen final');
        $epreuveAlgoExamen->setCoefficient(2.0);
        $epreuveAlgoExamen->setUe($ueAlgo);
        $epreuveAlgoExamen->setNature($natureEcrit);
        $epreuveAlgoExamen->setRemarque('');
        $manager->persist($epreuveAlgoExamen);

        $epreuveAnglaisOral = new Epreuve();
        $epreuveAnglaisOral->setNumero(1);
        $epreuveAnglaisOral->setNom('Oral');
        $epreuveAnglaisOral->setCoefficient(1.0);
        $epreuveAnglaisOral->setUe($ueAnglais);
        $epreuveAnglaisOral->setNature($natureOral);
        $epreuveAnglaisOral->setRemarque('');
        $manager->persist($epreuveAnglaisOral);

        // ---------------------------------------------------------------
        // Groupes : S1 (obligatoire) contient Algo, Algebre, Anglais
        // + un sous-groupe "Ouverture" (choix parmi, 3 ECTS)
        // ---------------------------------------------------------------
        $groupeS1 = new Groupe();
        $groupeS1->setType('obligatoire');
        $groupeS1->setNom('S1');
        $groupeS1->setRemarque('');
        $manager->persist($groupeS1);

        $groupeOuverture = new Groupe();
        $groupeOuverture->setType('choix parmi');
        $groupeOuverture->setEcts(3.0);
        $groupeOuverture->setNom('Ouverture');
        $groupeOuverture->setParent($groupeS1);
        $groupeOuverture->setRemarque('');
        $manager->persist($groupeOuverture);

        foreach ([$ueAlgo, $ueAlgebre, $ueAnglais] as $ue) {
            $groupeUe = new GroupeUe();
            $groupeUe->setGroupe($groupeS1);
            $groupeUe->setUe($ue);
            $groupeUe->setRemarque('');
            $manager->persist($groupeUe);
        }

        foreach ([$ueTennis, $ueDroit] as $ue) {
            $groupeUe = new GroupeUe();
            $groupeUe->setGroupe($groupeOuverture);
            $groupeUe->setUe($ue);
            $groupeUe->setRemarque('');
            $manager->persist($groupeUe);
        }

        // ---------------------------------------------------------------
        // Division S1, rattachee a l'annee et au groupe racine
        // ---------------------------------------------------------------
        $divisionS1 = new Division();
        $divisionS1->setNum(1);
        $divisionS1->setNom('S1');
        $divisionS1->setMoyenneValidation(10.0);
        $divisionS1->setAnnee($annee);
        $divisionS1->setGroupe($groupeS1);
        $divisionS1->setRemarque('');
        $manager->persist($divisionS1);

        // ---------------------------------------------------------------
        // Droit d'acces : le manager a les droits d'ecriture sur L1
        // ---------------------------------------------------------------
        $anneeUser = new AnneeUser();
        $anneeUser->setUtilisateur($manager1);
        $anneeUser->setAnnee($annee);
        $anneeUser->setDroit('ROLE_WRITER');
        $anneeUser->setRemarque('');
        $manager->persist($anneeUser);

        // ---------------------------------------------------------------
        // Etudiants
        // ---------------------------------------------------------------
        $alice = new Etudiant();
        $alice->setNumero('E00123456');
        $alice->setNom('Dupont');
        $alice->setPrenom('Alice');
        $alice->setRemarque('');
        $manager->persist($alice);

        $bob = new Etudiant();
        $bob->setNumero('E00654321');
        $bob->setNom('Martin');
        $bob->setPrenom('Bob');
        $bob->setRemarque('');
        $manager->persist($bob);

        // ---------------------------------------------------------------
        // Inscription pedagogique d'Alice : tout va bien, notes correctes
        // ---------------------------------------------------------------
        $this->inscrire($manager, $alice, $annee, $divisionS1, $groupeS1, [$ueAlgo, $ueAlgebre, $ueAnglais]);

        $noteEpreuveAliceCC = new NoteEpreuve();
        $noteEpreuveAliceCC->setEtudiant($alice);
        $noteEpreuveAliceCC->setEpreuve($epreuveAlgoCC);
        $noteEpreuveAliceCC->setNote(14.0);
        $noteEpreuveAliceCC->setNeutraliseNoteMini(false);
        $noteEpreuveAliceCC->setIsDispense(false);
        $noteEpreuveAliceCC->setRemarque('');
        $manager->persist($noteEpreuveAliceCC);

        $noteEpreuveAliceExamen = new NoteEpreuve();
        $noteEpreuveAliceExamen->setEtudiant($alice);
        $noteEpreuveAliceExamen->setEpreuve($epreuveAlgoExamen);
        $noteEpreuveAliceExamen->setNote(12.0);
        $noteEpreuveAliceExamen->setNeutraliseNoteMini(false);
        $noteEpreuveAliceExamen->setIsDispense(false);
        $noteEpreuveAliceExamen->setRemarque('');
        $manager->persist($noteEpreuveAliceExamen);

        $noteEpreuveAliceOral = new NoteEpreuve();
        $noteEpreuveAliceOral->setEtudiant($alice);
        $noteEpreuveAliceOral->setEpreuve($epreuveAnglaisOral);
        $noteEpreuveAliceOral->setNote(16.0);
        $noteEpreuveAliceOral->setNeutraliseNoteMini(false);
        $noteEpreuveAliceOral->setIsDispense(false);
        $noteEpreuveAliceOral->setRemarque('');
        $manager->persist($noteEpreuveAliceOral);

        // ---------------------------------------------------------------
        // Inscription pedagogique de Bob : un exemple d'absence injustifiee
        // ---------------------------------------------------------------
        $this->inscrire($manager, $bob, $annee, $divisionS1, $groupeS1, [$ueAlgo, $ueAlgebre, $ueAnglais]);

        $noteEpreuveBobCC = new NoteEpreuve();
        $noteEpreuveBobCC->setEtudiant($bob);
        $noteEpreuveBobCC->setEpreuve($epreuveAlgoCC);
        $noteEpreuveBobCC->setNote(9.0);
        $noteEpreuveBobCC->setNeutraliseNoteMini(false);
        $noteEpreuveBobCC->setIsDispense(false);
        $noteEpreuveBobCC->setRemarque('');
        $manager->persist($noteEpreuveBobCC);

        $noteEpreuveBobExamen = new NoteEpreuve();
        $noteEpreuveBobExamen->setEtudiant($bob);
        $noteEpreuveBobExamen->setEpreuve($epreuveAlgoExamen);
        $noteEpreuveBobExamen->setAbsence(StatutAbsence::INJUSTIFIEE);
        $noteEpreuveBobExamen->setNeutraliseNoteMini(false);
        $noteEpreuveBobExamen->setIsDispense(false);
        $noteEpreuveBobExamen->setRemarque('');
        // note laissee a null : incompatible avec une absence
        $manager->persist($noteEpreuveBobExamen);

        $noteEpreuveBobOral = new NoteEpreuve();
        $noteEpreuveBobOral->setEtudiant($bob);
        $noteEpreuveBobOral->setEpreuve($epreuveAnglaisOral);
        $noteEpreuveBobOral->setNote(11.0);
        $noteEpreuveBobOral->setNeutraliseNoteMini(false);
        $noteEpreuveBobOral->setIsDispense(false);
        $noteEpreuveBobOral->setRemarque('');
        $manager->persist($noteEpreuveBobOral);

        $manager->flush();
    }

    /**
     * Cree les lignes de notes vides (annee, division, groupe, UEs) pour un
     * etudiant qui s'inscrit a une annee : c'est l'inscription pedagogique.
     *
     * @param array<int, Ue> $ues
     */
    private function inscrire(
        ObjectManager $manager,
        Etudiant $etudiant,
        Annee $annee,
        Division $division,
        Groupe $groupe,
        array $ues,
    ): void {
        $noteAnnee = new NoteAnnee();
        $noteAnnee->setEtudiant($etudiant);
        $noteAnnee->setAnnee($annee);
        $noteAnnee->setNeutralisNoteMini(false);
        $noteAnnee->setRemarque('');
        $manager->persist($noteAnnee);

        $noteDivision = new NoteDivision();
        $noteDivision->setEtudiant($etudiant);
        $noteDivision->setDivision($division);
        $noteDivision->setNeutraliseNoteMini(false);
        $noteDivision->setIsDispense(false);
        $noteDivision->setRemarque('');
        $manager->persist($noteDivision);

        $noteGroupe = new NoteGroupe();
        $noteGroupe->setEtudiant($etudiant);
        $noteGroupe->setGroupe($groupe);
        $noteGroupe->setNeutralisNoteMini(false);
        $noteGroupe->setIsDispense(false);
        $noteGroupe->setRemarque('');
        $manager->persist($noteGroupe);

        foreach ($ues as $ue) {
            $noteUe = new NoteUe();
            $noteUe->setEtudiant($etudiant);
            $noteUe->setUe($ue);
            $noteUe->setNeutralisNoteMini(false);
            $noteUe->setIsDispense(false);
            $noteUe->setRemarque('');
            $manager->persist($noteUe);
        }
    }
}
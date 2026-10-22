<?php

namespace App\Tests\Calcul;

use App\Calcul\CalculateurGroupe;
use App\Calcul\CalculateurUe;
use App\Calcul\ResultatDto;
use App\Entity\Etudiant;
use App\Entity\Groupe;
use App\Entity\GroupeUe;
use App\Entity\NoteGroupe;
use App\Entity\NoteUe;
use App\Entity\Ue;
use App\Repository\NoteGroupeRepository;
use App\Repository\NoteUeRepository;
use PHPUnit\Framework\TestCase;

class CalculateurGroupeTest extends TestCase
{
    private Etudiant $etudiant;

    /** @var array<int, NoteUe[]> NoteUe suivies par l'étudiant, rangées par groupe */
    private array $notesUesParGroupe = [];

    /** @var array<int, NoteGroupe[]> NoteGroupe suivies par l'étudiant, rangées par groupe parent */
    private array $notesGroupesParParent = [];

    /** @var array<int, ResultatDto> résultat que doit renvoyer le CalculateurUe, par NoteUe */
    private array $resultatsUe = [];

    protected function setUp(): void
    {
        $this->etudiant = new Etudiant();
    }

    public function testMoyennePondereeParLesEcts(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        $this->ajouterUe($groupe, ects:3, moyenne:16);

        $noteGroupe = $this->creerNoteGroupe($groupe);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        // (10x6 + 16x3) / (6+3) = 108/9 = 12
        $this->assertSame(12.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testNoteSaisiePrimeSurLeCalcul(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        $this->ajouterUe($groupe, ects:3, moyenne:16);

        $noteGroupe = $this->creerNoteGroupe($groupe)->setNote(15);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        // Le calcul donnerait 12, mais la note saisie à la main prime
        $this->assertSame(15.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testUeDispenseeExclueMaisGroupeComplet(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        $this->ajouterUe($groupe, ects:3, moyenne:16, dispense:true);

        $noteGroupe = $this->creerNoteGroupe($groupe);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        // L'UE dispensée sort de la moyenne : (10x6) / 6 = 10
        // mais ses ECTS comptent dans le contrôle, donc le groupe reste complet
        $this->assertSame(10.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testUeIncompleteRendLeGroupeIncomplet(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        $this->ajouterUe($groupe, ects:3, moyenne:null, complet:false);

        $noteGroupe = $this->creerNoteGroupe($groupe);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        $this->assertNull($resultat->moyenne);
        $this->assertFalse($resultat->estComplet);
    }

    public function testSousGroupeChoixParmiCompteAvecSesEcts(): void
    {
        //ARRANGE
        $s1 = $this->creerGroupe('S1');
        $this->ajouterUe($s1, ects:6, moyenne:10);

        // LV vaut 3 ECTS alors qu'il propose 6 ECTS d'options
        $lv = $this->creerGroupe('LV', ects:3, parent:$s1);
        $this->ajouterUe($lv, ects:3, moyenne:16);
        $this->ajouterUeNonSuivie($lv, ects:3);

        $this->creerNoteGroupe($lv);
        $noteS1 = $this->creerNoteGroupe($s1);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteS1);

        //ASSERT
        // LV = 16 (seule UE choisie), coefficient 3 et pas 6
        // (10x6 + 16x3) / (6+3) = 108/9 = 12
        $this->assertSame(12.0, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    public function testLigneDeNoteManquanteRendLeGroupeIncomplet(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        // UE obligatoire sans ligne de note pour l'étudiant
        $this->ajouterUeNonSuivie($groupe, ects:3);

        $noteGroupe = $this->creerNoteGroupe($groupe);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        // ECTS suivis (6) différents des ECTS du groupe (9) : incomplet
        $this->assertNull($resultat->moyenne);
        $this->assertFalse($resultat->estComplet);
    }

    public function testPointsJuryDuGroupeAjoutes(): void
    {
        //ARRANGE
        $groupe = $this->creerGroupe('S1');
        $this->ajouterUe($groupe, ects:6, moyenne:10);
        $this->ajouterUe($groupe, ects:3, moyenne:16);

        $noteGroupe = $this->creerNoteGroupe($groupe)->setPointsJury(1.5);

        //ACT
        $resultat = $this->creerCalculateur()->calculerGroupe($noteGroupe);

        //ASSERT
        // 12 + 1.5 points jury = 13.5
        $this->assertSame(13.5, $resultat->moyenne);
        $this->assertTrue($resultat->estComplet);
    }

    /**
     * Groupe "obligatoire" si aucun ECTS n'est donné, "choix parmi" sinon.
     */
    private function creerGroupe(string $nom, ?float $ects = null, ?Groupe $parent = null): Groupe
    {
        $groupe = (new Groupe())
            ->setNom($nom)
            ->setType($ects === null ? 'obligatoire' : 'choix parmi')
            ->setEcts($ects);

        $parent?->addEnfant($groupe);

        return $groupe;
    }

    /**
     * Ajoute une UE au groupe, suivie par l'étudiant.
     * $moyenne et $complet sont ce que renverra le CalculateurUe (mocké) pour cette UE.
     */
    private function ajouterUe(
        Groupe $groupe,
        float $ects,
        ?float $moyenne,
        bool $complet = true,
        bool $dispense = false,
    ): NoteUe {
        $ue = $this->ajouterUeNonSuivie($groupe, $ects);

        $noteUe = (new NoteUe())
            ->setUe($ue)
            ->setEtudiant($this->etudiant)
            ->setIsDispense($dispense)
            ->setNeutraliseNoteMini(false);

        $this->notesUesParGroupe[spl_object_id($groupe)][] = $noteUe;
        $this->resultatsUe[spl_object_id($noteUe)] = new ResultatDto($moyenne, $complet);

        return $noteUe;
    }

    /**
     * Ajoute une UE dans la structure du groupe, sans ligne de note pour l'étudiant.
     */
    private function ajouterUeNonSuivie(Groupe $groupe, float $ects): Ue
    {
        $ue = (new Ue())->setNom('UE')->setEcts($ects);
        $groupe->addGroupeUe((new GroupeUe())->setUe($ue));

        return $ue;
    }

    private function creerNoteGroupe(Groupe $groupe): NoteGroupe
    {
        $noteGroupe = (new NoteGroupe())
            ->setGroupe($groupe)
            ->setEtudiant($this->etudiant)
            ->setIsDispense(false)
            ->setNeutraliseNoteMini(false);

        if ($groupe->getParent() !== null) {
            $this->notesGroupesParParent[spl_object_id($groupe->getParent())][] = $noteGroupe;
        }

        return $noteGroupe;
    }

    /**
     * Construit le calculateur avec des mocks qui renvoient les données préparées par le test.
     */
    private function creerCalculateur(): CalculateurGroupe
    {
        $calculateurUe = $this->createMock(CalculateurUe::class);
        $calculateurUe->method('calculerUe')->willReturnCallback(
            fn (NoteUe $noteUe) => $this->resultatsUe[spl_object_id($noteUe)]
        );

        $noteUeRepository = $this->createMock(NoteUeRepository::class);
        $noteUeRepository->method('findByEtudiantAndGroupe')->willReturnCallback(
            fn (Etudiant $etudiant, Groupe $groupe) => $this->notesUesParGroupe[spl_object_id($groupe)] ?? []
        );

        $noteGroupeRepository = $this->createMock(NoteGroupeRepository::class);
        $noteGroupeRepository->method('findByEtudiantAndParent')->willReturnCallback(
            fn (Etudiant $etudiant, Groupe $parent) => $this->notesGroupesParParent[spl_object_id($parent)] ?? []
        );

        return new CalculateurGroupe($calculateurUe, $noteUeRepository, $noteGroupeRepository);
    }
}

# Projet Jury

Application de gestion des résultats des étudiants d'une faculté (LPro TLWTM 2024-2025).

## Sommaire

- [Description](#description)
- [Modèle de données](#modèle-de-données)
- [Gestion des droits](#gestion-des-droits)
- [Notation](#notation)
- [Installation](#installation)
- [État du projet](#état-du-projet)

## Description

Le but de l'application est de stocker et gérer les résultats des étudiants d'une faculté : structure pédagogique (diplômes, mentions, parcours, années), organisation des enseignements (UEs, épreuves), et saisie/calcul des notes à cinq niveaux (année, division, groupe, UE, épreuve).

**Stack** : Symfony / Doctrine (ORM), base de données relationnelle.

> À compléter selon la stack réellement utilisée (version de PHP, de Symfony, moteur de base de données, etc.)

## Modèle de données

### Administration

| Table | Rôle |
|---|---|
| `config` | Paramètres globaux du site (une seule ligne : année en cours, responsable, webmestre, site actif ou non) |
| `users` | Comptes utilisateurs (hors enseignants), login/mot de passe/rôles gérés par le module security de Symfony |
| `annees_users` | Droits (`ROLE_READER` / `ROLE_WRITER`) d'un utilisateur sur une année |

### Structure pédagogique

Hiérarchie : `diplomes` → `mentions` → `parcours` → `annees` → `decoupages` → `divisions` → `groupes` → `ues` → `epreuves`

| Table | Rôle |
|---|---|
| `diplomes` | Liste des diplômes délivrés (avec `rang` d'affichage) |
| `mentions` | Mentions rattachées à un diplôme |
| `parcours` | Parcours rattachés à une mention |
| `annees` | Années de chaque parcours, rattachées à un découpage |
| `decoupages` | Profil d'une année (nombre de divisions, compensation, moyenne de validation) |
| `divisions` | Semestres/trimestres d'une année, rattachés à un groupe racine |
| `groupes` | Arbre récursif de groupes d'UEs (type "obligatoire" ou "choix parmi") |
| `groupes_ues` | Table de jointure groupes ↔ UEs |
| `ues` | Unités d'enseignement (ECTS, moyenne de validation, règle de calcul) |
| `epreuves` | Sous-parties d'une UE (coefficient, nature, durée) |
| `natures` | Nature d'une épreuve (écrit, oral, ...) |
| `calculs` | Règles de calcul des moyennes (actuellement : moyenne pondérée) |

### Étudiants et notation

| Table | Rôle |
|---|---|
| `etudiants` | Étudiants (numéro, nom, prénom) |
| `notes_annees` | Notes au niveau de l'année |
| `notes_divisions` | Notes au niveau des divisions |
| `notes_groupes` | Notes au niveau des groupes |
| `notes_ues` | Notes au niveau des UEs |
| `notes_epreuves` | Notes au niveau des épreuves |

À l'inscription d'un étudiant à une année (**inscription pédagogique**), toutes les lignes de notes correspondantes sont créées automatiquement, même vides.

## Gestion des droits

Hiérarchie des rôles (fichier `security.yaml`) :

1. Non authentifié : accès à la racine et à la page de login uniquement
2. `ROLE_USER` : pages générales (parcours, UEs...), sans données personnelles
3. `ROLE_MANAGER` : accès en lecture ou lecture/écriture aux années auxquelles il est inscrit (via `annees_users`)
4. `ROLE_ADMIN` : accès complet à toutes les années, gestion des utilisateurs de rôle inférieur, accès à `config`
5. `ROLE_SUPER_ADMIN` : gestion de tous les rôles (sauf auto-suppression)

## Notation

- Les notes sont saisies au niveau des **épreuves** et calculées vers le haut (UE → groupe → division → année), sauf si une note est saisie directement à un niveau supérieur (elle prime alors sur les calculs).
- Une **note minimale** (éliminatoire) non atteinte invalide l'entité concernée et remonte l'invalidation jusqu'à l'année, même si les moyennes sont suffisantes.
- Le jury peut **neutraliser** une invalidation (sans changer les notes), ce qui s'applique aux descendants mais pas aux ascendants.
- Un étudiant peut être **dispensé** d'une note : elle est alors ignorée dans le calcul (note et coefficient).
- Champ `bonus` disponible uniquement au niveau `notes_annees`.

## Installation

> À compléter : prérequis, clonage, configuration `.env`, installation des dépendances (`composer install`), migrations Doctrine, création des fixtures/jeu de données de test, lancement du serveur.

```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start
```

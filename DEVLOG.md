# Journal de Développement (DEVLOG)

**Nom & Prénom** :Ndeye Fatou Ndiour

**Projet** : StoreManager Pro (ERP PHP/POO)

---

## 1. Suivi Chronologique des Phases

### [Vendredi - Phase 1] : Conception & BDD Fallback

- **Heure de réalisation** : 19h00 - 23h00
- **Ce qui a été fait** :

  - Modélisation du périmètre de l'application via un diagramme de Cas d'Utilisation avec  PlantUML centré sur les rôles de l'Admin, charger de Stock , charger de Vente , innventaire, ses permissions , les inclusions   et  les extendes .
  - la modelisation est detailler et structure
  - Création du diagramme de classes  définissant les entités métiers (`Client`, `Produit`, `Commande`, `Dette`) et leurs cardinalités.
  - jai corriger une erreur sur le use case j lavais op vue
  - jai ajouter le dossier image ki regroupe les rendes des use case
  - creation de la base de donner avec deux fichiers `schema.sql` (PostgreSQL) et `schema_sqlite.sql`
  - pour l `schema.sql` rien n change pour on fait comme on l fesais
  - pour le `schema_sqlite.sql` on a ajouter une nouvelle chose `PRAGMA foreign_keys = ON;` qui nous permet d'actevier les cles etranger en `sqlite`
  - on a sa AUTOINCREMENT aussi il demmande a la base de donner de genere automatiquement une nouvelle id
- **Difficultés / Obstacles** :

  - Syntaxe sur PlantUML pour l'imbrication des cas d'utilisation complexes de l'administrateur.
  - Si on le mot usecase et les geuillemet son coler on a des erreur s j les remarque les alias doivent  etre des string aussi

---

## 2. Autopsie de 3 Méthodes Clés (Indispensable pour l'oral)

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
  - on a sa AUTOINCREMENT aussi il demmande a la base de donner de genere automatiquement un nouvelle id
  - creation du src/core/Database.php
  - on a initialiser la fonction de connexion avec singleton s ki veux dire on aura un connexion si c allumer on continue avec sinon on cree et sa ss fait une seule fois
  - la fonction __contruct est privee pour ne pas kon cree un nouvelle en dehord du de la classe
- **Difficultés / Obstacles** :

  - Syntaxe sur PlantUML pour l'imbrication des cas d'utilisation complexes de l'administrateur.
  - Si on le mot usecase et les geuillemet son coler on a des erreur s j les remarque les alias doivent  etre des string aussi
  - 

---

## 2. Autopsie de 3 Méthodes Clés (Indispensable pour l'oral)


### Méthode 1 : `Database::connexionDB()`

- **Fichier** : `src/Core/Database.php`
- 
- **Rôle** : Garantit une instance de connexion unique (Pattern Singleton) à l'application pour économiser les ressources système et gère le basculement automatique (Fallback) vers SQLite si le serveur PostgreSQL principal est inaccessible.
- 
- **Explication ligne par ligne** :

  - `private static ?PDO $connexion = null;` : Fait une déclaration  statique privée initialisée à `null` pour stocker l'unique instance de connexion PDO en mémoire RAM.
  - `private function __construct() {}` : Le constructeur est privé pour interdire l'utilisation du mot-clé `new` en dehors de cette classe, empêchant la création de plusieur connexions .
  - `public static function connexionDB(): PDO` : Méthode statique publique qui sert de point d'accès unique global pour récupérer la connexion partout dans le projet.
  - `if (self::$connexion === null)` : Vérifie si la connexion n'est pas  encore été créée se qui veux dire qu'elle est null. Si elle existe déjà, PHP ignore tout le bloc de création et passe directement au `return` (Principe du Singleton).
  - `try { ... }` : Ouvre un bloc de surveillance pour tester la connexion à l'infrastructure principale il dit essaie .
  - `$pdo = new PDO("pgsql:host=localhost;dbname=gestion_v_d_a;port=5432", ...)` : C'est pour  établir une session avec le serveur PostgreSQL local sur le port 5432 avec la base `gestion_v_d_a`.`port=5432"`"`postgres`" et l mots de pass
  - `$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);` : Configure PDO pour retourner les résultats des requêtes SQL sous forme de tableaux associatifs clairs avec des clefs.
  - `$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);` : Force PDO à lever des exceptions détaillées en cas d'erreur SQL,pour l debug.
  - `self::$connexion = $pdo;` : Stocke l'instance PostgreSQL fonctionnelle dans la propriété statique pour les futurs appels.
  - `catch (Exception $ex) { ... }` : si l try marche op on utilise le `catch` ,Intercepte toute panne ou indisponibilité du serveur PostgreSQL pour empêcher l'application de s'arreter.
  - `$pdo = new PDO("sqlite:erp.db");` : Enclenche le mode de secours (Fallback) en initialisant une connexion vers le fichier local léger SQLite `erp.db ` cree precedement dans database
  - `$pdo->exec("PRAGMA foreign_keys = ON");` : Exécute une commande pour forcer SQLite à activer la vérification des clés étrangères .
  - `self::$connexion = $pdo;` : donne l'instance SQLite de secours à la propriété statique.
  - `return self::$connexion;` : Renvoie l'instance PDO active (PostgreSQL ou SQLite) selon le cas prête à exécuter des requêtes.

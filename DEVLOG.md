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

  ### [Samedi - Phase 2] : POO, Repositories & Ventes POS


  - **Heure de réalisation** : 09h00 - 20h00
  - **Ce qui a été fait** : src/model/Entety sa regroupe tout es les classe que j'avais fait dans `schema.sql` on a toutes les classe s chacun avec leur attributs au complet jai eu a modifier l fichier sql par ce que jai remarque que javais pas besoin de certain attribut
  - on doit utuliser de require op des namspeace
  - jai ajouter les methode pour chaque classe et jai utiliser les variable en format camelCas
  - les clef etranger son des objet donc leur type son leur classe
  - Dans le dossier /Entity jai ajouter des require_once pour chaque entety ki a une clef entranger pour qu'il l reconnais il faut faire un require_once de la classe exemple (require_once. '/Fournisseur.php';)
  - jai utilise private pour tout les attribut par ce que il empeche au vu et au controller de modifier les les variables
  - le ? permet a la variable (attribut) d'etre null
  - pour approvisionnement et commande on a **Le tableau `$lignes` :** Il sert à regrouper toutes les lignes de produit ou article .
  - `Le Constructeur (__construct)` c une methode magic appelle par  mots cle new il nous permette de cree des objet pour un classe donne
  - les fonction get et set nous permet de avoir acces au attribut (Le **Getter** (commence par `get`) extrait et retourne proprement la valeur en lecture seule,Le **Setter** (commence par `set`) prend une valeur en paramètre et écrase l'ancienne valeur. Le type de retour est `void` car un setter ne retourne rien, il exécute juste une action .)
  - on a aussi pour chaque ses fonction utilitaire
  - jai ajouter sur database les fonction ki vont m permettre de faire le repository  jai aussi modifier la fonction `connexionDB()` pour l chemin

    - jai ajouter `deconnecteDB()` pour la deconnexion ,`query` , ` prepare` ,  `executeQuery`,`executeUpdate`, `getAllTable` avec leur paramettre ,
    - javais des erreur sur digramme de classe les relation etais faites deux fois ms c corriger
    - jai unitialiser des donner dans la base de donner
    - jai remplie la repository l clientRepository , fournisseurRepository , produitRepository avec les fonction ki nous permet d'insere , recupere tout les clients , selectionner par id et conversion

    pour l service de vente jai pris beaucoup de temps pour le faire jai apris aussi beaucoup de chose javais du mal a l faire avec les requete la succesion des requetes qui viens a pres lautre on a dabord insere sur commande recupere l'id grace a la reque executeUpdate apres sur le panier pour insere les ligne de commande j un peu compris pourkoi tu disais sur le  panier par ce que sa existe un moment etre on a en plus besoin on l stock op  jai essayer de l faire comme jai pue
  - pour l erp.db jai essayer de le faire ms sa reste j crois il faut que j continue
  - vous pouvez voir aussi que jai touche quelque fichier ms rien n'est change apprenait juste les essayer de les refaire
  - **Difficultés / Obstacles** :
  - cetait difficile de faire les entity sa ma pris bcp de temps  par ce que sa demander beaucoup d vigilance yavais boucoup de chose a faire les fonction ki sont dans les classe aussi jai faitbeaucoup d recherche pour j connaissais pas aussi quelle genre de fonction qu'elle prenais jai appris aussi les fonction setter et getter
  - dans data base les fonction on un peut changer par rapport se quon fesais en procedural
  - pour la ripo le on a maitenant un fonction de conversion `enObjet(array $table)`

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
  - `return self::$connexion;` : Renvoie l'instance PDO active (PostgreSQL ou SQLite) selon le cas prête à exécuter des requête.
  -

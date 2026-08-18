<?php

require_once dirname(__DIR__) . "/Entity/Fournisseur.php";

class FournisseurRepository {

    private static ?PDO $pdo = null;

    private function __construct() {}

    private static function init(): void {
        if (self::$pdo === null) {
            self::$pdo = Database::connexionDB();
        }
    }
    
    public static function insert(Fournisseur $fournisseur): int {
        self::init(); 

        $sql = "INSERT INTO fournisseur (nom, email, telephone, adresse)
                VALUES(:nom, :email, :telephone, :adresse)";

        Database::executeUpdate(self::$pdo, $sql, [
            'nom'       => $fournisseur->getNom(),
            'email'     => $fournisseur->getEmail(),
            'telephone' => $fournisseur->getTelephone(),
            'adresse'   => $fournisseur->getAdresse()
        ]);

        $id = (int) self::$pdo->lastInsertId();
        $fournisseur->setId($id);
        
        return $id;
    }

  
    public static function selectById(int $id): ?Fournisseur {
        self::init();

        $sql = "SELECT * FROM fournisseur WHERE id = :id";
        $fournisseur = Database::executeQuery(self::$pdo, $sql, ['id' => $id]);

        if (!$fournisseur) return null;
        
        return self::enObjet($fournisseur);
    }


    public static function selectAll(): array {
        $tableauFournisseurs = Database::getAllTable('fournisseur');
        $fournisseurs = [];

        if (empty($tableauFournisseurs)) {
            return $fournisseurs;
        }
        
        foreach ($tableauFournisseurs as $fournisseur) {
            $fournisseurs[] = self::enObjet($fournisseur);
        }

        return $fournisseurs;
    }

   
    private static function enObjet(array $fournisseur): Fournisseur {
        return new Fournisseur(
            $fournisseur['nom'],
            $fournisseur['email'] ?? null,
            $fournisseur['telephone'] ?? null,
            $fournisseur['adresse'] ?? null,
            (int) $fournisseur['id']
        );
    }
}

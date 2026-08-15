<?php

require_once dirname(__DIR__) . "/Entity/Fournisseur.php";

class FournisseurRepository {

    private PDO $pdo;

    public function __construct(){

        $this->pdo = Database::connexionDB();
    }

    
    public function insert(Fournisseur $fournisseur): int{

        $sql = "INSERT INTO fournisseur (nom, email, telephone, adresse)
                VALUES(:nom, :email, :telephone, :adresse)";

        Database::executeUpdate($this->pdo, $sql, [
            'nom'       => $fournisseur->getNom(),
            'email'     => $fournisseur->getEmail(),
            'telephone' => $fournisseur->getTelephone(),
            'adresse'   => $fournisseur->getAdresse()
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $fournisseur->setId($id);
        return $id;
    }

    
    public function selectById(int $id): ?Fournisseur
    {
        $sql = "SELECT * FROM fournisseur WHERE id = :id";
        $fournisseur = Database::executeQuery($this->pdo, $sql, ['id' => $id]);

        if (!$fournisseur) return null;
        
        return $this->enObjet($fournisseur);
    }

    
    public function selectAll(): array
    {
        $tableauFournisseurs = Database::getAllTable('fournisseur');
        $fournisseurs = [];

        if (empty($tableauFournisseurs)) return $fournisseurs;
        
        foreach ($tableauFournisseurs as $fournisseur) {
            $fournisseurs[] = $this->enObjet($fournisseur);
        }

        return $fournisseurs;
    }

    
    private function enObjet(array $fournisseur): Fournisseur
    {
        return new Fournisseur(
            $fournisseur['nom'],
            $fournisseur['email'] ?? null,
            $fournisseur['telephone'] ?? null,
            $fournisseur['adresse'] ?? null,
            (int) $fournisseur['id']
        );
    }
}

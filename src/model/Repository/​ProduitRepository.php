<?php

require_once dirname(__DIR__) . "/Entity/Produit.php";

class ProduitRepository {

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connexionDB();
    }

    
    public function insert(Produit $produit): int{

        $sql = "INSERT INTO produit (code, libelle, prix_vente, cout_achat, stock_initial, stock_actuel, seuil_alerte)
                VALUES(:code, :libelle, :prix_vente, :cout_achat, :stock_initial, :stock_actuel, :seuil_alerte)";

        Database::executeUpdate($this->pdo, $sql, [
            'code'          => $produit->getCode(),
            'libelle'       => $produit->getLibelle(),
            'prix_vente'    => $produit->getPrixVente(),
            'cout_achat'    => $produit->getCoutAchat(),
            'stock_initial' => $produit->getStockInitial(),
            'stock_actuel'  => $produit->getStockActuel(),
            'seuil_alerte'  => $produit->getSeuilAlerte()
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $produit->setId($id);
        return $id;
    }

    
    public function selectById(int $id): ?Produit{

        $sql = "SELECT * FROM produit WHERE id = :id";
        $produit = Database::executeQuery($this->pdo, $sql, ['id' => $id]);

        if (!$produit) return null;
        
        return $this->enObjet($produit);
    }

   
    public function selectAll(): array{

        $tableauProduits = Database::getAllTable('produit');
        $produits = [];

        if (empty($tableauProduits)) return $produits;
        
        foreach ($tableauProduits as $produit) {
            $produits[] = $this->enObjet($produit);
        }

        return $produits;
    }


   
    private function enObjet(array $produit): Produit{

        return new Produit(
            $produit['code'],
            $produit['libelle'],
            (float) $produit['prix_vente'],
            (float) $produit['cout_achat'],
            (int) $produit['stock_initial'],
            (int) $produit['stock_actuel'],
            (int) $produit['seuil_alerte'],
            (int) $produit['id']
        );
    }
}

<?php

require_once dirname(__DIR__) . "/Entity/Produit.php";

class ProduitRepository {

    private static ?PDO $pdo = null;

    private function __construct() {}

    private static function init(): void {
        if (self::$pdo === null) {
            self::$pdo = Database::connexionDB();
        }
    }
    
    public static function insert(Produit $produit): int {
        self::init(); 

        $sql = "INSERT INTO produit (code, libelle, prix_vente, cout_achat, stock_initial, stock_actuel, seuil_alerte)
                VALUES(:code, :libelle, :prix_vente, :cout_achat, :stock_initial, :stock_actuel, :seuil_alerte)";

        Database::executeUpdate(self::$pdo, $sql, [
            'code'          => $produit->getCode(),
            'libelle'       => $produit->getLibelle(),
            'prix_vente'    => $produit->getPrixVente(),
            'cout_achat'    => $produit->getCoutAchat(),
            'stock_initial' => $produit->getStockInitial(),
            'stock_actuel'  => $produit->getStockActuel(),
            'seuil_alerte'  => $produit->getSeuilAlerte()
        ]);

        $id = (int) self::$pdo->lastInsertId();
        $produit->setId($id);
        
        return $id;
    }

    public static function selectById(int $id): ?Produit {
        self::init();

        $sql = "SELECT * FROM produit WHERE id = :id";
        $produit = Database::executeQuery(self::$pdo, $sql, ['id' => $id]);

        if (!$produit) return null;
        
        return self::enObjet($produit);
    }


    public static function selectAll(): array {
        $tableauProduits = Database::getAllTable('produit');
        $produits = [];

        if (empty($tableauProduits)) {
            return $produits;
        }
        
        foreach ($tableauProduits as $produit) {
            $produits[] = self::enObjet($produit);
        }

        return $produits;
    }

    public static function diminuerStock(int $produitId, int $quantite): void {
        self::init();
        $sql = "UPDATE produit SET stock_actuel = stock_actuel - :qte WHERE id = :produit_id";
        Database::executeUpdate(self::$pdo, $sql, [
            'qte'        => $quantite,
            'produit_id' => $produitId
        ]);
    }


    private static function enObjet(array $produit): Produit {
        return new Produit(
            $produit['code'],
            $produit['libelle'],
            (float) $produit['prix_vente'],
            (float) $produit['cout_achat'],
            (int) ($produit['stock_initial'] ?? 0),
            (int) ($produit['stock_actuel'] ?? 0),
            (int) ($produit['seuil_alerte'] ?? 0),
            (int) $produit['id']
        );
    }
}

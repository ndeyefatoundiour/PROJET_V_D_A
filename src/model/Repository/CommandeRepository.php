<?php

class CommandeRepository {
    
    private static ?PDO $pdo = null;

    private function __construct() {}

    private static function init(): void {
        
        if (self::$pdo === null) { 

            self::$pdo = Database::connexionDB(); 
        }
    }

    public static function insert(array $data): int {
        self::init();
        $sql = "INSERT INTO commande (numero_facture, montant_total, montant_verse, mode_reglement, statut, utilisateur_id, client_id) 
                VALUES (:num, :total, :verse, :mode, :statut, :user, :client)";
        
        Database::executeUpdate(self::$pdo, $sql, [
            'num'    => $data['numero_facture'],
            'total'  => $data['montant_total'],
            'verse'  => $data['montant_verse'],
            'mode'   => $data['mode_reglement'],
            'statut' => $data['statut'],
            'user'   => $data['utilisateur_id'],
            'client' => $data['client_id']
        ]);
        return (int) self::$pdo->lastInsertId();
    }

    public static function insertLigne(array $data): void {

        self::init();
        $sql = "INSERT INTO ligne_commande (quantite, prix_unitaire, sous_total, commande_id, produit_id) 
                VALUES (:qte, :prix, :sous_total, :commande, :produit)";
        
        Database::executeUpdate(self::$pdo, $sql, [
            'qte'        => $data['quantite'],
            'prix'       => $data['prix_unitaire'],
            'sous_total' => $data['sous_total'],
            'commande'   => $data['commande_id'],
            'produit'    => $data['produit_id']
        ]);
    }
}

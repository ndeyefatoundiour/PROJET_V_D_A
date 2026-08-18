<?php

class DetteRepository {
    private static ?PDO $pdo = null;
    private function __construct() {}
    private static function init(): void {
        if (self::$pdo === null) { self::$pdo = Database::connexionDB(); }
    }

    public static function insert(array $data): int {
        self::init();
        
        $sqlInsert = "INSERT INTO dette (ref, montant_initial, montant_verse, montant_restant, date_echeance, statut, client_id, commande_id) 
                      VALUES ('#', :initial, :verse, :restant, :echeance, :statut, :client, :commande)";
        
        Database::executeUpdate(self::$pdo, $sqlInsert, [
            'initial'  => $data['montant_initial'],
            'verse'    => $data['montant_verse'],
            'restant'  => $data['montant_restant'],
            'echeance' => $data['date_echeance'],
            'statut'   => $data['statut'],
            'client'   => $data['client_id'],
            'commande' => $data['commande_id']
        ]);
        
        $detteId = (int) self::$pdo->lastInsertId();
        
        $referencePropre = "#DT-" . $detteId;
        $sqlUpdate = "UPDATE dette SET ref = :ref WHERE id = :id";
        
        Database::executeUpdate(self::$pdo, $sqlUpdate, [
            'ref' => $referencePropre,
            'id'  => $detteId
        ]);
        
        return $detteId;
    }
}

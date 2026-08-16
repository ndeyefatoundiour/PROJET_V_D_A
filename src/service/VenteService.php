<?php

class VenteService {

    public static function enregistrerVente(
        
        PDO $pdo, 
        string $numeroFacture, 
        float $montantTotal, 
        float $montantVerse, 
        string $modeReglement, 
        int $utilisateurId, 
        ?int $clientId, 
        array $panier 
    ): void {
        
        $pdo->beginTransaction();

        try {
            $statut = 'PAYEE';
            if ($montantVerse == 0) {
                $statut = 'NON_PAYEE';
            } elseif ($montantVerse < $montantTotal) {
                $statut = 'PARTIELLE';
            }
                
            $sqlCommande = "INSERT INTO commande (numero_facture, montant_total, montant_verse, mode_reglement, statut, utilisateur_id, client_id) 
                            VALUES (:num, :total, :verse, :mode, :statut, :user, :client)";
            
            $commandeId = Database::executeUpdate($pdo, $sqlCommande, [
                'num' => $numeroFacture,
                'total' => $montantTotal,
                'verse' => $montantVerse,
                'mode' => $modeReglement,
                'statut' => $statut,
                'user' => $utilisateurId,
                'client' => $clientId
            ]);

            foreach ($panier as $article) {

                $sousTotal = $article['quantite'] * $article['prix'];

                $sqlLigne = "INSERT INTO ligne_commande (quantite, prix_unitaire, sous_total, commande_id, produit_id) 
                             VALUES (:qte, :prix, :sous_total, :commande, :produit)";
                
                Database::executeUpdate($pdo, $sqlLigne, [
                    'qte' => $article['quantite'],
                    'prix' => $article['prix'],
                    'sous_total' => $sousTotal,
                    'commande' => $commandeId,
                    'produit' => $article['produit_id']
                ]);

                $sqlStock = "UPDATE produit SET stock_actuel = stock_actuel - :qte WHERE id = :produit_id";
                Database::executeUpdate($pdo, $sqlStock, [
                    'qte' => $article['quantite'],
                    'produit_id' => $article['produit_id']
                ]);
            }

            if ($statut === 'PARTIELLE' || $statut === 'NON_PAYEE') {

                if ($clientId === null) {
                    throw new Exception("Impossible de créer une dette pour ce client.");
                }

                $montantRestant = $montantTotal - $montantVerse;
                $dateEcheance = date('Y-m-d', strtotime('+7 days')); 

                $sqlDette = "INSERT INTO dette (ref, montant_initial, montant_verse, montant_restant, date_echeance, statut, client_id, commande_id) 
                             VALUES ('#', :initial, :verse, :restant, :echeance, :statut, :client, :commande)";
                
                $detteId = Database::executeUpdate($pdo, $sqlDette, [

                    'initial' => $montantTotal,
                    'verse' => $montantVerse,
                    'restant' => $montantRestant,
                    'echeance' => $dateEcheance,
                    'statut' => $statut,
                    'client' => $clientId,
                    'commande' => $commandeId
                ]);

                $referencePropre = "#DT-" . $detteId;
                $sqlUpdateDette = "UPDATE dette SET ref = :ref WHERE id = :id";
                
                Database::executeUpdate($pdo, $sqlUpdateDette, [
                    'ref' => $referencePropre,
                    'id' => $detteId
                ]);
            }

            $pdo->commit();
            
            echo "[SUCCÈS] La vente {$numeroFacture} a été enregistrée, les stocks mis à jour et la dette calculée !<br>";

        } catch (Exception $ex) {

        $pdo->rollBack();

            throw new Exception("Erreur lors de la vente : " . $ex->getMessage());
        }
    }
}

<?php

require_once dirname(__DIR__) . "/Repository/CommandeRepository.php";
require_once dirname(__DIR__) . "/Repository/ProduitRepository.php";
require_once dirname(__DIR__) . "/Repository/DetteRepository.php";

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
                
            $commandeId = CommandeRepository::insert([
                'numero_facture' => $numeroFacture,
                'montant_total'  => $montantTotal,
                'montant_verse'  => $montantVerse,
                'mode_reglement' => $modeReglement,
                'statut'         => $statut,
                'utilisateur_id' => $utilisateurId,
                'client_id'      => $clientId
            ]);

            foreach ($panier as $article){
                $sousTotal = $article['quantite'] * $article['prix'];

                CommandeRepository::insertLigne([
                    'quantite'      => $article['quantite'],
                    'prix_unitaire' => $article['prix'],
                    'sous_total'    => $sousTotal,
                    'commande_id'   => $commandeId,
                    'produit_id'    => $article['produit_id']
                ]);

                ProduitRepository::diminuerStock($article['produit_id'], $article['quantite']);
            }

            if ($statut === 'PARTIELLE' || $statut === 'NON_PAYEE') {
                if ($clientId === null) {
                    throw new Exception("Impossible de créer une dette pour ce client.");
                }

                $montantRestant = $montantTotal - $montantVerse;
                $dateEcheance   = date('Y-m-d', strtotime('+7 days')); 

                DetteRepository::insert([
                    'montant_initial' => $montantTotal,
                    'montant_verse'   => $montantVerse,
                    'montant_restant' => $montantRestant,
                    'date_echeance'   => $dateEcheance,
                    'statut'          => $statut,
                    'client_id'       => $clientId,
                    'commande_id'     => $commandeId
                ]);
            }

            $pdo->commit();
            echo "[SUCCÈS] La vente {$numeroFacture} a été enregistrée de manière 100% architecturale !<br>";

        } catch (Exception $ex) {

            $pdo->rollBack();
            throw new Exception("Erreur lors de la vente : " . $ex->getMessage());
        }
    }
}

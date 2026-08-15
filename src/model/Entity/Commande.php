<?php
namespace App\Model\Entity;

class Commande {
    private int $id ;
    private string $numeroFacture;
    private float $montantTotal;
    private float $montantVerse;
    private string $modeReglement ;
    private string $statut; 
    private string $dateVente;
    private string $dateEcheance ;
    private int $utilisateurId;
    private int $clientId ;
}

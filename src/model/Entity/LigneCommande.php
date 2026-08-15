<?php
namespace App\Model\Entity;

class LigneCommande {
    private int $id ;
    private int $quantite;
    private float $prixUnitaire;
    private float $sousTotal;
    private int $commandeId;
    private int $produitId;
}

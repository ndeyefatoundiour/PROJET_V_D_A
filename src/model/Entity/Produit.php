<?php
namespace App\Model\Entity;

class Produit {
    private int $id ;
    private string $code;
    private string $libelle;
    private float $prixVente;
    private float $coutAchat;
    private int $stockInitial;
    private int $stockActuel;
    private int $seuilAlerte;
}

<?php

class Produit {
    private ?int $id;
    private string $code;
    private string $libelle;
    private float $prixVente;
    private float $coutAchat;
    private int $stockInitial;
    private int $stockActuel;
    private int $seuilAlerte;

    public function __construct(?int $id, string $code, string $libelle, float $prixVente, float $coutAchat, int $stockInitial, int $stockActuel, int $seuilAlerte) {
        $this->id = $id;
        $this->code = $code;
        $this->libelle = $libelle;
        $this->prixVente = $prixVente;
        $this->coutAchat = $coutAchat;
        $this->stockInitial = $stockInitial;
        $this->stockActuel = $stockActuel;
        $this->seuilAlerte = $seuilAlerte;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getCode(): string { 
        return $this->code; 
    }
    public function getLibelle(): string { 
        return $this->libelle; 
    }
    public function getPrixVente(): float { 
        return $this->prixVente; 
    }
    public function getCoutAchat(): float { 
        return $this->coutAchat; 
    }
    public function getStockInitial(): int { 
        return $this->stockInitial; 
    }
    public function getStockActuel(): int { 
        return $this->stockActuel; 
    }
    public function getSeuilAlerte(): int { 
        return $this->seuilAlerte; 
    }
}

<?php
require_once __DIR__ . '/Produit.php';

class LigneCommande {
    private ?int $id;
    private int $quantite;
    private float $prix_unitaire;
    private float $sous_total;
    private int $commandeId;
    
    private int $produitId;
    private ?Produit $produit = null;

    public function __construct(int $quantite, float $prix_unitaire, int $commandeId, int $produitId, float $sous_total = 0.0, ?int $id = null) {
        $this->id = $id;
        $this->quantite = $quantite;
        $this->prix_unitaire = $prix_unitaire;
        $this->commandeId = $commandeId;
        $this->produitId = $produitId;
        $this->sous_total = $sous_total ?: ($quantite * $prix_unitaire);
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getQuantite(): int { 
        return $this->quantite; 
    }
    public function setQuantite(int $quantite): void { 
        $this->quantite = $quantite; 
        $this->sous_total = $this->quantite * $this->prix_unitaire; 
    }

    public function getPrixUnitaire(): float { 
        return $this->prix_unitaire; 
    }
    public function setPrixUnitaire(float $prix_unitaire): void { 
        $this->prix_unitaire = $prix_unitaire; $this->sous_total = $this->quantite * $this->prix_unitaire; 
    }

    public function getSousTotal(): float { 
        return $this->sous_total; 
    }
    public function setSousTotal(float $sous_total): void { 
        $this->sous_total = $sous_total; 
    }

    public function getCommandeId(): int { 
        return $this->commandeId; 
    }
    public function setCommandeId(int $commandeId): void { 
        $this->commandeId = $commandeId; 
    }

    public function getProduitId(): int { 
        return $this->produitId;
    }
    public function setProduitId(int $produitId): void { 
        $this->produitId = $produitId; 
    }

    public function getProduit(): ?Produit { 
        return $this->produit; 
    }
    public function setProduit(?Produit $produit): void { 
        $this->produit = $produit; 
    }
}

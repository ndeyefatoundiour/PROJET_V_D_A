<?php

class LigneCommande {
    private ?int $id;
    private int $quantite;
    private float $prixUnitaire;
    private float $sousTotal;
    private int $commandeId;
    private int $produitId;

    public function __construct(?int $id, int $quantite, float $prixUnitaire, float $sousTotal, int $commandeId, int $produitId) {
        $this->id = $id;
        $this->quantite = $quantite;
        $this->prixUnitaire = $prixUnitaire;
        $this->sousTotal = $sousTotal;
        $this->commandeId = $commandeId;
        $this->produitId = $produitId;
    }

    public function getId(): ?int { 
        
    return $this->id; 
    }
    public function getQuantite(): int { 
        return $this->quantite; 
    }
    public function getPrixUnitaire(): float { 
        return $this->prixUnitaire; 
    }
    public function getSousTotal(): float { 
        return $this->sousTotal; 
    }
    public function getCommandeId(): int { 
        return $this->commandeId;
    }
    public function getProduitId(): int { 
        return $this->produitId; 
    }
}

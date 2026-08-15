<?php

class LigneApprovisionnement {
    private ?int $id;
    private int $quantiteAppro;
    private int $quantiteRecue;
    private float $prixAchat;
    private float $sousTotal;
    private int $approvisionnementId;
    private int $produitId;

    public function __construct(?int $id, int $quantiteAppro, int $quantiteRecue, float $prixAchat, float $sousTotal, int $approvisionnementId, int $produitId) {
        $this->id = $id;
        $this->quantiteAppro = $quantiteAppro;
        $this->quantiteRecue = $quantiteRecue;
        $this->prixAchat = $prixAchat;
        $this->sousTotal = $sousTotal;
        $this->approvisionnementId = $approvisionnementId;
        $this->produitId = $produitId;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getQuantiteAppro(): int { 
        return $this->quantiteAppro; 
    }
    public function getQuantiteRecue(): int { 
        return $this->quantiteRecue; 
    }
    public function getPrixAchat(): float { 
        return $this->prixAchat; 
    }
    public function getSousTotal(): float { 
        return $this->sousTotal; 
    }
    public function getApprovisionnementId(): int { 
        return $this->approvisionnementId; 
    }
    public function getProduitId(): int { 
        return $this->produitId;
    }
}

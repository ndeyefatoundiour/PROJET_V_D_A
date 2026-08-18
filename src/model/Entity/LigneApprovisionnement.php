<?php
require_once __DIR__ . '/Produit.php';

class LigneApprovisionnement {
    private ?int $id;
    private int $quantite_appro;
    private int $quantite_recue;
    private float $prix_achat;
    private float $sous_total;
    private Approvisionnement $Approvisionnement;
    private ?Produit $produit = null;

    public function __construct(int $quantite_appro, float $prix_achat, int $Approvisionnement, int $quantite_recue = 0, float $sous_total = 0.0, ?int $id = null) {
        $this->id = $id;
        $this->quantite_appro = $quantite_appro;
        $this->quantite_recue = $quantite_recue;
        $this->prix_achat = $prix_achat;
        $this->Approvisionnement = $Approvisionnement;
        $this->sous_total = $sous_total ?: ($quantite_appro * $prix_achat);
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getQuantiteAppro(): int { 
        return $this->quantite_appro; 
    }
    public function setQuantiteAppro(int $quantite_appro): void { 
        $this->quantite_appro = $quantite_appro; $this->sous_total = $this->quantite_appro * $this->prix_achat; 
    }

    public function getQuantiteRecue(): int { 
        return $this->quantite_recue; 
    }
    public function setQuantiteRecue(int $quantite_recue): void { 
        $this->quantite_recue = $quantite_recue; 
    }

    public function getPrixAchat(): float { 
        return $this->prix_achat; 
    }
    public function setPrixAchat(float $prix_achat): void { 
        $this->prix_achat = $prix_achat; $this->sous_total = $this->quantite_appro * $this->prix_achat; 
    }

    public function getSousTotal(): float { 
        return $this->sous_total; 
    }
    public function setSousTotal(float $sous_total): void { 
        $this->sous_total = $sous_total; 
    }

    public function getApprovisionnement(): int { 
        return $this->approvisionnement; 
    }
    public function setApprovisionnement(int $approvisionnement): void { 
        $this->approvisionnement = $approvisionnement; 
    }

    public function getProduit(): ?Produit { 
        return $this->produit; 
    }
    public function setProduit(?Produit $produit): void { 
        $this->produit = $produit; 
    }
}

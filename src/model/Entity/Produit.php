<?php

class Produit {
    private ?int $id;
    private string $code;
    private string $libelle;
    private float $prix_vente;
    private float $cout_achat;
    private int $stock_initial;
    private int $stock_actuel;
    private int $seuil_alerte;

    public function __construct(string $code, string $libelle, float $prix_vente, float $cout_achat, int $stock_initial, int $stock_actuel, int $seuil_alerte, ?string $categorie = null, ?int $id = null) {
        $this->id = $id;
        $this->code = $code;
        $this->libelle = $libelle;
        $this->prix_vente = $prix_vente;
        $this->cout_achat = $cout_achat;
        $this->stock_initial = $stock_initial;
        $this->stock_actuel = $stock_actuel;
        $this->seuil_alerte = $seuil_alerte;
        $this->categorie = $categorie;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getCode(): string { 
        return $this->code; 
    }
    public function setCode(string $code): void { 
        $this->code = $code; 
    }

    public function getLibelle(): string { 
        return $this->libelle; 
    }
    public function setLibelle(string $libelle): void { 
        $this->libelle = $libelle; 
    }

    public function getPrixVente(): float { 
        return $this->prix_vente; 
    }
    public function setPrixVente(float $prix_vente): void { 
        $this->prix_vente = $prix_vente; 
    }

    public function getCoutAchat(): float { 
        return $this->cout_achat; 
    }
    public function setCoutAchat(float $cout_achat): void { 
        $this->cout_achat = $cout_achat; 
    }

    public function getStockInitial(): int { 
        return $this->stock_initial; 
    }
    public function setStockInitial(int $stock_initial): void { 
        $this->stock_initial = $stock_initial; 
    }

    public function getStockActuel(): int { 
        return $this->stock_actuel; 
    }
    public function setStockActuel(int $stock_actuel): void { 
        $this->stock_actuel = $stock_actuel; 
    }

    public function getSeuilAlerte(): int { 
        return $this->seuil_alerte; }
    public function setSeuilAlerte(int $seuil_alerte): void { 
        $this->seuil_alerte = $seuil_alerte; 
    }

    public function getCategorie(): ?string { 
        return $this->categorie; 
    }
    public function setCategorie(?string $categorie): void { 
        $this->categorie = $categorie; 
    }
}

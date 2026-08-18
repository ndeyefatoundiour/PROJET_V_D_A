<?php
require_once __DIR__ . '/Utilisateur.php';
require_once __DIR__ . '/Client.php';

class Commande {
    private ?int $id;
    private string $numero_facture;
    private float $montant_total;
    private float $montant_verse;
    private ?string $mode_reglement;
    private string $statut;
    private string $date_vente;
    private ?string $date_echeance;
    private ?Utilisateur $utilisateur = null;
    private ?Client $client = null;
    private array $lignes = [];

    public function __construct(string $numero_facture, float $montant_total = 0.0, float $montant_verse = 0.0, ?string $mode_reglement = null, string $statut = 'EN_ATTENTE', ?string $date_vente = null, ?string $date_echeance = null, ?int $id = null) {
        $this->id = $id;
        $this->numero_facture = $numero_facture;
        $this->montant_total = $montant_total;
        $this->montant_verse = $montant_verse;
        $this->mode_reglement = $mode_reglement;
        $this->statut = $statut;
        $this->date_vente = $date_vente ?: date('Y-m-d');
        $this->date_echeance = $date_echeance;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getNumeroFacture(): string { 
        return $this->numero_facture; 
    }
    public function setNumeroFacture(string $numero_facture): void { 
        $this->numero_facture = $numero_facture; 
    }

    public function getMontantTotal(): float { 
        return $this->montant_total; 
    }
    public function setMontantTotal(float $montant_total): void { 
        $this->montant_total = $montant_total; 
    }

    public function getMontantVerse(): float { 
        return $this->montant_verse; 
    }
    public function setMontantVerse(float $montant_verse): void { 
        $this->montant_verse = $montant_verse; 
    }

    public function getModeReglement(): ?string { 
        return $this->mode_reglement; 
    }
    public function setModeReglement(?string $mode_reglement): void { 
        $this->mode_reglement = $mode_reglement; 
    }

    public function getStatut(): string { 
        return $this->statut; }
    public function setStatut(string $statut): void { 
        $this->statut = $statut;
    }

    public function getDateVente(): string { 
        return $this->date_vente; 
    }
    public function setDateVente(string $date_vente): void { 
        $this->date_vente = $date_vente; 
    }

    public function getDateEcheance(): ?string { 
        return $this->date_echeance; 
    }
    public function setDateEcheance(?string $date_echeance): void { 
        $this->date_echeance = $date_echeance; 
    }

    public function getUtilisateur(): ?Utilisateur { 
        return $this->utilisateur; 
    }
    public function setUtilisateur(?Utilisateur $utilisateur): void { 
        $this->utilisateur = $utilisateur; 
    }

    public function getClient(): ?Client { 
        return $this->client; 
    }
    public function setClient(?Client $client): void { 
        $this->client = $client; 
    }

    public function getLignes(): array { 
        return $this->lignes; 
    }
    public function setLignes(array $lignes): void { 
        $this->lignes = $lignes; 
    }

    public function addLigne($ligne): void {
        $this->lignes[] = $ligne;
        $this->montant_total += $ligne->getSousTotal();
    }
}

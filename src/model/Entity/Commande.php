<?php

class Commande {
    private ?int $id;
    private string $numeroFacture;
    private float $montantTotal;
    private float $montantVerse;
    private string $modeReglement;
    private string $statut;
    private string $dateVente;
    private string $dateEcheance;
    private int $utilisateurId;
    private int $clientId;

    public function __construct(?int $id, string $numeroFacture, float $montantTotal, float $montantVerse, string $modeReglement, string $statut, string $dateVente, string $dateEcheance, int $utilisateurId, int $clientId) {
        $this->id = $id;
        $this->numeroFacture = $numeroFacture;
        $this->montantTotal = $montantTotal;
        $this->montantVerse = $montantVerse;
        $this->modeReglement = $modeReglement;
        $this->statut = $statut;
        $this->dateVente = $dateVente;
        $this->dateEcheance = $dateEcheance;
        $this->utilisateurId = $utilisateurId;
        $this->clientId = $clientId;
    }

    public function getId(): ?int { 
        
     return $this->id; 
    }
    public function getNumeroFacture(): string { 
        return $this->numeroFacture; 
    }
    public function getMontantTotal(): float { 
        return $this->montantTotal; 
    }
    public function getMontantVerse(): float { 
        return $this->montantVerse; 
    }
    public function getModeReglement(): string { 
         return $this->modeReglement; 
    }
    public function getStatut(): string { 
         return $this->statut; 
    }
    public function getDateVente(): string { 
         return $this->dateVente; 
    }
    public function getDateEcheance(): string { 
         return $this->dateEcheance; 
    }
    public function getUtilisateurId(): int { 
         return $this->utilisateurId;
    }
    public function getClientId(): int { 
         return $this->clientId; 
    }
}

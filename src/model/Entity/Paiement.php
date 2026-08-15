<?php

class Paiement {
    private ?int $id;
    private float $montant;
    private string $datePaiement;
    private string $reference;
    private int $detteId;
    private int $modePaiementId;
    private int $utilisateurId;

    public function __construct(?int $id, float $montant, string $datePaiement, string $reference, int $detteId, int $modePaiementId, int $utilisateurId) {
        $this->id = $id;
        $this->montant = $montant;
        $this->datePaiement = $datePaiement;
        $this->reference = $reference;
        $this->detteId = $detteId;
        $this->modePaiementId = $modePaiementId;
        $this->utilisateurId = $utilisateurId;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getMontant(): float { 
        return $this->montant; 
    }
    public function getDatePaiement(): string { 
        return $this->datePaiement; 
    }
    public function getReference(): string { 
        return $this->reference; 
    }
    public function getDetteId(): int { 
        return $this->detteId; 
    }
    public function getModePaiementId(): int { 
        return $this->modePaiementId; 
    }
    public function getUtilisateurId(): int { 
        return $this->utilisateurId; 
    }
}

<?php
require_once __DIR__ . '/Dette.php';
require_once __DIR__ . '/Utilisateur.php';

class Paiement {
    private ?int $id;
    private float $montant;
    private string $date_paiement;
    private string $reference;
    
    private int $detteId;
    private ?Dette $dette = null;
    
    private int $modePaiementId;
    
    private ?int $utilisateurId;
    private ?Utilisateur $utilisateur = null;

    public function __construct(float $montant, string $reference, int $detteId, int $modePaiementId, ?int $utilisateurId = null, ?string $date_paiement = null, ?int $id = null) {
        $this->id = $id;
        $this->montant = $montant;
        $this->reference = $reference;
        $this->detteId = $detteId;
        $this->modePaiementId = $modePaiementId;
        $this->utilisateurId = $utilisateurId;
        $this->date_paiement = $date_paiement ?: date('Y-m-d');
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getMontant(): float { 
        return $this->montant; 
    }
    public function setMontant(float $montant): void { 
        $this->montant = $montant; 
    }

    public function getDatePaiement(): string { 
        return $this->date_paiement; 
    }
    public function setDatePaiement(string $date_paiement): void { 
        $this->date_paiement = $date_paiement; 
    }

    public function getReference(): string { 
        return $this->reference; 
    }
    public function setReference(string $reference): void { 
        $this->reference = $reference; 
    }

    public function getDetteId(): int { 
        return $this->detteId; 
    }
    public function setDetteId(int $detteId): void { 
        $this->detteId = $detteId; 
    }

    public function getDette(): ?Dette { 
        return $this->dette; 
    }
    public function setDette(?Dette $dette): void { 
        $this->dette = $dette; 
    }

    public function getModePaiementId(): int { 
        return $this->modePaiementId; 
    }
    public function setModePaiementId(int $modePaiementId): void { 
        $this->modePaiementId = $modePaiementId; 
    }

    public function getUtilisateurId(): ?int { 
        return $this->utilisateurId; 
    }
    public function setUtilisateurId(?int $utilisateurId): void { 
        $this->utilisateurId = $utilisateurId; 
    }

    public function getUtilisateur(): ?Utilisateur { 
        return $this->utilisateur; 
    }
    public function setUtilisateur(?Utilisateur $utilisateur): void { 
        $this->utilisateur = $utilisateur; 
    }
}

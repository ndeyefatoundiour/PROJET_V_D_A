<?php
require_once __DIR__ . '/Client.php';
require_once __DIR__ . '/Commande.php';

class Dette {
    private ?int $id;
    private string $ref;
    private float $montant_initial;
    private float $montant_verse;
    private float $montant_restant;
    private ?string $date_echeance;
    private string $statut;
    private ?Client $client = null;
    private ?Commande $commande = null;

    public function __construct(string $ref, float $montant_initial, int $clientId, ?int $commandeId = null, float $montant_verse = 0.0, ?string $date_echeance = null, string $statut = 'NON_PAYEE', ?int $id = null) {
        $this->id = $id;
        $this->ref = $ref;
        $this->montant_initial = $montant_initial;
        $this->montant_verse = $montant_verse;
        $this->montant_restant = $montant_initial - $montant_verse;
        $this->date_echeance = $date_echeance;
        $this->statut = $statut;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function getRef(): string { 
        return $this->ref; 
    }
    public function setRef(string $ref): void { 
        $this->ref = $ref; 
    }

    public function getMontantInitial(): float { 
        return $this->montant_initial; 
    }
    public function setMontantInitial(float $montant_initial): void { 
        $this->montant_initial = $montant_initial; $this->montant_restant = $this->montant_initial - $this->montant_verse; 
    }

    public function getMontantVerse(): float { 
        return $this->montant_verse; 
    }
    public function setMontantVerse(float $montant_verse): void { 
        $this->montant_verse = $montant_verse; $this->montant_restant = $this->montant_initial - $this->montant_verse; 
        }

    public function getMontantRestant(): float { 
        return $this->montant_restant; 
    }

    public function getDateEcheance(): ?string { 
        return $this->date_echeance; 
    }
    public function setDateEcheance(?string $date_echeance): void { 
        $this->date_echeance = $date_echeance; 
    }

    public function getStatut(): string { 
        return $this->statut; 
    }
    public function setStatut(string $statut): void { 
        $this->statut = $statut; 
    }

    public function getClient(): ?Client { 
        return $this->client; 
    }
    public function setClient(?Client $client): void { 
        $this->client = $client; 
    }

    public function getCommande(): ?Commande { 
        return $this->commande; 
    }
    public function setCommande(?Commande $commande): void { 
        $this->commande = $commande; 
    }
}

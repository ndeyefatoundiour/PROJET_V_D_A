<?php

class Dette {
    private ?int $id;
    private string $ref;
    private float $montantInitial;
    private float $montantVerse;
    private float $montantRestant;
    private string $dateEcheance;
    private string $statut;
    private int $clientId;
    private int $commandeId;

    public function __construct(?int $id, string $ref, float $montantInitial, float $montantVerse, float $montantRestant, string $dateEcheance, string $statut, int $clientId, int $commandeId) {
        $this->id = $id;
        $this->ref = $ref;
        $this->montantInitial = $montantInitial;
        $this->montantVerse = $montantVerse;
        $this->montantRestant = $montantRestant;
        $this->dateEcheance = $dateEcheance;
        $this->statut = $statut;
        $this->clientId = $clientId;
        $this->commandeId = $commandeId;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getRef(): string { 
        return $this->ref; 
    }
    public function getMontantInitial(): float { 
        return $this->montantInitial; 
    }
    public function getMontantVerse(): float { 
        return $this->montantVerse; 
    }
    public function getMontantRestant(): float { 
        return $this->montantRestant; 
    }
    public function getDateEcheance(): string { 
        return $this->dateEcheance; 
    }
    public function getStatut(): string { 
        return $this->statut; 
    }
    public function getClientId(): int { 
        return $this->clientId; 
    }
    public function getCommandeId(): int { 
        return $this->commandeId; 
    }
}

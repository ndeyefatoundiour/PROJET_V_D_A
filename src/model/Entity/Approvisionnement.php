<?php

class Approvisionnement {
    private ?int $id;
    private string $referenceBl;
    private float $coutTotal;
    private string $dateAppro;
    private string $dateReception;
    private string $statut;
    private int $fournisseurId;
    private int $utilisateurId;

    public function __construct(?int $id, string $referenceBl, float $coutTotal, string $dateAppro, string $dateReception, string $statut, int $fournisseurId, int $utilisateurId) {
        $this->id = $id;
        $this->referenceBl = $referenceBl;
        $this->coutTotal = $coutTotal;
        $this->dateAppro = $dateAppro;
        $this->dateReception = $dateReception;
        $this->statut = $statut;
        $this->fournisseurId = $fournisseurId;
        $this->utilisateurId = $utilisateurId;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getReferenceBl(): string { 
        return $this->referenceBl; 
    }
    public function getCoutTotal(): float { 
        return $this->coutTotal; 
    }
    public function getDateAppro(): string { 
        return $this->dateAppro; 
    }
    public function getDateReception(): string { 
        return $this->dateReception; 
    }
    public function getStatut(): string { 
        return $this->statut; 
    }
    public function getFournisseurId(): int { 
        return $this->fournisseurId; 
    }
    public function getUtilisateurId(): int { 
        return $this->utilisateurId; 
    }
}

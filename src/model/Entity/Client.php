<?php

class Client {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $telephone;
    private string $email;

    public function __construct(?int $id, string $nom, string $prenom, string $telephone, string $email) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
    }

    public function getId(): ?int { 
        return $this->id; 
    }
    public function getNom(): string { 
        return $this->nom; 
    }
    public function getPrenom(): string { 
        return $this->prenom; 
    }
    public function getTelephone(): string { 
        return $this->telephone; 
    }
    public function getEmail(): string { 
        return $this->email; 
    }
}

<?php

class Utilisateur {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private string $adresse;
    private string $telephone;
    private int $roleId;

    public function __construct(?int $id, string $nom, string $prenom, string $email, string $password, string $adresse, string $telephone, int $roleId) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->roleId = $roleId;
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
    public function getEmail(): string { 
        return $this->email; 
    }
    public function getPassword(): string { 
        return $this->password; 
    }
    public function getAdresse(): string { 
        return $this->adresse; 
    }
    public function getTelephone(): string { 
        return $this->telephone; 
    }
    public function getRoleId(): int { 
        return $this->roleId; 
    }
}

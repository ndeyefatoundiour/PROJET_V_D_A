<?php

require_once dirname(__DIR__) . "/Entity/Client.php";

class ClientRepository{

    private PDO $pdo;

    public function __construct(){

        $this->pdo = Database::connexionDB();
    }

    
    public function insert(Client $client): int{

        $sql = "INSERT INTO client (nom, prenom, telephone, email, limite_credit)
                VALUES(:nom, :prenom, :telephone, :email, :limite_credit)";

        Database::executeUpdate($this->pdo, $sql, [
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'telephone' => $client->getTelephone(),
            'email' => $client->getEmail(),
            'limite_credit' => $client->getLimiteCredit()
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $client->setId($id);
        
        return $id;
    }

   
    public function selectById(int $id): ?Client{

        $sql = "SELECT * FROM client WHERE id = :id";

        $client = Database::executeQuery($this->pdo, $sql, ['id' => $id]);

        if (!$client) return null;
        
        return $this->enObjet($client);
    }

   
       public function selectAll(): array{

        $tableauClients = Database::getAllTable('client');

        $clients = [];

        if (empty($tableauClients)) {
            return $clients;
        }
        
        foreach ($tableauClients as $client) {
            $clients[] = $this->enObjet($client);
        }

        return $clients;
    }


    
    private function enObjet(array $client): Client{

        return new Client(
            $client['nom'],
            $client['prenom'],
            $client['telephone'] ?? null,
            $client['email'] ?? null,
            (float) ($client['limite_credit'] ?? 0.0),
            (int) $client['id']
        );
    }
}

<?php

require_once dirname(__DIR__) . "/Entity/Client.php";

class ClientRepository {

    private static ?PDO $pdo = null;

    private function __construct() {}

    private static function init(): void {
        if (self::$pdo === null) {
            self::$pdo = Database::connexionDB();
        }
    }
    
    public static function insert(Client $client): int {
        
        self::init(); 

        $sql = "INSERT INTO client (nom, prenom, telephone, email, limite_credit)
                VALUES(:nom, :prenom, :telephone, :email, :limite_credit)";

        Database::executeUpdate(self::$pdo, $sql, [
            'nom'           => $client->getNom(),
            'prenom'        => $client->getPrenom(),
            'telephone'     => $client->getTelephone(),
            'email'         => $client->getEmail(),
            'limite_credit' => $client->getLimiteCredit()
        ]);

        $id = (int) self::$pdo->lastInsertId();
        $client->setId($id);
        
        return $id;
    }

   
    public static function selectById(int $id): ?Client {
        self::init();

        $sql = "SELECT * FROM client WHERE id = :id";

        $client = Database::executeQuery(self::$pdo, $sql, ['id' => $id]);

        if (!$client) return null;
        
        return self::enObjet($client);
    }

   
    public static function selectAll(): array {
        $tableauClients = Database::getAllTable('client');

        $clients = [];

        if (empty($tableauClients)) {
            return $clients;
        }
        
        foreach ($tableauClients as $client) {

        $clients[] = self::enObjet($client);
        }

        return $clients;
    }


    private static function enObjet(array $client): Client {
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

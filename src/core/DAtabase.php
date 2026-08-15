<?php

class Database {

    private static ?PDO $connexion = null;

    private function __construct() {}

    public static function connexionDB(): PDO{

        if (self::$connexion === null) {

            try {
                $pdo = new PDO(
                    "pgsql:host=localhost;dbname=gestion_v_d_a;port=5432",
                    "postgres",
                    "ndiour"
                );

                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$connexion = $pdo;

            } catch (Exception $ex) {
                
                    $racineProjet = dirname(dirname(__DIR__));

                    $pdo = new PDO("sqlite:" . $racineProjet . "/erp.db");

                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $pdo->exec("PRAGMA foreign_keys = ON;");

                    self::$connexion = $pdo;
            }
        }

        return self::$connexion;
    }

    
    public static function deconnecteDB(): void{
        self::$connexion = null;
    }

    
    public static function query(PDO $pdo, string $sql, bool $single = true): array|false{
        $query = $pdo->query($sql);
        return $single ? $query->fetch() : $query->fetchAll();
    }

  
    public static function prepare(PDO $pdo, string $sql, array $datas = []): PDOStatement{
        $statement = $pdo->prepare($sql);
        $statement->execute($datas);
        return $statement;
    }

  
    public static function executeQuery(PDO $pdo, string $sql, array $datas = [], bool $single = true): array|false{
        $statement = self::prepare($pdo, $sql, $datas);
        return $single ? $statement->fetch() : $statement->fetchAll();
    }

   
    public static function executeUpdate(PDO $pdo, string $sql, array $datas = []): int|string{
        $statement = self::prepare($pdo, $sql, $datas);

        if (str_starts_with(strtoupper(trim($sql)), "INSERT")) {
            return $pdo->lastInsertId();
        }

        return $statement->rowCount();
    }

    
    public static function getAllTable(string $tablename): array{
        
        $pdo = self::connexionDB();

        $sql = "SELECT * FROM {$tablename}";
        
        $result = self::query($pdo, $sql, false);
        
        return is_array($result) ? $result : [];
    }
}

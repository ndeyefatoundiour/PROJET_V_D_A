<?php

class Database{

    private static ?PDO $connexion = null;

    private function __construct()
    {
    }

    public static function connexionDB(): PDO{

        if (self::$connexion === null) {

            try {

                $pdo = new PDO(
                    "pgsql:host=localhost;dbname=gestion_v_d_a;port=5432",
                    "postgres",
                    "ndiour"
                );

                $pdo->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

                $pdo->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                self::$connexion = $pdo;

            } catch (Exception $ex) {

                $pdo = new PDO("sqlite:erp.db");

                $pdo->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

                $pdo->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                $pdo->exec("PRAGMA foreign_keys = ON");

                self::$connexion = $pdo;
            }

        }

        return self::$connexion;
    }
}
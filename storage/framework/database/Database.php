<?php

namespace framework\database;

use PDO;
use PDOException;

class Database
{
    static PDO $pdo;
    static bool $init = false;

    static function query(Query $query): array
    {
        self::init();
        try {
            if (!empty($query->parameters)) {
                $stmt = self::$pdo->prepare($query->query);
                $values = array_values($query->parameters);
                $stmt->execute([...$values]);
            } else {
                $stmt = self::$pdo->query($query->query, PDO::FETCH_ASSOC);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
        }
        die();
    }

    private static function init(): void
    {
        if (self::$init)
            return;
        $host = env("DB_HOST");
        $dbname = env("DB_NAME");

        try {
            static::$pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                env("DB_USER"),
                env("DB_PASS"),
            );
        } catch (PDOException $e) {

        }
        self::$init = true;
    }
}
<?php

namespace framework\database;

use PDO;

class Database
{
    static PDO $pdo;
    static bool $init = false;

    /**
     * if not initialized yet, create database connection and save in static attribute
     * has to be done once per request IF DATABASE NEEDED, else no database request is done
     * every public method has to call init() first
     * @return void
     */
    private static function init(): void
    {
        if (self::$init) {
            return;
        }
        $host = env("DB_HOST");
        $dbname = env("DB_NAME");

        try {
            static::$pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                env("DB_USER"),
                env("DB_PASS")
            );
        } catch (\PDOException $e) {
            var_dump($e);
        }
        self::$init = true;
    }

    /**
     * Makes a prepared or unprepared query on the database and returns the resulting rows as array
     * @param Query $query
     * @return array
     */
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
        } catch (\PDOException $e) {
//            var_dump($e);
            echo json_encode($e);
        }
        die();
    }

    /**
     * get the id of the last inserted row or 0 if not existent
     * @return string|false
     */
    static function lastInsertedId(): string|false
    {
        self::init();
        return self::$pdo->lastInsertId();
    }
}

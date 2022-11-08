<?php

namespace app\models;

use framework\Collection;
use framework\database\Database;
use framework\database\Model;
use framework\database\Query;

class NewsModel extends Model
{
    public static string $tableName = "News";

    static function lastFive(): Collection
    {
        $table = self::tableName();
        return self::arrayToModel(Database::query(new Query("SELECT * FROM `$table` ORDER BY `date` DESC LIMIT 5")));
    }
}
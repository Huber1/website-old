<?php

namespace app\models;

use framework\Collection;
use framework\database\Database;
use framework\database\Model;
use framework\database\Query;

class NewsModel extends Model
{
    public static string $tableName = "news";

    static function last(int $count = 5): Collection
    {
        $table = self::tableName();
        return self::arrayToModel(Database::query(new Query("SELECT * FROM `$table` ORDER BY `date` DESC LIMIT $count")));
    }
}
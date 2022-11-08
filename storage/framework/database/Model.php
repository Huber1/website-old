<?php

namespace framework\database;

use framework\Collection;

/**
 * @method static tableName()
 * @property $id
 */
abstract class Model
{
    static string $tableName;

    public static function __callStatic(string $name, array $arguments)
    {
        return match ($name) {
            "tableName" => get_called_class()::$tableName ??
                str_replace("Model", "s", getClassName(get_called_class())),
            default => null,
        };
    }

    protected static function arrayToModel(array|Collection|null $data): Collection|self|null
    {
        if ($data === null) {
            return null;
        } elseif (empty($data)) {
            return new Collection();
        }

        if (isAssociativeArray($data)) {
            $className = get_called_class();
            $model = new $className();
            foreach ($data as $key => $value) {
                $model->$key = $value;
            }
            return $model;
        } else {
            $models = new Collection();
            foreach ($data as $item) {
                $models->add(self::arrayToModel($item));
            }
            return $models;
        }
    }

    static function all(): Collection
    {
        $table = self::tableName();
        return self::arrayToModel(Database::query(new Query("SELECT * FROM `$table`")));
    }

    static function findById($id): ?self
    {
        $table = self::tableName();
        $model = self::arrayToModel(
            Database::query(
                new Query("SELECT * FROM `$table` WHERE `id` = (?) LIMIT 1", ["id" => $id])
            )
        );
        return $model->first();
    }

    static function where($condition, $value): Collection
    {
        $table = self::tableName();
        return self::arrayToModel(
            Database::query(
                new Query("SELECT * FROM `$table` WHERE `$condition` = (?)", [$condition => $value])
            )
        );
    }

    function delete(): void
    {
        $table = self::tableName();
        Database::query(
            new Query("DELETE FROM `$table` WHERE `id` = (?)", [
                "id" => $this->id,
            ])
        );
    }

    function json(): string
    {
        return json_encode($this);
    }
}

<?php
namespace App\Services\DB;
/**
 * @method static self insert(array $params)
 * @method static self where(string $column, string $operator, string $value, string $columns = "*")
 */
class DBService{
    protected static string $table = "";
    public static function __callStatic($method, $args)
    {
        $table = property_exists(static::class, 'table') ? static::$table : '';
        $mySqlQueryBuild = new MySqlQueryBuildService($table);
        return $mySqlQueryBuild->$method(...$args);
    }
}
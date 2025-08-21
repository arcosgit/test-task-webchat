<?php
namespace App\Services\DB;

use PDO;
use PDOException;

class MySqlQueryBuildService{
    private string $query= "";
    private string $queryParam = "";
    public function __construct(private string $table = ""){}
    private function connection(): PDO{
        try{
        $config = require __DIR__ . "/../../../config/database.php";
        return new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
       $config['username'],
       $config['password'],
            );
        } catch(PDOException $e){
            die("Ошибка:" . $e->getMessage());
        }
    }
    public function where(string $column, string $operator, string $value, string $columns = "*"): array
    {
        $stmt = $this->connection()->prepare("SELECT $columns FROM {$this->table} WHERE $column $operator ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function insert(array $params)
    {
        $keys = implode(", ", array_keys($params));
        $prepareValues = [];
        foreach ($params as $item) {
            array_push($prepareValues, "?");
        }
        try{
            $stmt = $this->connection()->prepare("INSERT INTO {$this->table} ($keys) VALUES (" . implode(", ", $prepareValues) . ")");
            $stmt->execute(array_values($params));
            return true;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
<?php
namespace App\Services\DB;

use PDO;
use PDOException;

class MySqlQueryBuildService{
    private string $query= "";
    private array $queryParam = [];
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

    public function select(string $params = '*'): self
    {
        $this->query = "SELECT $params FROM $this->table ";
        return $this;
    }

    public function where(string $column, string $operator, string $value, string $columns = "*"): self
    {
        if($this->query == ""){
            $sql = "SELECT $columns FROM $this->table WHERE $column $operator ? ";
            $this->query .= $sql;
            $this->queryParam[] = $value;
        } else {
            $sql = "AND $column $operator ? ";
            $this->query .= $sql;
            $this->queryParam[] = $value;
        }
        return $this;
    }

    public function whereOr(string $column, string $operator, string $value): self
    {
        $sql = "OR $column $operator ? ";
        $this->query .= $sql;
        $this->queryParam[] = $value;
        return $this;
    }
    public function insert(array $params): bool
    {
        $keys = implode(", ", array_keys($params));
        $prepareValues = array_fill(0, count($params), "?");
        try{
            $stmt = $this->connection()->prepare("INSERT INTO $this->table ($keys) VALUES (" . implode(", ", $prepareValues) . ")");
            $stmt->execute(array_values($params));
            return true;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function join(string $relation_table, string $on, string $join = 'INNER'): self
    {
        $this->query .= "$join JOIN $relation_table ON $on ";
        return $this;
    }

    public function delete(string $column, string $operator, string $value): bool
    {
        $stmt = $this->connection()->prepare("DELETE FROM $this->table WHERE $column $operator ?");
        $stmt->execute([$value]);
        return true;
    }

    public function get(): array
    {
        $stmt = $this->connection()->prepare($this->query);
        $stmt->execute($this->queryParam);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
<?php

namespace App\Core;

use PDO;

class DB
{
    private static ?DB $instance = null;
    private PDO $pdo;

    private string $table;
    private array $conditions = [];
    private array $selectColumns = ['*'];
    private array $params = [];
    private array $orderBy = [];

    private bool $isGrouped = false;

    private function __construct()
    {
        try {
            // Get database credentials
            $dbHost     = Env::get('DB_HOST', '127.0.0.1');
            $dbPort     = Env::get('DB_PORT', '3306');
            $dbName     = Env::get('DB_DATABASE', 'test');
            $dbUser     = Env::get('DB_USERNAME', 'root');
            $dbPassword = Env::get('DB_PASSWORD', '');

            $this->pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

            // Set default PDO options
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Instance of current class
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Database query method
     *
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getInstance()->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Insert data to a table
     *
     * @param string $table
     * @param array $data
     * @return int|null
     */
    public function insert(string $table, array $data): ?int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(array_values($data))) {
            return (int) $this->pdo->lastInsertId();
        }

        return null;
    }

    /**
     * Update table data
     *
     * @param string $table
     * @param integer $id
     * @param array $data
     * @param string $primaryKey
     * @return boolean
     */
    public function update(string $table, int $id, array $data, string $primaryKey = 'id'): bool
    {
        $columns = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $sql = "UPDATE $table SET $columns WHERE $primaryKey = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([...array_values($data), $id]);
    }

    /**
     * Find table data using primary key
     *
     * @param string $table
     * @param integer $id
     * @param string $primaryKey
     * @return array|null
     */
    public function find(string $table, int $id, string $primaryKey = 'id'): ?array
    {
        $sql = "SELECT * FROM $table WHERE $primaryKey = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Select all data from a table
     *
     * @param string $table
     * @return array
     */
    public function getAll(string $table): array
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Delete a table row
     *
     * @param string $table
     * @param integer $id
     * @param string $primaryKey
     * @return boolean
     */
    public function delete(string $table, int $id, string $primaryKey = 'id'): bool
    {
        $sql = "DELETE FROM $table WHERE $primaryKey = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }



    /**
     * Query builder method to select table
     *
     * @param string $table
     * @return self
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Query builder method to add where condition
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return self
     */
    public function where(string $field, string $operator, $value): self
    {
        $condition = "$field $operator ?";
        $this->addCondition($condition, 'AND', $value);
        return $this;
    }

    /**
     * Query builder method to set or where condition
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return self
     */
    public function orWhere(string $field, string $operator, $value): self
    {
        $condition = "$field $operator ?";
        $this->addCondition($condition, 'OR', $value);
        return $this;
    }

    /**
     * Method to add condtions dynamically to array
     * Ready condition based on methods like where, orWhere, when, etc.
     *
     * @param string $condition
     * @param string $type
     * @param mixed $value
     * @return void
     */
    private function addCondition(string $condition, string $type, $value): void
    {
        if (!empty($this->conditions)) {
            $this->conditions[] = $type;
        }

        // add start parenthesis to for query grouping
        if ($this->isGrouped) {
            $this->conditions[] = '(' . $condition;
            $this->isGrouped = false;
        } else {
            $this->conditions[] = $condition;
        }

        $this->params[] = $value;
    }

    /**
     * Query builder method to add query group
     *
     * @param boolean $condition
     * @param callable $callback
     * @return self
     */
    public function when(bool $condition, callable $callback): self
    {
        if ($condition) {
            $this->startGroup();    // Open a new group
            $callback($this);
            $this->endGroup();      // Close the group after callback
        }
        return $this;
    }

    /**
     * Query group start method
     *
     * @return void
     */
    private function startGroup(): void
    {
        $this->isGrouped = true;
    }

    /**
     * Query group end method
     *
     * @return void
     */
    private function endGroup(): void
    {
        $this->conditions[] = ')'; // Add a closing parenthesis
    }

    /**
     * Query builder method to add where in condition
     *
     * @param string $field
     * @param array $values
     * @return self
     */
    public function whereIn(string $field, array $values): self
    {
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $this->conditions[] = "$field IN ($placeholders)";
        $this->params = array_merge($this->params, $values);
        return $this;
    }

    /**
     * Query builder method to add where between condition
     *
     * @param string $field
     * @param mixed $start
     * @param mixed $end
     * @return self
     */
    public function whereBetween(string $field, $start, $end): self
    {
        $this->conditions[] = "$field BETWEEN ? AND ?";
        $this->params[] = $start;
        $this->params[] = $end;
        return $this;
    }

    /**
     * Query builder method to select columns
     *
     * @param array $columns
     * @return self
     */
    public function select(array $columns): self
    {
        $this->selectColumns = $columns;
        return $this;
    }

    /**
     * Query builder method to select more columns
     *
     * @param array $columns
     * @return self
     */
    public function addSelect(array $columns): self
    {
        $this->selectColumns = array_merge($this->selectColumns, $columns);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'ASC';
        }

        $this->orderBy[] = "$column $direction";
        return $this;
    }

    /**
     * Get all data from query builder
     *
     * @return array
     */
    public function get(): array
    {
        $columns = implode(', ', $this->selectColumns); // Prepare column list
        $sql = "SELECT {$columns} FROM {$this->table}";

        // Add conditions if any
        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' ', $this->conditions);
        }

        // Order by clauses
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }

        $stmt = self::query($sql, $this->params);

        $this->reset();

        return $stmt->fetchAll();
    }

    /**
     * Reset query builder conditions
     *
     * @return void
     */
    private function reset(): void
    {
        $this->conditions = [];
        $this->selectColumns = ['*'];
        $this->params = [];
        $this->orderBy = [];
    }

    /**
     * Get sql from query builder
     *
     * @return string
     */
    public function toSql(): string
    {
        $columns = implode(', ', $this->selectColumns); // Prepare column list
        $sql = "SELECT {$columns} FROM {$this->table}";

        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' ', $this->conditions);
        }

        return $sql;
    }

    /**
     * Get SQL with params substituted for debugging purposes.
     *
     * @return string
     */
    public function getSqlWithParams(): string
    {
        // Clone the query so we don't modify the original
        $sql = $this->toSql();

        // Iterate over parameters and replace placeholders with actual values
        foreach ($this->params as $key => $value) {
            $sql = preg_replace('/\?/', $this->quote($value), $sql, 1);
        }

        return $sql;
    }

    /**
     * Add single quote in both side to a value
     *
     * @param mixed $value
     * @return string
     */
    private function quote($value): string
    {
        return "'$value'";
    }
}

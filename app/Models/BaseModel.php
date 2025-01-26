<?php

namespace App\Models;

use App\Core\DB;
use App\Contracts\ModelInterface;

abstract class BaseModel implements ModelInterface
{
    protected $table;
    protected $primaryKey = 'id';
    protected array $fillable = [];
    protected array $attributes = [];

    // Magic getter for dynamic properties
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        throw new \Exception("Property {$key} does not exist.");
    }

    // Magic setter for dynamic properties
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    // Check if a property is set
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }


    /**
     * Get table name
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }


    /**
     * Get primary key name
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * Filter fillable fields
     *
     * @param array $data
     * @return array
     */
    protected function filterFillable(array $data): array
    {
        return array_filter(
            $data,
            fn($key) => in_array($key, $this->fillable),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Insert data to table
     *
     * @param array $data
     * @return boolean
     */
    public function insert(array $data): bool
    {
        $data = $this->filterFillable($data);
        $db = DB::getInstance();
        return $db->insert($this->table, $data);
    }

    /**
     * Update table data
     *
     * @param integer $id
     * @param array $data
     * @return boolean
     */
    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        $db = DB::getInstance();
        return $db->update($this->table, $id, $data, $this->primaryKey);
    }

    /**
     * Find table data
     *
     * @param integer $id
     * @return self|null
     */
    public function find(int $id): ?self
    {
        $db = DB::getInstance();
        $result = $db->find($this->table, $id, $this->primaryKey);

        if (!$result) {
            return null;
        }

        $instance = new static();

        foreach ($result as $key => $value) {
            $instance->$key = $value;
        }

        return $instance;
    }

    /**
     * Delete data from table (model)
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        $db = DB::getInstance();
        return $db->delete($this->table, $id, $this->primaryKey);
    }

    /**
     * Get all data from table (model)
     *
     * @return array
     */
    public function getAll(): array
    {
        $db = DB::getInstance();
        return $db->getAll($this->table);
    }



    /**
     * Set the table dynamically for query builder
     *
     * @param string|null $table
     * @return self
     */
    public function table(string $table = null): self
    {
        if ($table) {
            $this->table = $table;
        }
        return $this;
    }

    /**
     * Add 'where' condition to query builder
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return self
     */
    public function where(string $field, string $operator, $value): self
    {
        DB::getInstance()->table($this->table)->where($field, $operator, $value);
        return $this;
    }

    /**
     * Add 'or where' condition to query builder
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return self
     */
    public function orWhere(string $field, string $operator, $value): self
    {
        DB::getInstance()->table($this->table)->orWhere($field, $operator, $value);
        return $this;
    }


    /**
     * Add 'where in' condition to query builder
     *
     * @param string $field
     * @param array $values
     * @return self
     */
    public function whereIn(string $field, array $values): self
    {
        DB::getInstance()->table($this->table)->whereIn($field, $values);
        return $this;
    }

    /**
     * Add 'where between' condition to query builder
     *
     * @param string $field
     * @param [type] $start
     * @param [type] $end
     * @return self
     */
    public function whereBetween(string $field, $start, $end): self
    {
        DB::getInstance()->table($this->table)->whereBetween($field, $start, $end);
        return $this;
    }

    /**
     * Get all data from table using query builder
     *
     * @return array
     */
    public function get(): array
    {
        return DB::getInstance()
            ->table($this->table)
            ->get();
    }
}

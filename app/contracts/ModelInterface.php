<?php

namespace App\Contracts;

interface ModelInterface
{
    public function insert(array $data): ?int;
    public function update(array $data, ?int $id = null): bool;
    public function find(int $id): ?self;
    public function delete(int $id): bool;
    public function getAll(): array;

    // methods for advanced query building
    public function table(string $table): self;
    public function where(string $field, string $operator, $value): self;
    public function orWhere(string $field, string $operator, $value): self;
    public function whereIn(string $field, array $values): self;
    public function whereBetween(string $field, $start, $end): self;
    // public function when(bool $condition, callable $callback): self;
    public function get(): array;
}

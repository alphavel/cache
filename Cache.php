<?php

namespace Alphavel\Cache;

use Swoole\Table;

class Cache
{
    private Table $table;

    private static ?Cache $instance = null;

    public function __construct(int $size = 1024, int $valueSize = 4096)
    {
        $this->table = new Table($size);
        $this->table->column('value', Table::TYPE_STRING, $valueSize);
        $this->table->column('expires', Table::TYPE_INT, 8);
        $this->table->create();
    }

    public static function getInstance(int $size = 1024, int $valueSize = 4096): self
    {
        if (self::$instance === null) {
            self::$instance = new self($size, $valueSize);
        }

        return self::$instance;
    }

    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $expires = $ttl > 0 ? time() + $ttl : 0;

        return $this->table->set($key, [
            'value' => json_encode($value),
            'expires' => $expires,
        ]);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $row = $this->table->get($key);

        if (! $row) {
            return $default;
        }

        if ($row['expires'] > 0 && $row['expires'] < time()) {
            $this->delete($key);

            return $default;
        }

        return json_decode($row['value'], true) ?? $default;
    }

    public function has(string $key): bool
    {
        $row = $this->table->get($key);

        if (! $row) {
            return false;
        }

        if ($row['expires'] > 0 && $row['expires'] < time()) {
            $this->delete($key);

            return false;
        }

        return true;
    }

    public function delete(string $key): bool
    {
        return $this->table->del($key);
    }

    public function clear(): bool
    {
        foreach ($this->table as $key => $row) {
            $this->table->del($key);
        }

        return true;
    }

    public function remember(string $key, int $ttl, callable $callback): mixed
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        $value = $callback();
        $this->set($key, $value, $ttl);

        return $value;
    }

    public function pull(string $key, mixed $default = null): mixed
    {
        $value = $this->get($key, $default);
        $this->delete($key);

        return $value;
    }

    public function increment(string $key, int $amount = 1): int
    {
        $value = (int) $this->get($key, 0);
        $value += $amount;
        $this->set($key, $value, 0);

        return $value;
    }

    public function decrement(string $key, int $amount = 1): int
    {
        return $this->increment($key, -$amount);
    }

    public function count(): int
    {
        return $this->table->count();
    }
}

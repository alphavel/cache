# Alphavel Cache

> High-performance cache layer with Redis, File, and Memory drivers

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

## ✨ Features

- ⚡ **Multiple drivers** - Redis, File, Memory
- 🔄 **Remember pattern** - Cache with fallback
- ⏰ **TTL support** - Automatic expiration
- 🎯 **Laravel-compatible** - Familiar API
- 🚀 **Swoole-optimized** - Coroutine-safe

## 📦 Installation

```bash
composer require alphavel/cache
```

## ⚙️ Configuration

```env
CACHE_DRIVER=redis

# Redis
REDIS_HOST=localhost
REDIS_PORT=6379
REDIS_PASSWORD=
REDIS_DATABASE=0
```

For Docker: use service name (e.g., `REDIS_HOST=redis`)

## 🚀 Quick Start

```php
use Cache;

// Set
Cache::set('key', 'value', 3600);

// Get
$value = Cache::get('key');

// Remember pattern
$users = Cache::remember('users', 300, fn() => 
    DB::table('users')->get()
);

// Delete
Cache::delete('key');

// Clear all
Cache::flush();
```

## 📚 Documentation

**Full documentation**: https://github.com/alphavel/documentation

- [Getting Started](https://github.com/alphavel/documentation/blob/master/packages/cache/README.md)
- [Drivers](https://github.com/alphavel/documentation/blob/master/packages/cache/drivers.md)
- [Best Practices](https://github.com/alphavel/documentation/blob/master/packages/cache/best-practices.md)

## 📄 License

MIT License

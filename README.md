# Alphavel Cache

Cache package for Alphavel Framework.

## Installation

```bash
composer require alphavel/cache
```

## Configuration

After installation, add these variables to your `.env` file:

```env
CACHE_DRIVER=redis

# Redis Configuration
REDIS_HOST=localhost
REDIS_PORT=6379
REDIS_PASSWORD=
REDIS_DATABASE=0
```

For Docker environments, update `REDIS_HOST` to match your service name (e.g., `redis`).

You can also use `CACHE_DRIVER=file` for file-based caching (no Redis required).

See `.env.example` in this package for a complete configuration template.

## Documentation

Visit [Alphavel Documentation](https://github.com/alphavel) for complete documentation.

## License

MIT License

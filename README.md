# Mezzio Skeleton and Installer

*Begin developing PSR-15 middleware applications in seconds!*

[mezzio](https://github.com/mezzio/mezzio) builds on
[laminas-stratigility](https://github.com/laminas/laminas-stratigility) to
provide a minimalist PSR-15 middleware framework for PHP with routing, DI
container, optional templating, and optional error handling capabilities.

## Development Environment

This project uses Docker for development to ensure consistent environments. The setup includes:

- PHP 8.4 FPM Alpine
- Nginx web server
- PostgreSQL database connection support
- Development tools (PHPUnit, PHPCS, Psalm)

### Getting Started

1. Start the development environment:
```bash
docker compose up -d
```

2. Install dependencies:
```bash
docker compose exec php composer install
```

3. Copy database configuration:
```bash
cp config/autoload/database.local.php.dist config/autoload/database.local.php
```

4. Access the application:
```bash
# The application will be available at:
http://localhost:8787
```

### Development Tools

All development tools run inside the Docker container to ensure consistency:

```bash
# Run all checks (code style, static analysis, and tests)
docker compose exec php composer check

# Individual tools
docker compose exec php composer cs-check     # Code style check
docker compose exec php composer cs-fix       # Code style fix
docker compose exec php composer test         # Unit tests
docker compose exec php composer static-analysis  # Static analysis
```

### Development Mode

This project includes [laminas-development-mode](https://github.com/laminas/laminas-development-mode).

```bash
# Enable development mode
docker compose exec php composer development-enable

# Disable development mode
docker compose exec php composer development-disable

# Check status
docker compose exec php composer development-status
```

**Note:** Development mode enables:
- Detailed error pages with Whoops
- Configuration caching disabled
- Development-specific middleware

## Configuration Caching

By default, the skeleton will create a configuration cache in
`data/config-cache.php`. When in development mode, the configuration cache is
disabled, and switching in and out of development mode will remove the
configuration cache.

You may need to clear the configuration cache in production when deploying if
you deploy to the same directory. You may do so using the following:

```bash
docker compose exec php composer clear-config-cache
```

## Contributing

Before contributing read [the contributing guide](https://github.com/mezzio/.github/blob/master/CONTRIBUTING.md).

## Troubleshooting

If you encounter issues:

1. Ensure Docker is running and containers are healthy:
```bash
docker compose ps
```

2. Check container logs:
```bash
docker compose logs
```

3. Try rebuilding the containers:
```bash
docker compose down
docker compose up -d --build
```

4. Clear Composer's cache:
```bash
docker compose exec php composer clear-cache
```

For more detailed troubleshooting, refer to the [Mezzio documentation](https://docs.mezzio.dev/).

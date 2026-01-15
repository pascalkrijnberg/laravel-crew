# Laravel Crew

A collection of Claude Code agents for the TALL stack, powered by Laravel Boost.

> Based on [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)

## Installation

### From GitHub

Add to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/pascalkrijnberg/laravel-crew"
        }
    ],
    "require-dev": {
        "pascalkrijnberg/laravel-crew": "dev-main"
    }
}
```

Then run:

```bash
composer update pascalkrijnberg/laravel-crew
```

### From local path (for development)

Add to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/laravel-crew"
        }
    ],
    "require-dev": {
        "pascalkrijnberg/laravel-crew": "@dev"
    }
}
```

Then run:

```bash
composer update pascalkrijnberg/laravel-crew
```

## Usage

Agents are automatically synced when `boost:update` runs. You can also manually sync:

```bash
php artisan crew:sync         # Sync new agents only
php artisan crew:sync --force # Overwrite all agents
```

## Credits

- **Original Author:** [Mischa Sigtermans](https://github.com/mischasigtermans)
- **Original Repository:** [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)

## License

MIT License - See [LICENSE](LICENSE) for details.

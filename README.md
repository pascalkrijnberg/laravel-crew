# Laravel Crew

A collection of Claude Code agents for the TALL stack, powered by Laravel Boost.

> Based on [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)

## Installation

```bash
composer require pascalkrijnberg/laravel-crew --dev
```

## Usage

Agents are automatically synced when `boost:update` runs. You can also manually sync:

```bash
php artisan altitude:sync         # Sync new agents only
php artisan altitude:sync --force # Overwrite all agents
```

## Credits

- **Original Author:** [Mischa Sigtermans](https://github.com/mischasigtermans)
- **Original Repository:** [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)

## License

MIT License - See [LICENSE](LICENSE) for details.

# Laravel Altitude (Fork)

> **This is a fork of [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)**

Claude Code agents for the TALL stack, powered by Laravel Boost.

## Why This Fork?

This fork modifies the sync behavior to preserve local customizations. The original package overwrites agent files when `boost:update` runs. This fork removes the `--force` flag from the auto-sync hook, allowing you to customize agent and command files without them being overwritten.

## Installation

```bash
composer require pascalkrijnberg/laravel-altitude --dev
```

## Usage

See the [original documentation](https://github.com/mischasigtermans/laravel-altitude) for usage instructions.

## Changes From Original

- Removed `--force` from the boost hook to preserve local file customizations
- Files are only synced if they don't already exist (use `php artisan altitude:sync --force` to explicitly overwrite)

## Credits

- **Original Author:** [Mischa Sigtermans](https://github.com/mischasigtermans)
- **Original Repository:** [mischasigtermans/laravel-altitude](https://github.com/mischasigtermans/laravel-altitude)

## License

MIT License - See [LICENSE](LICENSE) for details.

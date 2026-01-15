---
description: Upgrade Laravel project from Livewire v3 to v4
maintainer: Laravel Crew
---

# Upgrade Livewire - v3 to v4 Migration

Scan, report, and fix breaking changes when upgrading from Livewire v3 to v4.

## Usage

```
/upgrade-livewire [--scan-only]
```

## Arguments

- `--scan-only`: Only scan and report issues without making changes

## Workflow

### 1. Pre-flight Check

```bash
composer show livewire/livewire --format=json
```

- **ABORT if not installed**: "Livewire is not installed in this project"
- **ABORT if already v4+**: "Already on Livewire v4"
- **ABORT if < v3**: "Please upgrade to Livewire v3 first"

### 2. Safety Check

```bash
git status --porcelain
```

- **WARN if uncommitted changes**: Recommend committing or creating upgrade branch first
- Suggest: `git checkout -b livewire-4-upgrade`

### 3. Scan for Breaking Changes

Search for all issues before making any changes:

| Issue | Search Pattern | Severity |
|-------|---------------|----------|
| `wire:scroll` | `wire:scroll` in views | High |
| `wire:transition` modifiers | `wire:transition\.` in views | Medium |
| Unclosed `<livewire:>` tags | `<livewire:[a-z-]+[^/]>` not followed by `</livewire:` | High |
| Old config keys | `'layout'` or `'lazy_placeholder'` in config/livewire.php | High |
| Route::get with Livewire | `Route::get.*::class` in routes/ | Medium |
| Volt imports | `Livewire\\Volt\\Component` | High (if Volt used) |
| Old `stream()` params | `->stream.*to:` in app/ | Medium |
| Old `$wire.$js()` | `\$wire\.\$js\(` in views | Low |
| Livewire hooks | `Livewire.hook\('commit'` or `'request'` | Low |

### 4. Report Findings

Display summary:
```
Livewire v3 → v4 Upgrade Scan
=============================
wire:scroll usage:           3 files
wire:transition modifiers:   1 file
Unclosed livewire tags:      5 files
Config keys to rename:       2 keys
Routes to review:            4 routes
Volt imports:                0 files

Total issues: 15
```

If `--scan-only`, stop here.

### 5. Update Composer

```bash
composer require livewire/livewire:^4.0
php artisan optimize:clear
```

### 6. Update Config (config/livewire.php)

**Rename keys:**
- `'layout'` → `'component_layout'`
- `'lazy_placeholder'` → `'component_placeholder'`

**Update layout value:**
- `'components.layouts.app'` → `'layouts::app'`

**Add new options if missing:**
```php
'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],

'component_namespaces' => [
    'layouts' => resource_path('views/layouts'),
    'pages' => resource_path('views/pages'),
],

'make_command' => [
    'type' => 'class',  // Keep v3 behavior
    'emoji' => false,
],

'smart_wire_keys' => true,

'csp_safe' => false,
```

### 7. Apply Automatic Fixes

**wire:scroll → wire:navigate:scroll:**
```
Find:    wire:scroll
Replace: wire:navigate:scroll
```

**wire:transition modifiers (remove all modifiers):**
```
Find:    wire:transition\.[a-z.]+
Replace: wire:transition
```

**Close unclosed livewire tags:**
```blade
<!-- Before -->
<livewire:component-name>

<!-- After -->
<livewire:component-name />
```

**Volt imports (if present):**
```
Find:    use Livewire\Volt\Component;
Replace: use Livewire\Component;
```

### 8. Manual Review Required

These changes need human judgment. List them for the user:

**Routes (recommend Route::livewire):**
```php
// v3 - still works
Route::get('/dashboard', Dashboard::class);

// v4 - recommended
Route::livewire('/dashboard', Dashboard::class);
```

**wire:model on containers (may need .deep):**
```blade
<!-- If wire:model is on a container listening to child inputs -->
<div wire:model="value">
    <input type="text">
</div>

<!-- Add .deep modifier -->
<div wire:model.deep="value">
    <input type="text">
</div>
```

**stream() parameter order:**
```php
// v3
$this->stream(to: '#container', content: 'Hello');

// v4
$this->stream(content: 'Hello', el: '#container');
```

**JavaScript hooks:**
```javascript
// v3
Livewire.hook('commit', ({ respond, succeed, fail }) => { ... })

// v4
Livewire.interceptMessage(({ onFinish, onSuccess, onError }) => { ... })
```

### 9. Post-upgrade Validation

```bash
php artisan test
```

Report test results and any errors.

### 10. Volt Cleanup (if applicable)

If project used Volt:
```bash
rm app/Providers/VoltServiceProvider.php
composer remove livewire/volt
```

Update `bootstrap/providers.php` to remove VoltServiceProvider.

## Breaking Changes Reference

### Config Key Renames
| v3 | v4 |
|----|-----|
| `layout` | `component_layout` |
| `lazy_placeholder` | `component_placeholder` |

### Directive Changes
| v3 | v4 |
|----|-----|
| `wire:scroll` | `wire:navigate:scroll` |
| `wire:transition.opacity` | `wire:transition` (no modifiers) |
| `<livewire:name>` (unclosed) | `<livewire:name />` (must close) |

### New v4 Features Available After Upgrade
- Single-file components (`php artisan make:livewire name`)
- `Route::livewire()` for full-page components
- `defer` attribute for deferred loading
- `@island` for isolated updating regions
- `wire:sort` for drag-and-drop
- `wire:intersect` for viewport detection
- `.async` modifier for fire-and-forget actions
- `.renderless` modifier to skip re-render
- `.preserve-scroll` modifier

## Examples

```
/upgrade-livewire              # Full upgrade with fixes
/upgrade-livewire --scan-only  # Just scan, no changes
```

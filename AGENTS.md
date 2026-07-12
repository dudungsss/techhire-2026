# TechHire — Agent Guide

## Quick start
```bash
docker compose up -d             # start all services
docker compose exec php bash     # enter PHP container (src/ mounted at /var/www/html)
```

## Key commands (inside container)

| Alias | Command |
|---|---|
| `art` | `php artisan` |
| `migrate` | `php artisan migrate` |
| `fresh` | `php artisan migrate:fresh --seed` |

Custom Artisan:
- `project:init` — `migrate:fresh --force` + `shield:generate --all --panel=admin` + `db:seed --force` + cache clear
- `project:update` — `migrate` + `shield:generate` + cache clear
- `project:cache` — cache refresh (filament + laravel)
- `dev:init` — IDE helper generation

Dev runner: `composer dev` — runs `php artisan serve` + `queue:listen` + `pail` + `npm run dev` concurrently.
Frontend build: `npm run dev` / `npm run build` (Vite + Tailwind CSS 3).

## .env is auto-managed
`docker-entrypoint.sh` **overwrites `.env` on every container restart**. DB: `mariadb:10.11`, host `db`, root password `p455w0rd` (host port `13306`). `.env.example` is stale. `docker-compose.yml` passes `COMPOSE_PROJECT_NAME` and `PROJECT_NAME` env vars used by the entrypoint.

## Architecture
- **Laravel 12** + **Filament 3** admin panel at `/admin` (SPA mode, Montserrat font)
- **No Jetstream/Breeze** — custom `AuthController` handles login/register/logout with role-based redirect
- **Roles** (Spatie Permission): `super_admin`, `admin`, `recruiter`, `pelamar`, `user`
- **Frontend**: Blade + Livewire 3 + Tailwind CSS 3 (no Vue/React). Uses `navigate: true` for SPA nav.
- **DB**: MariaDB via Docker. Session, cache, queue all use `database` driver.
- **Route prefix**: configurable via `ASSET_PREFIX` env var (for subfolder deployment)
- **SSL**: nginx HTTP→HTTPS redirect; self-signed cert in `nginx/ssl/`
- **Auth**: Register assigns `recruiter_status = verified` for recruiters, `null` for pelamar. Admin panel access gated by `is_active` + `super_admin`/`admin` role (`User::canAccessPanel`).
- **Code style**: Laravel Pint with `laravel` preset + custom rules (`pint.json`). Run `./vendor/bin/pint`.
- **Livewire** components hold all feature logic. Controller stubs (`JobController`, `CompanyController`) exist but are unused.

## Key directories
- `app/Livewire/` — Jobs (public listing/detail/apply), Applicant, Recruiter components
- `app/Filament/Admin/` — Admin panel resources (User, Job, Company, Category, Skill, JobApplication)
- `app/Models/` — User, Job, Company, Category, Skill, JobApplication
- `resources/views/` — Layouts, pages, livewire views
- `routes/web.php` — All web routes
- `database/seeders/` — 7 seeders (run in order: Role → User → Category → Skill → Company → Job → Application)

## Models & relationships
- **User** — HasRoles, HasAvatar, FilamentUser. `phone`, `summary`, `cv_path`, `github_url`, `linkedin_url`, `portfolio_url`. Has `company()`, `skills()` (via `user_skill` pivot), `jobApplications()`
- **Job** — belongsTo `Company`, belongsTo `Category`, belongsToMany `Skill` (via `job_skill`), hasMany `JobApplication`. Scope `published()` for `is_published = true`
- **JobApplication** — belongsTo `User`, belongsTo `Job`. Status: pending/reviewed/shortlisted/rejected/accepted. Fields: `cv_path`, `cover_letter`, `experience_summary`, `portfolio_url`, `expected_salary`, `match_score`
- **Skill** — belongsToMany `Job`, belongsToMany `User`. Fields: `name`, `type`
- **Company** — belongsTo `User`, hasMany `Job`. Fields: `name`, `logo_path`, `address`, `description`, `website`, `contact_email`, `contact_phone`
- **Category** — hasMany `Job`. Fields: `name`, `slug`, `description`

## Demo accounts (from seeder)
| Role | Email | Password |
|---|---|---|
| Super Admin | admin@admin.com | password |
| User | user@admin.com | password |
| Recruiter | recruiter@demo.com | password |
| Pelamar | pelamar@demo.com | password |

## Convention notes
- **Routes** use `role:` middleware (Spatie) for gating (e.g., `role:pelamar`, `role:recruiter`). Admin routes handled by Filament panel.
- **Livewire** uses `wire:model.live` for real-time filtering, `wire:submit` for forms.
- **Job slug** auto-generated from title with uniqueness handling in `app/Livewire/Recruiter/JobForm.php`.
- **Storage** disk `public`; applicant CVs stored at `applications/cv/`. Run `artisan storage:link` if missing.
- **Filament** uses Shield for permission-based resource access; panel login is at `/admin`.

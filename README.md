# Crinvyx

Laravel event attendance management application with Arabic (RTL) support, PowerGrid tables, and analysis dashboards.

## Requirements

- PHP 8.2+
- Composer
- Node.js 20+
- MySQL (local) or PostgreSQL (Render deployment)

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configure DB_* in .env
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Default login after seeding: `admin` / `password`

## GitHub

Repository: push to `main` triggers CI (tests + asset build).

## Deploy on Render (recommended)

1. Push this repo to GitHub.
2. Open [Render Dashboard](https://dashboard.render.com/) → **New** → **Blueprint**.
3. Connect the GitHub repository and apply `render.yaml`.
4. Set `APP_URL` to your Render service URL (e.g. `https://crinvyx.onrender.com`).
5. After deploy, log in with `admin` / `password` (seeded on first boot).

Render provisions a free PostgreSQL database automatically via the blueprint.

## Docker

```bash
docker build -t crinvyx .
docker run --rm -p 8000:8000 \
  -e APP_KEY=base64:... \
  -e DB_CONNECTION=mysql \
  -e DB_HOST=host.docker.internal \
  -e DB_DATABASE=crinvyx \
  -e DB_USERNAME=root \
  -e DB_PASSWORD=secret \
  crinvyx
```

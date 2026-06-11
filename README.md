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

**Repository:** https://github.com/Amrmoawad/crinvyx

## Deploy on Render (recommended)

1. Open [Create Blueprint from this repo](https://dashboard.render.com/blueprint/new?repo=https://github.com/Amrmoawad/crinvyx).
2. Connect GitHub if prompted, then click **Apply** / **Deploy Blueprint**.
3. When asked, set `APP_URL` to your Render service URL (e.g. `https://crinvyx.onrender.com`).
4. Wait for the web service and PostgreSQL database to finish provisioning.
5. Log in with `admin` / `password` (seeded on first boot).

> **Note:** Free Render services sleep after inactivity; the first request may take ~30 seconds.

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

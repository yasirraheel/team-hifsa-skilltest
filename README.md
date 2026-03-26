# Team Hifsa Skillset

Laravel 10–based e‑learning platform for publishing courses, lessons, quizzes, and tracking learner progress. Supports enrollment, lesson completion, notes, reviews, and multiple payment gateways (Stripe, Razorpay, CoinGate, etc.), plus Zoom/live session hooks and SMS/voice vendors (Twilio, Vonage) when configured.

## Repository Layout

- `application/` – main Laravel app (HTTP, console, models, migrations, Vite config).
- `assets/` – prebuilt/static frontend assets for the default preset.
- `public/` – web root for the Laravel app.
- `QUEUE_SETUP.md` – notes for queue configuration.

> Tip: all app commands below are run from `application/`.

## Prerequisites

- PHP 8.1+ with extensions commonly required by Laravel (OpenSSL, PDO, Mbstring, Tokenizer, JSON, XML, Ctype, BCMath, GD/Imagick for images).
- Composer
- Node.js 18+ and npm (for Vite)
- A MySQL/MariaDB database (or another DB supported by Laravel) and credentials

## Quick Start

```bash
git clone https://github.com/yasirraheel/team-hifsa-skillset.git
cd team-hifsa-skillset/application

composer install
cp .env.example .env
php artisan key:generate

# set DB_* values in .env, then:
php artisan migrate

# optional: create storage symlink for uploads
php artisan storage:link

# install and build frontend assets
npm install
npm run build  # or `npm run dev` for hot reload

# run the app
php artisan serve
```

## Environment Highlights (`application/.env`)

- `APP_URL`, `APP_ENV`, `APP_DEBUG`
- Database: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Mail: `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`
- Payments (enable only what you use):
  - Stripe: `STRIPE_KEY`, `STRIPE_SECRET`
  - Razorpay: `RAZOR_KEY`, `RAZOR_SECRET`
  - CoinGate: `COINGATE_AUTH_TOKEN`, `COINGATE_ENVIRONMENT`
- Realtime / communications (optional):
  - Zoom: `ZOOM_CLIENT_KEY`, `ZOOM_CLIENT_SECRET`
  - Twilio: `TWILIO_SID`, `TWILIO_TOKEN`, `TWILIO_FROM`
  - Vonage: `VONAGE_KEY`, `VONAGE_SECRET`, `VONAGE_SMS_FROM`
- Filesystem: `FILESYSTEM_DISK` (default `public`)

## Common Tasks

- Run dev server with Vite HMR: `npm run dev` (in one terminal) and `php artisan serve` (in another).
- Cache config for production: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Clear caches: `php artisan optimize:clear`
- Run tests: `php artisan test` or `phpunit`
- Queue workers (if you enable queues): `php artisan queue:work`

## Features at a Glance

- Course catalog with categories, curriculum, and lesson preview/playback.
- Enrollment flow with progress tracking and lesson completion/undo.
- Lesson notes per user, reviews & ratings per course.
- Quizzes per course (see `user.quiz.courseQuiz` route).
- Multiple payment gateway adapters (Stripe, Razorpay, CoinGate) plus classic email/SMS vendors.
- Image handling via Intervention Image; large file uploads via chunked upload package.
- Social login via Laravel Socialite (configure providers in `.env`).

## Deployment Notes

- Serve the `application/public` directory from your web server (`DocumentRoot`).
- Ensure `storage/` and `bootstrap/cache/` are writable by the web user.
- If using queues, set up a process supervisor (systemd) for `php artisan queue:work`.
- Configure HTTPS at the web server/proxy layer; set `APP_URL` to the HTTPS URL.

## Troubleshooting

- **Composer memory issues**: `COMPOSER_MEMORY_LIMIT=-1 composer install`.
- **Missing storage symlink**: run `php artisan storage:link`.
- **Migrations failing**: verify DB credentials and that the DB exists.
- **Assets not updating**: clear Vite/laravel caches (`npm run build`, then `php artisan view:clear`).

---
Maintained on the `main` branch. Open issues/PRs are welcome for bugs or documentation improvements.

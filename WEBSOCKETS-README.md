# WebSockets (Echo / Soketi) — Local & Self-hosted Setup

This project supports real-time broadcasting via the `pusher` broadcast driver.
We provide two self-hosted alternatives that do NOT require changing Composer:

- Soketi (recommended for production)
- Laravel Echo Server (quick dev-friendly approach)

Files added to repo:
- `docker-compose.soketi.yml` — docker compose example for Soketi
- `docker-compose.echo.yml` / `Dockerfile.echo` — docker compose + Dockerfile for laravel-echo-server
- `laravel-echo-server.json` — default config for laravel-echo-server
- `.env.example` updated with `PUSHER_*` examples

Quick start (laravel-echo-server, local host):

1. Build and start the echo server container:

```bash
# stops any host echo processes if running
pkill -f "laravel-echo-server" || true

# build and start the container
docker compose -f docker-compose.echo.yml up -d --build
```

2. Ensure `.env` has the appropriate `PUSHER_*` values (or use `.env.example` defaults):

```dotenv
BROADCAST_CONNECTION=pusher
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
```

3. Build frontend assets and start the app as usual:

```bash
npm ci
npm run build
php artisan serve
```

4. Trigger a test broadcast (from the project root):

```bash
php tools/trigger_soketi_event.php
# expected: Trigger result: (object) array( 'message' => 'ok' )
```

Soketi (alternative):

1. Start Soketi via provided compose file:

```bash
docker compose -f docker-compose.soketi.yml up -d
```

2. Update `.env` to point to Soketi host/port (defaults in `.env.example`).

Notes & troubleshooting:
- If you run into `The app X could not be found.` on Soketi, ensure `SOKETI_APPS` env is configured in `docker-compose.soketi.yml` or register apps via Soketi management API.
- For production, use TLS and reverse proxy (nginx) with proper websocket upgrade headers.

If you want, I can also:
- Build and push a Docker image to your registry (requires credentials), or
- Continue debugging Soketi app registration to make it fully automated.

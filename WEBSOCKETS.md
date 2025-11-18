# WebSockets / Real-time setup

Bu proje için iki yaklaşım desteklenir:

- Hosted Pusher (önerilen, hızlı kurulum)
- Self-hosted laravel-websockets (uyumluluk kontrolü gerekebilir)

## Hosted Pusher (hızlı)

1. Pusher hesabı oluşturun: https://dashboard.pusher.com
2. Uygulama bilgilerinizi alın (app id, key, secret, cluster)
3. `.env` içine aşağıyı ekleyin:

```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=mt1
# Opsiyonel:
# PUSHER_HOST=
# PUSHER_PORT=443
# PUSHER_APP_FORCE_TLS=true
```

4. Frontend tarafında Echo örneği `resources/js/echo-setup.js` dosyasında hazırdır. Derleyin:

```bash
# Vite/Mix örneği
npm install
npm run build
# geliştirme için
npm run dev
```

5. Sunucuyu yeniden başlatın / config cache temizleyin:

```bash
php artisan config:clear
php artisan cache:clear
php artisan queue:restart
```

6. Tarayıcı konsolunda `window.Echo` ile kanala abone olup event dinleyin.

## Self-hosted (laravel-websockets)

 Eğer self-hosted kullanmak istiyorsanız:
 
 Alternative (recommended): Soketi or laravel-echo-server
 - These are independent WebSocket servers that implement the Pusher protocol and do not require PHP packages or changes to your application's Composer dependencies.
 - Soketi (https://github.com/soketi/soketi) is a performant, actively maintained Rust/Node-compatible server with a simple Docker image. It speaks the Pusher protocol so your existing Echo client and `broadcast`/`pusher` driver configuration will work if you point the host/port to the Soketi instance.

 - Laravel Echo Server (https://github.com/tlaverdure/laravel-echo-server) is a Node-based server that also implements the Pusher protocol. It is straightforward to run via Docker and integrates well with Laravel Echo as an on-prem alternative to Pusher.
 
 Quick Soketi setup (Docker Compose)
 
 1. Create `docker-compose.soketi.yml` next to your `docker-compose.yml` (example provided in repo).
 2. Start soketi: `docker compose -f docker-compose.soketi.yml up -d`
 3. Update `.env` (see below examples) to point `PUSHER_HOST`/`PUSHER_PORT`/`PUSHER_SCHEME` to the soketi host.
 4. Keep `BROADCAST_DRIVER=pusher` and your existing `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET` values in `.env`. Soketi validates the app credentials.
 
 Why use Soketi instead of `beyondcode` here?
 - No Composer/framework changes required.
 - Works with the Pusher protocol (Laravel Echo + pusher-js) out of the box.
 - Easy to run via Docker or a small dedicated VM.
 
 Troubleshooting
 - Ensure `PUSHER_SCHEME` and `PUSHER_PORT` match the soketi listener (e.g. `http` + `6001` or `https` + `443`).
 - If running behind a reverse proxy (nginx), forward the WebSocket upgrade headers and use the TLS-terminating proxy for secure connections.

Quick Laravel Echo Server setup (Docker Compose)

1. A sample `docker-compose.echo.yml` and `laravel-echo-server.json` are provided in the repo. Start it with:

	`docker compose -f docker-compose.echo.yml up -d`

2. Update `.env` to point PUSHER_HOST/PORT to the echo server host/port (defaults in `.env.example` point to `127.0.0.1:6001`). Keep `BROADCAST_DRIVER=pusher`.

3. To trigger an event over HTTP for testing (unauthenticated POST may be rejected depending on configuration), use the laravel-echo-server REST API (see server logs or docs). If authentication is required, create a small script that signs requests using the app `key`/`secret`.

Why choose laravel-echo-server?
 - Simple Docker image available; quick to bootstrap.
 - Implements Pusher protocol — works with Laravel Echo and the `pusher` broadcast driver.
 - Good for local development or small self-hosted deployments.

- Öncelikle composer dependency uyumluluğunu kontrol edin. (Bu projede Laravel v12 / PHP 8.3 kullanılıyor; beyondcode paketinin bazı sürümleri Laravel 12 ile uyuşmayabilir.)
- Eğer uyumlu sürüm bulunursa, şu komut ile yükleyin:

```bash
composer require beyondcode/laravel-websockets -W

# ardından publish ve migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

- Bu yol diğer paketlerin sürümlerini etkileyebilir; öncesinde `composer update --dry-run` yaparak hangi paketlerin değişeceğini kontrol edin.

## Notlar
- Proje `resources/js/echo-setup.js` dosyası Pusher/MIX env değişkenlerini okur — kurulum sonrası frontend'i yeniden derleyin.
- Eğer yardıma ihtiyacınız varsa self-hosted yükleme için paket uyumluluk çözümlemesini ben yapabilirim (risk ve değişecek paket listesini raporlarım).

---
Gerektiğinde bu dosyayı genişletip adım adım deploy talimatları ekleyebilirim.
## WebSocket (Realtime) Kurulumu

Bu proje karar güncellemeleri için broadcast event yayınlamaya hazırdır (`DecisionStatusChanged` event'i eklendi).

Yapmanız gerekenler:

1. `composer require beyondcode/laravel-websockets pusher/pusher-php-server` veya Pusher kullanacaksanız ilgili paketleri ekleyin.
2. `.env` içinde aşağıdaki değişkenleri ayarlayın:

```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-id
PUSHER_APP_KEY=your-key
PUSHER_APP_SECRET=your-secret
PUSHER_APP_CLUSTER=mt1
```

3. `config/broadcasting.php` içinde `pusher` driver yapılandırmasını kontrol edin (varsayılan Laravel ayarları uygundur).

4. WebSocket server'ı çalıştırmak için (laravel-websockets kullanılıyorsa):

```bash
php artisan websockets:serve
```

5. Frontend tarafında `laravel-echo` + `pusher-js` kurup `window.Echo`'yu başlatın (örnek `resources/js/echo-setup.js` dosyasında örnek kod var).

6. Tarayıcıda `window.Echo.channel('project.{id}').listen('DecisionStatusChanged', ...)` ile güncellemeleri dinleyebilirsiniz.

Not: Bu repo `DecisionStatusChanged` event'ini yayınlayacak şekilde güncellendi. Server tarafı broadcast yapılandırması yapılmadan gerçek zamanlı güncellemeler çalışmaz — yukarıdaki adımları takip edin.

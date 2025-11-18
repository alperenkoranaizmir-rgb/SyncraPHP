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

`beyondcode/laravel-websockets` paketinin mevcut sürümü, bu repo ile doğrudan uyumlu olmayabilir (illuminate paket sürümleri nedeniyle). Eğer self-hosted kullanmak istiyorsanız:

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

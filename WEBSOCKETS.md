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

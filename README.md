# Syncra (CRM) — Laravel Projesi

Bu depo, yerel geliştirme için oluşturulmuş bir Laravel tabanlı CRM uygulamasıdır. Proje AdminLTE temasıyla entegre edilmiş, Türkçe dil desteği yüklenmiş ve temel auth (Breeze) ile birlikte gelir.

## Hızlı Başlangıç

Gerekli yazılımlar:
- PHP 8.2+ (Laravel 12 ile uyumlu)
- Composer
- MySQL
- Node.js (tercihen >= 20.19.0; mevcut sistemde Node 18.x var, ancak Vite 20.19+ öneriyor)

Kurulum (yüklü değilse):

```bash
# projenin köküne gidin
cd "/home/alperen-korana/Masaüstü/Korana Yazılım/Php/Syncra/syncrav2"

# bağımlılıkları yükleyin
composer install
npm install

# .env ayarlarını kontrol edip (DB bilgileri) anahtar oluşturun
cp .env.example .env
php artisan key:generate

# Veritabanını oluşturup migration/seed çalıştırın
php artisan migrate --force
php artisan db:seed --class=Database\\Seeders\\SuperAdminSeeder

# Varlıkları derleyin
npm run build

# Geliştirme sunucusunu başlatın
php artisan serve --host=127.0.0.1 --port=8000
```

## Ortam Değişkenleri (örnek)

`.env` içinde en önemli ayarlar:

- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=syncrav2`
- `DB_USERNAME=root`
- `DB_PASSWORD=benq2535Aa.`

> Not: Veritabanı parolası kullanıcının belirttiği son biçimde `benq2535Aa.` olarak ayarlandı.

## Admin Hesabı

- Email: `admin@admin.com`
- Parola: `benq2535`

Bu hesap `SuperAdminSeeder` ile oluşturuldu.

## AdminLTE Entegrasyonu

- `jeroennoten/laravel-adminlte` paketi kuruldu ve `adminlte:install --type=full` ile tüm varlıklar, görünümler ve rota/şablonlar yayımlandı.
- Admin paneli: `http://127.0.0.1:8000/admin` (giriş yapıldıktan sonra erişilebilir)

## Testler

Projede bulunan örnek testler başarıyla çalışıyor:

```bash
php artisan test
```

## Bilinen Notlar ve Öneriler

- Node.js sürümünüzü `>= 20.19.0` veya `>= 22.12.0` olarak güncellemenizi öneririm; Vite daha yeni Node sürümlerini gerektiriyor. Mevcut sistemde derleme Node 18 ile de başarılı oldu fakat uyarı veriyor.
- Üretime alırken `APP_ENV=production` ve `APP_DEBUG=false` ayarlarını yapın, varlıkları `npm run build` ile derleyin.
- İsterseniz login sonrası otomatik `/admin` yönlendirmesi ekleyebilirim.

## İletişim / Sonraki Adımlar

- İsterseniz AdminLTE menüsünü, kullanıcı rolleri/izinlerini ve profil sayfasını yapılandırabilirim.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

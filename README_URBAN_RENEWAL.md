# Kentsel Dönüşüm Modülü (Urban Renewal)

Bu modül, kentsel dönüşüm projelerini yönetmek için temel migration, modeller, API ve admin Blade sayfalarını sağlar.

Kurulum kısa rehberi

1. Ortam kurun

```bash
cd syncrav2
composer install
cp .env.example .env
# .env içinde DB ayarlarını yapın
php artisan key:generate
```

2. Asset ve storage hazırlıkları

```bash
npm install
make adminlte-install   # AdminLTE varlıklarını public/vendor/adminlte altına kopyalar
php artisan storage:link
```

3. Migrasyon ve seed

```bash
php artisan migrate
php artisan db:seed
```

4. Sunucu

```bash
php artisan serve
```

API
- `routes/api.php` içindeki `projects`, `projects.units`, `projects.owners`, `projects.documents`, `decisions` ve `decisions/{id}/sign` endpoint'lerini kullanabilirsiniz (Sanctum auth gerekli).

Admin Blade
- `http://localhost:8000/admin/projects` — Projeler listesi (auth gerektirir)
- `http://localhost:8000/admin/projects/{id}` — Proje detay

50+1 Hesabı
- `config/consensus.php` dosyasında `basis` (unit|owner) seçeneği ile çoğunluk bazını belirleyin.

Storage
- Proje dokümanları `projects` diskinde saklanır (config/filesystems.php içinde). Varsayılan local root: `storage/app/projects`.

Devam eden işler
- Policies, form-requests, controllerlar ve admin blade sayfaları temel işlevsellik sağlar.
- Ek istekler için: doküman preview, signed URL, export job gibi özellikler eklendi.

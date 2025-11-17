# İş Listesi (Yapılanlar ve Kalanlar)

Bu dosya proje üzerinde yapılan işleri ve kalan görevleri listeler. Tamamlanan maddeler [x] ile işaretlenmiştir; tamamlanmamış maddeler boş bırakılmıştır. Dosya her adımda güncellenecektir.

## Yapılanlar (Tamamlandı)

- [x] Laravel en son sürümünü kur (Laravel 12)
- [x] `.env` yapılandırması: `APP_LOCALE=tr`, MySQL ayarları eklendi
- [x] Türkçe dil paketlerini yükle (`laravel-lang`) ve `php artisan lang:add tr`
- [x] Gerekli Composer paketlerini yükle (Debugbar, IDE Helper vb.)
- [x] `php artisan test` ile testleri çalıştır (2 test geçti)
- [x] Laravel geliştirme sunucusunu başlat (`php artisan serve`)
- [x] AdminLTE entegrasyonu: `jeroennoten/laravel-adminlte` paketi kuruldu
- [x] Breeze ile auth scaffold kuruldu (Breeze)
- [x] AdminLTE full install (`adminlte:install --type=full --force`) çalıştırıldı — varlıklar, view'ler, config, auth view ve route'lar yayımlandı
- [x] AdminLTE için NPM paketleri yüklendi (`admin-lte`, `@fortawesome/fontawesome-free`, `overlayscrollbars`) ve Vite varlıkları derlendi
- [x] `resources/js/app.js` ve `resources/css/app.css` AdminLTE importlarıyla güncellendi
- [x] Root yönlendirmesi login sayfasına yönlendirildi; `/admin` route'u eklendi
- [x] Basit AdminLTE dashboard view eklendi (`resources/views/admin/dashboard.blade.php`)
- [x] `SuperAdminSeeder` oluşturuldu ve çalıştırıldı (`admin@admin.com` / `benq2535`)
- [x] `Auth::routes()` satırı (laravel/ui bağımlılığı gerektirdiği için) kaldırıldı ve Breeze ile uyum sağlandı
- [x] Public `vendor/adminlte` varlıkları yayımlandı ve derlendi

## Kalan / Önerilen İşler (Henüz tamamlanmadı)

- [ ] AdminLTE menü yapılandırmasını `config/adminlte.php` üzerinden özelleştir
- [ ] Giriş sonrası otomatik `/admin` yönlendirmesi ekle (isterseniz otomatik yapılacak)
- [ ] Kullanıcı rolleri ve izin sistemi ekle (örn. Spatie Permissions)
- [ ] Üretim için Node.js sürümünü güncelle (>= 20.19.0) ve CI/CD pipeline hazırla
- [ ] Admin paneli için daha fazla örnek sayfa (raporlar, müşteri yönetimi, ayarlar) oluştur
- [ ] E2E testleri / auth testleri ekle

## Öneriler / Notlar

- Varlıkların tam yüklenmemesi veya tema hataları görürseniz tarayıcı önbelleğini temizleyin (Ctrl+F5) ve `public/build` içeriğini kontrol edin.
- `public/vendor/adminlte` klasörünün erişim izinlerini doğrulayın: `chmod -R 755 public/vendor/adminlte`.
- İsterseniz `IS-LISTESI.md` dosyasını her tamamlanan adımda otomatik güncelleyecek bir betik ekleyebilirim.

---

Bu dosya güncellendi: {tarih}

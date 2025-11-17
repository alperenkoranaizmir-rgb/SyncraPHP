# AdminLTE Template List

Bu dosya `resources/adminlte_templates/` altındaki AdminLTE şablon grubunu, her şablonun amacını ve hangi varlıklar / eklentiler (assets/plugins) gerektiğini açıklar.

Genel notlar
- Tüm şablonlar AdminLTE yapısına uygun olarak hazırlanmıştır ve `public/vendor/adminlte/` altında beklenen CSS/JS/varlık yollarını referans verir.
- Aşağıdaki eklentiler (DataTables, jsGrid, Summernote, FullCalendar vb.) proje içinde bulunmuyorsa, `adminlte_setup.md` talimatlarına göre eklenmelidir.

Mevcut dosyalar (şu an eklenmiş)
- `auth/register.html` — Kayıt (register) sayfası örneği; basit form alanları ve AdminLTE kart yapısı içerir.

Gruplar ve şablonlar

- **UI** (görsel bileşenler)
  - `ui/icons.html` — Simge setleri ve kullanım örnekleri (FontAwesome / Ionicons).
  - `ui/buttons.html` — Buton tipleri ve sınıf kombinasyonları.
  - `ui/modals.html` — Modal pencere örnekleri.
  - `ui/navbar.html` — Üst navigasyon ve dropdown örnekleri.
  - `ui/timeline.html` — Zaman çizelgesi bileşeni.
  - `ui/ribbons.html` — Ribbon (bant) örnekleri.

- **Forms** (formlar & editörler)
  - `forms/general.html` — Temel form alanları (input, select, checkbox).
  - `forms/advanced.html` — Gelişmiş bileşenler (select2, inputmask, colorpicker).
  - `forms/editors.html` — WYSIWYG örnekleri (Summernote veya benzeri).
  - `forms/validation.html` — Client-side ve server-side doğrulama örnekleri.

- **Tables** (tablo örnekleri)
  - `tables/simple.html` — Basit HTML tablolar.
  - `tables/data.html` — DataTables ile örnek tablo (sıralama, filtreleme, paging).
  - `tables/jsgrid.html` — jsGrid ile CRUD tablo örneği (isteğe bağlı).

- **Pages** (uygulama sayfaları)
  - `pages/calendar.html` — Takvim örneği (FullCalendar entegrasyonu).
  - `pages/gallery.html` — Resim galerisi (lightbox/eklentilerle).
  - `pages/kanban.html` — Kanban panosu örneği.

- **Mailbox**
  - `mailbox/mailbox.html` — Gelen kutusu görünümü.
  - `mailbox/compose.html` — Mesaj oluşturma sayfası.
  - `mailbox/read-mail.html` — Mesaj okuma detayı.

- **Examples** (hazır uygulama sayfaları)
  - `examples/projects.html` — Proje listesi / kart görünümü.
  - `examples/project-add.html` — Proje ekleme formu.
  - `examples/project-edit.html` — Proje düzenleme formu.
  - `examples/project-detail.html` — Proje detay sayfası.
  - `examples/invoice.html` — Fatura örneği.
  - `examples/profile.html` — Kullanıcı profili.
  - `examples/contacts.html` — Rehber / kişiler.
  - `examples/faq.html` — SSS sayfası.
  - `examples/contact-us.html` — İletişim formu.

- **Auth** (kimlik doğrulama)
  - `auth/login.html` — Giriş sayfası (örnek).
  - `auth/register.html` — Kayıt sayfası (mevcut).
  - `auth/forgot-password.html` — Şifre unutma.
  - `auth/reset-password.html` — Şifre sıfırlama.

- **Mail Templates**
  - `mail/mailbox.html` — Mailbox HTML şablonu (e-posta gösterimi için örnek).

- **Components**
  - `components/_sidebar.html` — Tekrar kullanılabilir sidebar parçaları.
  - `components/_footer.html` — Alt bilgi bileşeni.
  - `components/_navbar.html` — Üst bilgi bileşeni.

Gerekli varlıklar / pluginler
- Core (zorunlu):
  - jQuery
  - Bootstrap CSS & JS
  - AdminLTE CSS & JS
  - FontAwesome (veya tercih edilen ikon seti)
- Opsiyonel (şablonlarda referans var ise):
  - DataTables (css/js)
  - jsGrid (css/js)
  - Summernote veya benzeri WYSIWYG editör
  - FullCalendar (css/js)
  - Select2
  - InputMask

Dosya yolları — beklenen layout
- Varsayılan olarak şablonlar `/vendor/adminlte/` altındaki varlıklara referans verir. Örnek:

  - CSS: `/vendor/adminlte/dist/css/adminlte.min.css`
  - JS: `/vendor/adminlte/dist/js/adminlte.min.js`
  - Plugins: `/vendor/adminlte/plugins/datatables/...`, `/vendor/adminlte/plugins/summernote/...` vb.

Kullanım ve entegrasyon
- Laravel ile kullanmak için şablonları Blade'e dönüştürebilirsiniz. Basit bir yol:

```bash
# proje kökünden örnek listeleme
ls -la resources/adminlte_templates
```

- Önerilen adımlar:
  1. `adminlte_setup.md` dosyasındaki adımları uygulayarak gerekli varlıkları `public/vendor/adminlte` altına kopyalayın veya `npm` ile kurulum yapın.
  2. İstediğiniz şablonu `resources/views/` altına kopyalayın ve Blade sözdizimine göre `@include` / `@yield` kullanarak bileşenleri bağlayın.
  3. DataTables, FullCalendar vb. için backend verisi sağlayan route/controller oluşturun.

Notlar
- Bu liste, kaynak dizinde bulunan şablon iskeletinin bir manifestosudur. Bazı şablonlar sadece placeholder/örnek içeriyor; tam uygulama entegrasyonu için backend endpoint'leri ve eklenti dosyalarının projeye eklenmesi gerekir.

İleri adımlar önerisi
- `adminlte_setup.md` oluşturulsun (assets kurulum talimatları) — (TODO: görevlendirildi).
- Şablonları Laravel Blade formatına çevirip küçük bir örnek route ile canlı gösterim sağlansın.
# AdminLTE Template List

Bu dosya `resources/adminlte_templates/` altında bulunan AdminLTE örnek şablonlarının listesini, amaçlarını ve hangi eklentilere ihtiyaç duyduklarını açıklar.

Kategoriler:
- UI: ikonlar, butonlar, navbar, timeline, ribbons, modals, sliders
- Forms: general, advanced, editors, validation
- Tables: simple, data, jsgrid
- Pages/Examples: projects, project-add, project-edit, project-detail, profile, invoice, contacts, faq, contact-us
- Auth: login, register, forgot-password, recover-password, lockscreen
- Mailbox: mailbox, compose, read-mail
- Misc: calendar, gallery, kanban, starter, search

NOT: Her şablon `public/vendor/adminlte/...` yollarına göre static varlıkları bekler. Eğer proje kökünde AdminLTE varlıkları yoksa `adminlte_setup.md` içindeki adımları takip ederek `npm` veya doğrudan AdminLTE paketini kopyalayın.

Dosya eşlemesi (kısa):

- UI/icons.html : `ui/icons.html` — FontAwesome + AdminLTE icon set gösterimleri.
- UI/buttons.html : `ui/buttons.html` — farklı düğme stilleri, badge, icon butonlar.
- UI/sliders.html : `ui/sliders.html` — noUiSlider + bootstrap slider örnekleri.
- UI/modals.html : `ui/modals.html` — modal dialog örnekleri.
- UI/navbar.html : `ui/navbar.html` — üst navigasyon örnekleri.
- UI/timeline.html : `ui/timeline.html` — timeline bileşeni örnekleri.
- UI/ribbons.html : `ui/ribbons.html` — ribbon görünümleri.

- Forms/general.html : `forms/general.html` — temel form elemanları.
- Forms/advanced.html : `forms/advanced.html` — select2, inputmask, colorpicker vb.
- Forms/editors.html : `forms/editors.html` — Summernote / Quill örnekleri.
- Forms/validation.html : `forms/validation.html` — örnek client-side validation (Parsley/Bootstrap).

- Tables/simple.html : `tables/simple.html` — basit tablo örnekleri.
- Tables/jsgrid.html : `tables/jsgrid.html` — jsGrid örneği (ek plugin gerekir).
- Tables/data.html : `tables/data.html` — DataTables örneği (DataTables plugin gerekir).

- Pages/calendar.html : `pages/calendar.html` — FullCalendar entegrasyonu gerekli.
- Pages/gallery.html : `pages/gallery.html` — lightbox/ek plugin gerekebilir.
- Pages/kanban.html : `pages/kanban.html` — draggable kanban (plugin gerekebilir).

- Mailbox/* : `mailbox/` — mailbox, compose, read-mail örnekleri.

- Examples/* : `examples/` — projects, project-add, project-edit, project-detail, profile, invoice, contacts, faq, contact-us, etc.

Kullanım notları:
- Tüm sayfalar AdminLTE HTML yapılarını temel alır ve `base.html` olarak ortak header/footer scriptleri içerir.
- Eksik plugin'ler TEMPLATELIST ve `adminlte_setup.md` içinde listelendi; gerektiğinde `npm install` veya vendor kopyalama ile projeye ekleyin.

İlerideki modüllerde bu template dosyalarını `resources/views/` (Laravel blade) veya Django template engine ile kolayca dönüştürebilirsiniz.

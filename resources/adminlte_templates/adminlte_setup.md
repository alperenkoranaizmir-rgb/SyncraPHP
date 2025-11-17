# AdminLTE Kurulum ve Varlık (assets) Talimatları

Bu doküman `resources/adminlte_templates/` içindeki HTML şablonlarının gerektirdiği AdminLTE ve eklenti varlıklarının (CSS/JS/font/img) nasıl kurulacağını açıklar. İki ana yaklaşım sunuyorum:

- A) Modern Laravel + Vite (tercih edilen): `npm` ile paketleri kurup Vite ile paketlemek.
- B) Hızlı manuel deploy: `node_modules` içinden gerekli dosyaları `public/vendor/adminlte/` altına kopyalamak.

Her iki yöntem için genel hedef aynı: şablonlar `/vendor/adminlte/...` yollarına referans verir, bu yüzden hedef sonunda `public/vendor/adminlte/` içinde AdminLTE dosyalarının bulunmasıdır.

Önkoşullar
- Node.js + npm ya da yarn yüklü olmalı.
- Projede `resources/js` ve `resources/css` veya Vite yapılandırması (`vite.config.js`) mevcut olmalı (bu repo'da Vite kullanılıyor).

1) Yöntem A — npm + Vite (önerilen)

a) Paketleri kurun

```bash
# proje kökünde
npm install admin-lte@^3.2 bootstrap@^5 jquery popper.js --save
# opsiyonel eklentiler (kullandığınız şablonlara göre):
npm install datatables.net datatables.net-bs5 datatables.net-responsive datatables.net-responsive-bs5
npm install summernote@^0.8.18 @fullcalendar/core @fullcalendar/daygrid select2 inputmask jsgrid --save
```

b) `resources/js/app.js` veya projenizdeki giriş dosyasına import ekleyin

```js
// resources/js/app.js
import 'bootstrap/dist/css/bootstrap.min.css';
import 'admin-lte/dist/css/adminlte.min.css';
// opsiyonel plugin css
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'summernote/dist/summernote-bs4.css';

import 'jquery';
import 'bootstrap';
import 'admin-lte/dist/js/adminlte.min.js';
// opsiyonel plugin js
import 'datatables.net-bs5';
import 'summernote/dist/summernote-bs4.js';
import FullCalendar from '@fullcalendar/core';
```

c) `resources/css/app.css` içinde AdminLTE'e özgü düzenlemeleri ekleyin veya sadece imported css'i kullanın.

d) Vite ile derleyin

```bash
npm install
npm run build   # veya geliştirme için: npm run dev
```

e) Vite ile paketlenmiş dosyalarınız `public/build/` (veya Vite yapılandırmasına bağlı) altında olacak. Eğer bizim şablonlarımız doğrudan `/vendor/adminlte/...` bekliyorsa, iki seçenek vardır:

- Vite çıktısını kullanarak Blade üzerinde `@vite('resources/js/app.js')` ile kaynakları yükleyin (en iyi yaklaşım). Bu durumda şablonlardaki `/vendor/adminlte/...` referanslarını Blade'e göre düzenlemeniz gerekir.
- Veya aşağıdaki B yöntemi ile node_modules içinden `public/vendor/adminlte/` altına kopyalayın, böylece mevcut şablonlar çalışır.

2) Yöntem B — Manuel kopyalama (şablonların yollarını değiştirmeyi istemiyorsanız)

a) AdminLTE dosyalarını kopyalayın

```bash
# proje kökünden
mkdir -p public/vendor/adminlte/dist public/vendor/adminlte/plugins
cp -r node_modules/admin-lte/dist/* public/vendor/adminlte/dist/
```

b) Ek pluginleri kopyalayın (örnekler)

```bash
mkdir -p public/vendor/adminlte/plugins/datatables
cp node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js public/vendor/adminlte/plugins/datatables/
cp node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css public/vendor/adminlte/plugins/datatables/

mkdir -p public/vendor/adminlte/plugins/summernote
cp -r node_modules/summernote/dist/* public/vendor/adminlte/plugins/summernote/

mkdir -p public/vendor/adminlte/plugins/fullcalendar
# fullcalendar paketleri farklı yapıda; genelde CDN veya build pipeline ile kullanmak daha kolaydır
```

c) İkonlar ve fontlar

AdminLTE FontAwesome veya diğer ikon setlerini kullanır. Eğer `public/vendor/adminlte/plugins` altına ikonları kopyulamadıysanız, CDN kullanabilir veya `node_modules/@fortawesome/fontawesome-free` içeriğini kopyalayabilirsiniz:

```bash
mkdir -p public/vendor/adminlte/plugins/fontawesome-free
cp -r node_modules/@fortawesome/fontawesome-free/* public/vendor/adminlte/plugins/fontawesome-free/
```

3) CDN alternatifi (hızlı test için)

Eğer asset kopyalamak istemiyorsanız, şablonlarda CDN linkleri kullanabilirsiniz. `base.html` veya Blade template'inizde şu CDNleri ekleyin:

```html
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
```

Bu yöntem üretim için önerilmez ama hızla şablonları test etmenizi sağlar.

4) Örnek `public/vendor/adminlte` hedef yapısı

```
public/vendor/adminlte/
├─ dist/
│  ├─ css/adminlte.min.css
│  ├─ js/adminlte.min.js
│  └─ img/...
└─ plugins/
   ├─ datatables/
   ├─ summernote/
   ├─ fontawesome-free/
   └─ fullcalendar/
```

5) Şablon bağlantılarını korumak

Mevcut şablonlarımız doğrudan `/vendor/adminlte/...` path'ini çağırır. Eğer Vite ile derleme yapıp `@vite` kullanmayı tercih ederseniz, şablon dosyalarında bu yolları Blade ile değiştirin veya `adminlte_setup.md`'deki kopyalama adımlarını uygulayın.

6) DataTables / FullCalendar / Summernote gibi eklentilerin kullanım notları

- DataTables: CSS ve JS dosyalarını `plugins/datatables/` altına koyun ve tabloya `class="table table-striped"` gibi sınıflar ekleyip JS ile `$('#myTable').DataTable()` başlatın.
- Summernote: textarea'ya `$('.summernote').summernote()` çağrısı gerekir.
- FullCalendar: takvim container'ı oluşturup JS içinde FullCalendar başlatın; backend'den event JSON dönen endpoint'ler sağlayın.

7) Hatalar & Kontroller

- Eğer sayfada `404` veya `ERR_ABORTED` hatası ile asset yüklenemiyorsa, `public/vendor/adminlte` içindeki yol ve dosya isimlerini kontrol edin.
- Tarayıcı geliştirici konsolundan eksik dosya yollarını izleyin ve kopyalamayı/yeniden bağlamayı deneyin.

8) Örnek hızlı komut seti (hızlı deploy: manuel kopya)

```bash
npm install
mkdir -p public/vendor/adminlte/dist public/vendor/adminlte/plugins
cp -r node_modules/admin-lte/dist/* public/vendor/adminlte/dist/
cp -r node_modules/@fortawesome/fontawesome-free public/vendor/adminlte/plugins/fontawesome-free
cp -r node_modules/datatables.net-bs5/css public/vendor/adminlte/plugins/datatables
cp -r node_modules/datatables.net-bs5/js public/vendor/adminlte/plugins/datatables
```

9) Sonraki adımlar önerisi

- Ben şablonları doğrudan `public/vendor/adminlte` yollarına göre bağlanmış halde bıraktım. İsterseniz ben:
  - Şablonları Blade'e çevirip `@vite` kullanımına göre güncelleyeyim, veya
  - Proje kökünde bir `npm` script/`makefile` veya `composer` script ekleyip `node_modules` -> `public/vendor/adminlte` kopyalama işini otomatikleştireyim.

Sorunuz veya tercih ettiğiniz yöntem varsa söyleyin, ben otomatikleştirmeyi ayarlayayım.
# AdminLTE Assets Setup

Bu proje için şablonlar `public/vendor/adminlte/` altında AdminLTE varlıklarını (CSS, JS, pluginler) bekler.

Önerilen kurulum yolları:

1) NPM ile yükleme

```bash
cd syncrav2
npm install admin-lte@^3.2.0 --save
# Gerekli pluginleri de ekleyin
npm install datatables.net datatables.net-bs4 select2 summernote jsgrid fullcalendar --save
```

Ardından `node_modules/admin-lte/dist/*` dosyalarını `public/vendor/adminlte/` altına kopyalayın (ve pluginleri uygun alt dizinlere).

2) Doğrudan vendor kopyalama

AdminLTE kaynak dosyalarını indirip `public/vendor/adminlte/` altına açabilirsiniz. Aşağıdaki dizinler en azından olmalıdır:

- `public/vendor/adminlte/dist/css/adminlte.min.css`
- `public/vendor/adminlte/dist/js/adminlte.min.js`
- `public/vendor/adminlte/plugins/jquery/jquery.min.js`
- `public/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js`
- Plugin klasörleri: `plugins/datatables`, `plugins/select2`, `plugins/summernote`, `plugins/jsgrid`, `plugins/fullcalendar` vb.

3) Laravel Mix / Vite entegrasyonu

Eğer proje `vite` veya `mix` kullanıyorsa, AdminLTE kaynaklarını build sürecine eklemeniz (import veya copy) iyi olur.

Hangi template hangi pluginleri gerektirir? (kısa)
- `tables/data.html` : DataTables
- `tables/jsgrid.html`: jsGrid
- `forms/advanced.html`: Select2, InputMask, DatePicker, Colorpicker
- `forms/editors.html`: Summernote veya Quill
- `pages/calendar.html`: FullCalendar
- `pages/kanban.html`: Kanban plugin (örn. dragula veya jKanban)

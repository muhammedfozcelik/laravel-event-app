# Laravel Etkinlik Yönetim Sistemi (Event App)

Bu proje, kullanıcıların etkinlik oluşturabileceği, düzenleyebileceği, silebileceği ve kategorilere göre filtreleyebileceği bir Laravel tabanlı web uygulamasıdır. Verilen task kapsamında 4 saatlik süre içerisinde geliştirilmiştir.

## 🚀 Proje Özellikleri

-   **Kimlik Doğrulama:** Laravel Breeze altyapısı ile güvenli kayıt ve giriş işlemleri.
-   **Etkinlik Yönetimi (CRUD):**
    -   Kullanıcılar etkinlik oluşturabilir.
    -   **Yetkilendirme:** Her kullanıcı sadece **kendi oluşturduğu** etkinliği düzenleyebilir veya silebilir. Başkasının etkinliğine müdahale edilemez.
-   **Kategori Sistemi:**
    -   Etkinlikler kategorilere ayrılmıştır.
    -   URL dostu (slug) yapı ile kategori bazlı filtreleme yapılabilir (Örn: `/categories/teknoloji`).
-   **[BONUS] Kategori Yönetimi:**
    -   Yönetim paneline ihtiyaç duymadan, arayüz üzerinden dinamik olarak yeni kategori ekleme, düzenleme ve silme özellikleri geliştirilmiştir.
-   **Validasyon ve Güvenlik:**
    -   Geçmiş tarihli etkinlik oluşturulması hem arayüzde (datepicker kısıtlaması) hem de Backend tarafında (`after:now` kuralı) engellenmiştir.
    -   Tüm form işlemlerinde CSRF koruması mevcuttur.

## 🛠️ Kurulum Adımları

Projeyi yerel ortamınızda çalıştırmak için aşağıdaki adımları izleyin:

1.  **Projeyi İndirin:**

    ```bash
    git clone <repo-url>
    cd EventApp
    ```

2.  **Bağımlılıkları Yükleyin:**

    ```bash
    composer install
    ```

    _(Not: Arayüz için Tailwind CSS CDN üzerinden çekilmiştir, `npm install` veya `npm run build` komutlarına gerek yoktur, proje direkt çalışır.)_

3.  **Çevre Değişkenlerini Ayarlayın:**
    `.env.example` dosyasının kopyasını oluşturup adını `.env` yapın:

    ```bash
    cp .env.example .env
    ```

    `.env` dosyasını açıp veritabanı ayarlarını yapılandırın:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=event_app
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Uygulama Anahtarını Oluşturun:**

    ```bash
    php artisan key:generate
    ```

5.  **Veritabanını Hazırlayın:**
    Tabloları oluşturmak için migration komutunu çalıştırın:

    ```bash
    php artisan migrate
    ```

6.  **Projeyi Başlatın:**
    ```bash
    php artisan serve
    ```
    Tarayıcıda şu adrese gidin: `http://localhost:8000`

## ℹ️ Teknik Notlar ve Kod Kalitesi

-   **Performans:** Veritabanı sorgularında N+1 problemini önlemek için Controller tarafında **Eager Loading** (`with(['category', 'user'])`) yöntemi kullanılmıştır.
-   **Rota Yapısı:** `web.php` dosyasında rotalar `auth` middleware grubu altında düzenlenmiş, çakışmaları önlemek için statik rotalar dinamik rotaların üzerine alınmıştır.
-   **Veri Bütünlüğü:** Veritabanı seviyesinde `onDelete('cascade')` kullanılarak, bir kullanıcı veya kategori silindiğinde ilişkili verilerin de temizlenmesi sağlanmıştır.

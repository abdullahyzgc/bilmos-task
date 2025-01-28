<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# Personel Takip Sistemi

## 📋 Proje Hakkında
Bu proje, şirketlerin personel giriş-çıkış takibini yapabilmesi için geliştirilmiş modern bir web uygulamasıdır. Sistem, personelin mesai saatlerini takip etme, geç kalma/erken çıkma durumlarını yönetme ve raporlama gibi temel özellikleri içermektedir.

## 🚀 Özellikler
- 👥 Personel yönetimi (ekleme, düzenleme, silme)
- 🕒 Giriş/çıkış takibi
- 📱 Mobil uyumlu arayüz
- 📊 Detaylı raporlama
- 🌍 REST API desteği
- 📱 Mobil uygulama için API endpoints

## 💻 Teknolojiler
- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Bootstrap 5
- jQuery
- Font Awesome 6

## 🛠️ Kurulum

### Sistem Gereksinimleri
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM
- Git

### Kurulum Adımları

1. **Projeyi Klonlayın**

```bash
git clone https://github.com/abdullahyzgc/personel-takip.git
cd personel-takip
```

2. **Composer Bağımlılıklarını Yükleyin**
```bash
composer install
```

3. **NPM Bağımlılıklarını Yükleyin**
```bash
npm install
npm run dev
```

4. **Ortam Değişkenlerini Ayarlayın**
```bash
cp .env.example .env
php artisan key:generate
```

5. **.env Dosyasını Düzenleyin**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=personel_takip
DB_USERNAME=root
DB_PASSWORD=

# Mail ayarları
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

6. **Veritabanını Oluşturun**
```bash
php artisan migrate
```

7. **Örnek Verileri Yükleyin (Opsiyonel)**
```bash
php artisan db:seed
```

8. **Storage Linkini Oluşturun**
```bash
php artisan storage:link
```

9. **Uygulamayı Çalıştırın**
```bash
php artisan serve
```

## 👥 Varsayılan Kullanıcılar

### Admin
- Email: admin@admin.com
- Şifre: 12345678

### Test Personeli
- Email: ahmet@test.com
- Şifre: 123455

## 📱 API Kullanımı

API dokümantasyonuna `/admin/api-docs` adresinden erişebilirsiniz.

### API Endpoint Örnekleri
- POST /api/v1/login
- POST /api/v1/register
- POST /api/v1/check-in
- POST /api/v1/check-out
- GET /api/v1/attendance-logs

## 🔧 Özelleştirme

### Mesai Saatleri ve Konum Ayarları
/config/working_hours.php ve /config/location.php dosyalarında düzenleyebilirsiniz.


### Mail Ayarları
Şifre sıfırlama ve bildirimler için mail ayarlarını yapılandırın:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

## 📊 Veritabanı Şeması

### Users Tablosu
- id (primary key)
- name
- surname
- email
- phone
- password
- created_at
- updated_at

### Attendance_Logs Tablosu
- id (primary key)
- user_id (foreign key)
- check_in
- check_out
- late_reason
- early_leave_reason
- is_late
- is_early_leave
- created_at
- updated_at

## 🔒 Güvenlik Önlemleri
- CSRF koruması
- XSS koruması
- SQL Injection koruması
- Sanctum token authentication
- Password hashing

## 🚀 Deployment

### Sunucu Gereksinimleri
- PHP >= 8.1
- MySQL >= 8.0
- Composer

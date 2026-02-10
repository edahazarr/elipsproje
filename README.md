# ElipsProje

Şirket ve görev yönetimi için geliştirilmiş basit bir proje takip sistemi.  
Bu proje, staj sürecinde Laravel kullanılarak geliştirilmiştir.

## Özellikler
- Şirket bazlı kullanıcı yapısı
- Proje oluşturma ve düzenleme
- Proje üyeleri atama
- Görev oluşturma ve düzenleme
- Kanban tarzı görev görünümü (Yapılacak / Yapılıyor / Bitti)

## Kullanılan Teknolojiler
- Laravel
- Bootstrap (Bootswatch – Flatly)
- MySQL

## Ekranlar
- Dashboard
- Şirket yönetimi
- Proje listesi
- Görev kanban ekranı
- Proje üye yönetimi

## Kurulum

```bash
git clone https://github.com/edahazarr/elipsproje.git
cd elipsproje
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

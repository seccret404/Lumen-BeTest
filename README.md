# Project Lumen API
## Deskripsi projek
Projek ini dibangun menggunakan bahasa pemrograman PHP, dengan framework Laravel Lumen. Dalam proyek ini terdapat satu fitur untuk user dengan mencangkup
fungsi CRUD (Create, Update, Read, Update, Delete). Fungsi-fungsi yang dibangun memiliki validasi terhadap data yang akan dikirimkan kedatabase berupa tipe data,
panjang karakter, require dan unik. Untuk menjalankan proyek tersebut dapat mengikuti instalasi dibawah ini.
## Setup

1. Clone repository ini.
   - git clone https://github.com/seccret404/Lumen-BeTest.git
3. Install dependensi
   - composer install
4. Buat file .env
5. Salin dari file .env.example ke .env
6. Set environment database  
7. Generate aplikasi key
   - php artisan key:generate
8. Jalankan migrasi database
   - php artisan migrate
9. Jalankan server Lumen
   - php -S localhost:8000 -t public
10. Test endpoint pada postman
    - method : GET => http://localhost:8000/users
    - method : POST => http://localhost:8000/users
    - method : GET => http://localhost:8000/{id}
    - method : PUT => http://localhost:8000/{id}
    - method : DELETE => http://localhost:8000/{id}

## Dokumentasi API With Swagger
Akses dengan enpoint 
=> method : GET => http://localhost:8000/docs

## Testing Unit Test

Untuk menjalankan unit test menggunakan Jest:

1. Open terminal baru pada project
2. Install dependensi Node.js
   - npm install
4. Jalankan test
   - npx jest




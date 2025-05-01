# Clone repository
git clone https://github.com/yourusername/Api_Begin.git
cd Api_Begin

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env to set database config
# (gunakan editor teks untuk ubah DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Jalankan migrasi database
php artisan migrate

# Jalankan server
php artisan serve

# Install Sanctum untuk autentikasi
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

# Tambahkan Sanctum middleware ke file app/Http/Kernel.php
# (gunakan editor teks untuk menambahkan EnsureFrontendRequestsAreStateful di group 'api')

# (Tambahkan route API di routes/api.php)
# Contoh:
# Route::post('/register', [AuthController::class, 'register']);
# Route::post('/login', [AuthController::class, 'login']);
# Route::middleware('auth:sanctum')->group(function () {
#     Route::apiResource('posts', PostController::class);
#     Route::post('/logout', [AuthController::class, 'logout']);
# });

# Gunakan Postman atau Insomnia untuk menguji:
# POST /api/register
# POST /api/login
# Authorization: Bearer {token}

# Tambahkan model dan controller jika perlu
php artisan make:model Post -m
php artisan make:controller PostController --api
php artisan make:controller AuthController

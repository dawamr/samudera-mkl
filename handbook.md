# Laravel Handbook untuk Junior Developer

## 🎯 Pengenalan Laravel

**Laravel** adalah sebuah framework PHP yang dirancang untuk membuat pengembangan web menjadi lebih mudah dan elegan. Laravel mengikuti pola **MVC (Model-View-Controller)** dan menyediakan berbagai fitur canggih yang membantu developer membangun aplikasi web dengan cepat dan efisien.

### Mengapa Laravel?

Jika kamu sudah familiar dengan PHP, Laravel akan membantu kamu:

-   **Struktur Kode yang Rapi**: Laravel mengatur kode dengan pola MVC
-   **Keamanan**: Built-in security features seperti CSRF protection
-   **Database Management**: Eloquent ORM dan migration system
-   **Routing**: Sistem routing yang mudah dipahami
-   **Template Engine**: Blade templating engine yang powerful

---

## 🏗️ Arsitektur Project Ini

Project ini adalah aplikasi **AdminLTE dengan Laravel 10** yang menggunakan berbagai fitur Laravel modern:

### Package Utama Yang Digunakan:

```json
{
    "laravel/framework": "^10.10",
    "laravel/breeze": "^1.23",
    "spatie/laravel-permission": "^6.0",
    "yajra/laravel-datatables": "^10.0",
    "laravel/socialite": "^5.11"
}
```

---

## 🔧 Fitur Laravel yang Digunakan dalam Project Ini

### 1. **MVC Pattern (Model-View-Controller)**

#### **Model** 📊

Models adalah representasi data dan logika bisnis. Contoh dalam project ini:

```php
// app/Models/User.php
<?php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phonenumber', 'provider_id', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

**Fungsi Model:**

-   Berinteraksi dengan database
-   Mendefinisikan relasi antar tabel
-   Validasi data
-   Business logic

#### **View** 👀

Views adalah tampilan yang dilihat user, menggunakan **Blade Template Engine**:

```blade
{{-- resources/views/dashboard.blade.php --}}
<x-admin>
    @section('title','Dashboard')
    <x-dashboard />
</x-admin>
```

**Fitur Blade:**

-   `{{ $variable }}` - Menampilkan data
-   `@section`, `@yield` - Template inheritance
-   `@if`, `@foreach` - Control structures
-   `<x-component>` - Blade components

#### **Controller** 🎮

Controllers menangani logika aplikasi dan menghubungkan Model dengan View:

```php
// app/Http/Controllers/CategoryController.php
class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::orderBy('id','DESC')->get();
        return view('admin.category.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|max:255']);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.category.index')
                        ->with('success','Category created successfully.');
    }
}
```

### 2. **Routing System** 🛣️

Laravel menggunakan sistem routing yang powerful:

```php
// routes/web.php
Route::get('/', function () {
    return redirect('/login');
});

// routes/admin.php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class,'dashboard'])->name('dashboard');
    Route::resource('category', CategoryController::class);
});
```

**Penjelasan:**

-   `Route::get()` - Menangani GET request
-   `Route::post()` - Menangani POST request
-   `Route::resource()` - Membuat CRUD routes otomatis
-   `middleware()` - Menambahkan middleware untuk proteksi
-   `prefix()` - Menambahkan prefix URL
-   `name()` - Memberikan nama untuk route

### 3. **Database Migrations** 📝

Migration adalah cara Laravel mengelola struktur database dengan kode PHP:

```php
// database/migrations/2014_10_12_000000_create_users_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mode')->default('dark');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

**Keuntungan Migration:**

-   Version control untuk database
-   Mudah membuat dan rollback perubahan
-   Konsisten di semua environment
-   Otomatis membuat primary key dan timestamps

### 4. **Eloquent ORM** 🏛️

Eloquent adalah ORM (Object-Relational Mapping) Laravel yang memudahkan interaksi dengan database:

```php
// Mengambil semua data
$categories = Category::all();

// Mengambil dengan kondisi
$category = Category::where('name', 'Technology')->first();

// Membuat data baru
Category::create([
    'name' => 'New Category',
    'slug' => 'new-category'
]);

// Update data
Category::where('id', 1)->update(['name' => 'Updated Name']);

// Delete data
Category::where('id', 1)->delete();
```

### 5. **Authentication & Authorization** 🔐

Project ini menggunakan Laravel Breeze dan Spatie Permission:

```php
// Authentication (Laravel Breeze)
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes
});

// Authorization (Spatie Permission)
Route::middleware(['role:admin'])->group(function(){
    // Admin only routes
});
```

**Fitur Authentication:**

-   Login/Register
-   Email verification
-   Password reset
-   Social login (Google, GitHub, Facebook)
-   OTP login

### 6. **Middleware** 🚧

Middleware adalah filter yang memproses HTTP request:

```php
// app/Http/Kernel.php
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
    \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
];

protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ],
];
```

### 7. **Service & Repository Pattern** 🏪

Project ini menggunakan Services untuk business logic:

```php
// app/Services/ImageService.php
// app/Services/SlugService.php
```

### 8. **Components & Data Providers** 🧩

```php
// app/View/Components/ - Blade components
// app/DataProviders/ - Data providers untuk dropdown, dll
```

---

## 🚀 Cara Menjalankan Project

### **Langkah 1: Prerequisites**

Pastikan terinstall:

-   **PHP 8.1+**
-   **Composer** (Package manager PHP)
-   **Node.js & NPM** (Untuk frontend assets)
-   **MySQL/PostgreSQL** (Database)

### **Langkah 2: Clone & Install Dependencies**

```bash
# Clone project (jika dari git)
git clone <repository-url>
cd adminlte-laravel10

# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### **Langkah 3: Environment Configuration**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit file `.env`:

```env
APP_NAME="AdminLTE Laravel"
APP_ENV=local
APP_KEY=base64:generated-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adminlte_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### **Langkah 4: Database Setup**

```bash
# Buat database MySQL terlebih dahulu, lalu:

# Jalankan migrations
php artisan migrate

# Jalankan seeders (optional)
php artisan db:seed
```

### **Langkah 5: Build Assets**

```bash
# Development mode
npm run dev

# Production mode (untuk deployment)
npm run build
```

### **Langkah 6: Jalankan Server**

```bash
# Development server
php artisan serve

# Aplikasi akan berjalan di http://localhost:8000
```

---

## 📚 Penjelasan Migration - Untuk Pemula

### **Apa itu Migration?**

Migration adalah seperti **"version control untuk database"**. Bayangkan kamu memiliki database di laptop pribadi, laptop kerja, dan server production. Tanpa migration, kamu harus manual membuat tabel yang sama di 3 tempat tersebut.

Dengan migration, kamu cukup menulis kode PHP untuk membuat/mengubah struktur database, lalu jalankan di semua environment.

### **Anatomi Migration File**

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Dijalankan saat migrate
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                          // AUTO_INCREMENT PRIMARY KEY
            $table->string('name');                // VARCHAR(255)
            $table->string('email')->unique();     // VARCHAR(255) UNIQUE
            $table->timestamp('email_verified_at')->nullable(); // TIMESTAMP NULL
            $table->string('password')->nullable(); // VARCHAR(255) NULL
            $table->rememberToken();               // VARCHAR(100) untuk "Remember Me"
            $table->timestamps();                  // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations - Dijalankan saat rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### **Tipe Data Migration**

```php
// Tipe data umum
$table->id();                    // AUTO_INCREMENT PRIMARY KEY
$table->string('name');          // VARCHAR(255)
$table->string('name', 100);     // VARCHAR(100)
$table->text('description');     // TEXT
$table->integer('age');          // INT
$table->boolean('is_active');    // BOOLEAN
$table->decimal('price', 8, 2);  // DECIMAL(8,2)
$table->timestamp('created_at'); // TIMESTAMP
$table->date('birth_date');      // DATE
$table->json('metadata');        // JSON

// Modifiers
$table->string('email')->unique();     // UNIQUE constraint
$table->string('phone')->nullable();   // NULL allowed
$table->integer('count')->default(0);  // Default value
$table->string('status')->index();     // Add index

// Foreign Keys
$table->foreignId('user_id')->constrained(); // References users(id)
$table->foreignId('category_id')->constrained('categories');
```

### **Commands Migration**

```bash
# Membuat migration baru
php artisan make:migration create_products_table
php artisan make:migration add_phone_to_users_table --table=users

# Menjalankan migration
php artisan migrate

# Melihat status migration
php artisan migrate:status

# Rollback migration terakhir
php artisan migrate:rollback

# Rollback semua migration
php artisan migrate:reset

# Rollback dan re-run semua migration
php artisan migrate:refresh

# Rollback dan re-run dengan seeder
php artisan migrate:refresh --seed
```

### **Langkah-langkah Membuat Migration**

#### **1. Buat Migration File**

```bash
php artisan make:migration create_categories_table
```

#### **2. Edit Migration File**

```php
// database/migrations/xxxx_create_categories_table.php
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
```

#### **3. Jalankan Migration**

```bash
php artisan migrate
```

#### **4. Jika Ada Error, Fix & Rollback**

```bash
# Rollback dulu
php artisan migrate:rollback

# Edit file migration
# Jalankan lagi
php artisan migrate
```

### **Migration di Project Ini**

Project ini memiliki migration files:

1. **2014_10_12_000000_create_users_table.php** - Tabel users
2. **2023_10_27_122453_create_permission_tables.php** - Tabel permissions & roles (Spatie)
3. **2023_11_08_035945_create_categories_table.php** - Tabel categories
4. **2023_11_08_044500_create_sub_cateories_table.php** - Tabel sub categories
5. **2023_11_08_052757_create_collections_table.php** - Tabel collections
6. **2023_11_08_070217_create_products_table.php** - Tabel products
7. **2023_12_14_000000_create_country_state_city_table.php** - Tabel lokasi
8. **Dan lainnya...**

---

## 🎯 Contoh Penggunaan dalam Project

### **1. CRUD MKL (Mitra Kerja Logistik)**

MKL adalah fitur utama dalam project ini untuk mengelola data Mitra Kerja Logistik. Berikut implementasi CRUD lengkapnya:

#### **Model MKL**

```php
// app/Models/mkl.php
<?php
class mkl extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'nama_pribadi', 'nama_mkl', 'nama_pt_mkl',
        'no_telepon_pribadi', 'no_telepon_kantor', 'email_kantor',
        'npwp_kantor', 'menggunakan_mtki_payment',
        'alasan_tidak_menggunakan_mtki_payment', 'status_aktif',
        'file_ktp', 'file_npwp'
    ];
}
```

#### **Migration MKL**

```php
// database/migrations/create_mkls_table.php
Schema::create('mkls', function (Blueprint $table) {
    $table->id();
    $table->string('nik', 20)->index();
    $table->string('nama_pribadi', 100)->index();
    $table->string('nama_mkl', 100)->index();
    $table->string('nama_pt_mkl', 100)->index();
    $table->string('no_telepon_pribadi', 20)->nullable();
    $table->string('no_telepon_kantor', 20)->nullable();
    $table->string('email_kantor', 100)->nullable();
    $table->string('npwp_kantor', 100)->nullable();
    $table->enum('menggunakan_mtki_payment', ['Ya', 'Tidak'])->default('Tidak');
    $table->string('alasan_tidak_menggunakan_mtki_payment', 200)->nullable();
    $table->enum('status_aktif', ['Ya', 'Tidak'])->default('Ya');
    $table->string('file_ktp', 100)->nullable();
    $table->string('file_npwp', 100)->nullable();
    $table->timestamps();
});
```

#### **Controller MKL**

```php
// app/Http/Controllers/MklController.php
class MklController extends Controller
{
    // READ - Menampilkan data dengan DataTables (AJAX)
    public function index()
    {
        if (request()->ajax()) {
            $query = mkl::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                    data-toggle="dropdown">Action</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('admin.mkl.edit', $item->nik) . '">Edit</a>
                                <form action="' . route('admin.mkl.destroy', $item->nik) . '" method="POST">
                                    ' . method_field('delete') . csrf_field() . '
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.mkl.index');
    }

    // CREATE - Form create
    public function create()
    {
        return view('admin.mkl.create');
    }

    // CREATE - Simpan data dengan validasi dan upload file
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nik' => 'required|unique:mkls,nik',
                'nama_pribadi' => 'required',
                'nama_mkl' => 'required',
                'nama_pt_mkl' => 'required',
                'no_telepon_pribadi' => 'required',
                'no_telepon_kantor' => 'required',
                'email_kantor' => 'required|email|unique:mkls,email_kantor',
                'npwp_kantor' => 'required|unique:mkls,npwp_kantor',
                'menggunakan_mtki_payment' => 'required|boolean',
                'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,0',
                'status_aktif' => 'required|boolean',
                'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_npwp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // Upload file KTP
            if ($request->hasFile('file_ktp')) {
                $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
                $validatedData['file_ktp'] = $ktpPath;
            }

            // Upload file NPWP
            if ($request->hasFile('file_npwp')) {
                $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
                $validatedData['file_npwp'] = $npwpPath;
            }

            mkl::create($validatedData);

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menambahkan MKL: ' . $e->getMessage());
        }
    }

    // UPDATE - Form edit
    public function edit(mkl $mkl)
    {
        return view('admin.mkl.edit', compact('mkl'));
    }

    // UPDATE - Update data
    public function update(Request $request, mkl $mkl)
    {
        try {
            $validatedData = $request->validate([
                'nama_pribadi' => 'required',
                'nama_mkl' => 'required',
                'nama_pt_mkl' => 'required',
                'no_telepon_pribadi' => 'required',
                'no_telepon_kantor' => 'required',
                'email_kantor' => 'required|email|unique:mkls,email_kantor,' . $mkl->nik . ',nik',
                'npwp_kantor' => 'required|unique:mkls,npwp_kantor,' . $mkl->nik . ',nik',
                'menggunakan_mtki_payment' => 'required|boolean',
                'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,0',
                'status_aktif' => 'required|boolean',
                'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // Update file KTP jika ada
            if ($request->hasFile('file_ktp')) {
                Storage::disk('public')->delete($mkl->file_ktp);
                $ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');
                $validatedData['file_ktp'] = $ktpPath;
            }

            // Update file NPWP jika ada
            if ($request->hasFile('file_npwp')) {
                Storage::disk('public')->delete($mkl->file_npwp);
                $npwpPath = $request->file('file_npwp')->store('mkl/npwp', 'public');
                $validatedData['file_npwp'] = $npwpPath;
            }

            $mkl->update($validatedData);

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal memperbarui MKL: ' . $e->getMessage());
        }
    }

    // DELETE - Hapus data dan file
    public function destroy(mkl $mkl)
    {
        try {
            // Hapus file dari storage
            Storage::disk('public')->delete([$mkl->file_ktp, $mkl->file_npwp]);

            // Hapus data dari database
            $mkl->delete();

            return redirect()->route('admin.mkl.index')
                ->with('success', 'MKL berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('admin.mkl.index')
                ->with('error', 'Gagal menghapus MKL: ' . $e->getMessage());
        }
    }

    // API untuk statistik
    public function getMTKIPaymentStats()
    {
        $stats = [
            'using_mtki' => mkl::where('menggunakan_mtki_payment', 'Ya')->count(),
            'not_using_mtki' => mkl::where('menggunakan_mtki_payment', 'Tidak')->count(),
        ];

        return response()->json($stats);
    }
}
```

#### **Fitur Khusus dalam CRUD MKL:**

**1. Primary Key Non-Increment:**

```php
protected $primaryKey = 'nik';     // Menggunakan NIK sebagai primary key
public $incrementing = false;       // Tidak auto increment
protected $keyType = 'string';      // Tipe data string
```

**2. Validasi dengan Conditional Rules:**

```php
'alasan_tidak_menggunakan_mtki_payment' => 'required_if:menggunakan_mtki_payment,0'
// Field ini wajib diisi jika tidak menggunakan MTKI payment
```

**3. File Upload Management:**

```php
// Simpan file
$ktpPath = $request->file('file_ktp')->store('mkl/ktp', 'public');

// Hapus file lama saat update
Storage::disk('public')->delete($mkl->file_ktp);

// Validasi file
'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
```

**4. DataTables Integration:**

```php
return DataTables::of($query)
    ->addColumn('action', function ($item) {
        // Custom action buttons
    })
    ->rawColumns(['action'])
    ->make(true);
```

**5. Exception Handling:**

```php
try {
    // Database operations
} catch (\Exception $e) {
    return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
}
```

### **2. Route Configuration untuk MKL**

```php
// routes/admin.php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['role:admin'])->group(function(){
        // Resource routes untuk CRUD MKL
        Route::resource('mkl', MklController::class)->parameters([
            'mkl' => 'mkl'  // Parameter binding menggunakan NIK
        ]);

        // API routes untuk statistik MKL
        Route::get('mkl-payment-stats', [MklController::class, 'getMTKIPaymentStats'])
             ->name('mkl.payment.stats');
        Route::get('mkl-reason-stats', [MklController::class, 'getMTKIReasonStats'])
             ->name('mkl.reason.stats');
    });
});
```

**Penjelasan Route MKL:**

-   `parameters(['mkl' => 'mkl'])` - Custom parameter untuk route model binding dengan NIK
-   Route resource otomatis membuat 7 routes: index, create, store, show, edit, update, destroy
-   Route API tambahan untuk statistik dashboard
-   Semua route dilindungi middleware `auth`, `verified`, dan `role:admin`

### **3. Blade Template untuk MKL**

```blade
{{-- resources/views/admin/mkl/index.blade.php --}}
<x-admin>
    @section('title', 'Data MKL')

    <div class="content-wrapper">
        <div class="content-header">
            <h1>Data Mitra Kerja Logistik</h1>
        </div>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.mkl.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah MKL
                    </a>
                </div>

                <div class="card-body">
                    <table id="mkl-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Pribadi</th>
                                <th>Nama MKL</th>
                                <th>Nama PT</th>
                                <th>Email Kantor</th>
                                <th>MTKI Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $('#mkl-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.mkl.index") }}',
            columns: [
                {data: 'nik', name: 'nik'},
                {data: 'nama_pribadi', name: 'nama_pribadi'},
                {data: 'nama_mkl', name: 'nama_mkl'},
                {data: 'nama_pt_mkl', name: 'nama_pt_mkl'},
                {data: 'email_kantor', name: 'email_kantor'},
                {data: 'menggunakan_mtki_payment', name: 'menggunakan_mtki_payment'},
                {data: 'status_aktif', name: 'status_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
    @endpush
</x-admin>
```

### **4. Form Validation dan Error Handling**

```php
// Form Request untuk MKL
class MklRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'nik' => 'required|unique:mkls,nik',
            'nama_pribadi' => 'required|string|max:100',
            'email_kantor' => 'required|email|unique:mkls,email_kantor',
            'menggunakan_mtki_payment' => 'required|boolean',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // Conditional validation
        if ($this->menggunakan_mtki_payment == 0) {
            $rules['alasan_tidak_menggunakan_mtki_payment'] = 'required|string|max:200';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'email_kantor.email' => 'Format email tidak valid',
            'file_ktp.required' => 'File KTP wajib diunggah',
            'file_ktp.mimes' => 'File KTP harus berformat PDF, JPG, JPEG, atau PNG',
        ];
    }
}
```

---

## 🔧 Troubleshooting Umum

### **Error: "No application encryption key has been specified"**

```bash
php artisan key:generate
```

### **Error: Database connection**

-   Pastikan database sudah dibuat
-   Cek konfigurasi .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
-   Pastikan MySQL/PostgreSQL sudah running

### **Error: "Class not found"**

```bash
composer dump-autoload
```

### **Migration Error**

```bash
# Lihat status migration
php artisan migrate:status

# Rollback dan coba lagi
php artisan migrate:rollback
php artisan migrate
```

### **NPM/Node.js Error**

```bash
# Clear cache
npm cache clean --force
rm -rf node_modules
npm install
```

---

## 📖 Resources untuk Belajar Lebih Lanjut

1. **Laravel Documentation**: https://laravel.com/docs
2. **Laracasts**: https://laracasts.com (Video tutorials terbaik)
3. **Laravel Daily**: https://laraveldaily.com
4. **Laravel News**: https://laravel-news.com

---

## 🎉 Kesimpulan

Laravel adalah framework yang powerful dan mudah dipelajari. Dengan memahami konsep dasar seperti:

-   **MVC Pattern**
-   **Migration & Eloquent ORM**
-   **Routing & Middleware**
-   **Blade Templates**
-   **Authentication**

Kamu sudah bisa membangun aplikasi web yang robust dan scalable.

Project AdminLTE Laravel 10 ini menggunakan semua fitur modern Laravel dan merupakan contoh yang baik untuk dipelajari. Mulai dengan memahami alur CRUD sederhana, lalu pelajari fitur-fitur advanced secara bertahap.

**Happy Coding! 🚀**

---

_Handbook ini dibuat untuk membantu junior developer memahami Laravel. Jika ada pertanyaan atau butuh penjelasan lebih detail tentang fitur tertentu, jangan ragu untuk bertanya!_

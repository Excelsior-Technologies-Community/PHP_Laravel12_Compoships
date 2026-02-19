# PHP_Laravel12_Compoships

# Step 1: Install Laravel 12 – Create Project
Open Terminal / CMD:
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_Compoships
```
Move to project folder:
```php
cd PHP_Laravel12_Compoships
```
Generate application key:
```php
php artisan key:generate
```
# Explanation
```php
- Laravel uses an application key for encryption & security
- Required for sessions, cookies, encrypted data
- Application will not work correctly without APP_KEY
```

# Step 2: Setup Database (.env File)
Open .env file and configure database credentials:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_compoships
DB_USERNAME=root
DB_PASSWORD=
```
Create database in MySQL / phpMyAdmin:
```php
CREATE DATABASE laravel12_compoships;
```
Run default migrations:
```php
php artisan migrate
```

# Step 3: Install Compoships Package
Install the package:
```php
composer require awobaz/compoships
```
# Explanation
```php
- Adds support for composite key relationships
- Extends Laravel Eloquent ORM
- Used in production-grade Laravel applications
- Laravel 12 supports auto package discovery
```

# Step 4: Create Models with Migrations
Create Order model:
```php
php artisan make:model Order -m
```
Create OrderItem model:
```php
php artisan make:model OrderItem -m
```
# Step 5: Database Migrations
Orders Table Migration

Path:
```php
database/migrations/xxxx_create_orders_table.php
```
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_no');
        $table->unsignedBigInteger('store_id');
        $table->string('customer_name');
        $table->timestamps();

        $table->unique(['order_no', 'store_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
```
Order Items Table Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->string('order_no');
        $table->unsignedBigInteger('store_id');
        $table->string('product_name');
        $table->integer('qty');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
```
Run migrations:
```php
php artisan migrate
```
# Step 6: Configure Models for Compoships
Order Model
Path: app/Models/Order.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Order extends Model
{
    use Compoships;

    protected $fillable = [
        'order_no',
        'store_id',
        'customer_name'
    ];

    public function items()
    {
        return $this->hasMany(
            OrderItem::class,
            ['order_no', 'store_id'],
            ['order_no', 'store_id']
        );
    }
}
```
OrderItem Model
Path: app/Models/OrderItem.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class OrderItem extends Model
{
    use Compoships;

    protected $fillable = [
        'order_no',
        'store_id',
        'product_name',
        'qty'
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            ['order_no', 'store_id'],
            ['order_no', 'store_id']
        );
    }
}
```
# Explanation
```php
- use Compoships; enables composite relations
- Relationship keys are defined using arrays
- This is the core feature of the project
```
# Step 7: Create Controller
Create controller:
```php
php artisan make:controller OrderController
```
```php
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
{
    return view('orders.create');
}

public function store(Request $request)
{
    $request->validate([
        'order_no' => 'required',
        'store_id' => 'required',
        'customer_name' => 'required',
        'product_name.*' => 'required',
        'qty.*' => 'required|integer|min:1',
    ]);

    Order::create($request->only('order_no','store_id','customer_name'));

    foreach ($request->product_name as $i => $product) {
        OrderItem::create([
            'order_no' => $request->order_no,
            'store_id' => $request->store_id,
            'product_name' => $product,
            'qty' => $request->qty[$i],
        ]);
    }

   return redirect('/orders-list')
        ->with('success', 'Order created successfully');

}

public function list()
{
    $orders = Order::with('items')->get();
    return view('orders.index', compact('orders'));
}


    public function index()
    {
        return Order::with('items')->get();
    }
    
}
```

# Step 8: Define Web Routes
Path: routes/web.php
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/create', [OrderController::class, 'create']);
Route::post('/orders/store', [OrderController::class, 'store']);
Route::get('/orders-list', [OrderController::class, 'list']);
```
# Step 9: Blade UI Structure
```php
resources/views/
 ├── layouts/
 │   └── app.blade.php
 └── orders/
     ├── create.blade.php
     └── index.blade.php
```
# Step 10: Run Laravel 12 Project
Run development server:
```php
php artisan serve
```
# Open browser:
Create Order Page:
```php
http://127.0.0.1:8000/orders/create
```
<img width="1345" height="673" alt="image" src="https://github.com/user-attachments/assets/589ac1b6-2e19-4ec6-a7eb-fe51ace3d539" />

Orders List Page:
```php
http://127.0.0.1:8000/orders-list
```
<img width="1341" height="680" alt="image" src="https://github.com/user-attachments/assets/780bb796-8bd2-4a39-bacb-dc15ca7e2138" />

# Project Folder Structure
```php
PHP_Laravel12_Compoships
├── app
│   ├── Http
│   │   └── Controllers
│   │       └── OrderController.php
│   └── Models
│       ├── Order.php
│       └── OrderItem.php
│
├── database
│   └── migrations
│       ├── create_orders_table.php
│       └── create_order_items_table.php
│
├── resources
│   └── views
│       ├── layouts
│       │   └── app.blade.php
│       └── orders
│           ├── create.blade.php
│           └── index.blade.php
│
├── routes
│   └── web.php
│
├── .env
├── artisan
```





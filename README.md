Step 1 – Install laravel  
composer create-project --prefer-dist laravel/laravel project_name

Step 2 – Database configuration

find .env file and configure database detail like following.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db name
DB_USERNAME=db user name
DB_PASSWORD=db password

Step 3 – smtp email configuration

find .env file and configure mail detail like following.

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=abc@gmail.com
MAIL_PASSWORD=123456789


Step 4 – Install Spatie Composer Packages users with roles and permissions

In this step, execute the following command on terminal to install Spatie package and html form collection package..

composer require spatie/laravel-permission

composer require laravelcollective/html

Then add the following lines of code into app.php, which is placed inside config directory

'providers' => [ patie\Permission\PermissionServiceProvider::class, ],

After that, execute the following command on terminal to publish spatie package dependencies:

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"


Step 5 – Create Model and Migration


php artisan make:model User -m
php artisan make:model Category -m
php artisan make:model Product -m


Step 6 – Register Middleware

protected $routeMiddleware = [
    ....
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
]


Step 7 – Create Controllers


php artisan make controller UserController
php artisan make controller RoleController
php artisan make controller CategoryController
php artisan make controller ProductController



Step 8 – Install Laravel UI

In this step, install LARAVEL ui package in laravel app by using the following command:

composer require laravel/ui


Step 9 – Install Bootstrap Auth Scaffolding

In this step, install auth scaffolding bootstrap package in laravel app by using the following command:

php artisan ui bootstrap --auth


Given command on terminal to create tables in database:

php artisan migrate


Step 10: Create Seeder For Permissions and AdminUser


So, first create seeder using bellow command:

php artisan make:seeder PermissionTableSeeder


<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}

After this we have to run bellow command for run PermissionTableSeeder seeder:


Now let's create new seeder for creating super admin user.

php artisan make:seeder CreateSuperAdminUserSeeder


<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Hardik Savani', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $role = Role::create(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}


After this we have to run bellow command for run CreateSuperAdminUserSeeder seeder:

php artisan db:seed --class=CreateSuperAdminUserSeeder# data-management-system

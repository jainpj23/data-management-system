Step 1 – Git clone 

https://github.com/jainpj23/data-management-system.git 

Step 2 - update composer give laravel project root folder

CMD : composer update

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


Step 4 – Install Spatie Composer Packages users with roles and permissions when package not available

In this step, execute the following command on terminal to install Spatie package and html form collection package..

composer require spatie/laravel-permission

composer require laravelcollective/html

Then add the following lines of code into app.php, which is placed inside config directory

'providers' => [ patie\Permission\PermissionServiceProvider::class, ],

After that, execute the following command on terminal to publish spatie package dependencies:

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"


Step 5 – Register Middleware when not available in So, we have to add middleware in Kernel.php file this way :

app/Http/Kernel.php

protected $routeMiddleware = [
    ....
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
]



Step 8 – Install Laravel UI when not available

In this step, install LARAVEL ui package in laravel app by using the following command:

composer require laravel/ui


Step 9 – Install Bootstrap Auth Scaffolding when not availabel in package

In this step, install auth scaffolding bootstrap package in laravel app by using the following command:

php artisan ui bootstrap --auth


Step 10: Given command on terminal to create tables in database:

php artisan migrate


Step 11: execute Seeder For Permissions and SuperAdmin

we have to run bellow Seeder command for run

1) php artisan db:seed --class=PermissionTableSeeder
2) php artisan db:seed --class=CreateSuperAdminUserSeeder



<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\User;
use App\Role;
use App\Role_Users;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('createall', function () {
    $roleAdmin = Role::create([
        'id' => Str::uuid(),
        'name' => 'admin',
    ]);

    $roleUser = Role::create([
        'id' => Str::uuid(),
        'name' => 'user',
    ]);


    $user = User::create([
        'id' => Str::uuid(),
        'name' => 'Indrawan',
        'password' => bcrypt("123456"),
    ]);

    // $cek_user_role = App\Role_Users::where("user_id", "=", $user->id);
    $role_user = Role_Users::create([
        'id' => Str::uuid(),
        'role_id' => $roleAdmin->id,
        'user_id' => $user->id,
    ]);

    return $role_user;
});


Route::get('role/create', function () {
    $role = Role::create([
        'id' => Str::uuid(),
        'name' => 'admin',
    ]);

    return $role;
});

Route::get('users/create', function () {

    $user = User::create([
        'id' => Str::uuid(),
        'name' => 'Indrawan',
        'password' => bcrypt("123456"),
    ]);

    return $user;
});

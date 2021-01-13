<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Role;

class RoleController extends Controller
{
    function add()
    {
        $role = Role::create([
            'id' => Str::uuid(),
            'name' => 'admin',
        ]);

        return $role;
    }
}

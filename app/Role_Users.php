<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_Users extends Model
{
    protected $table  = 'tbrole_has_users';

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected $fillable = [
        'id', 'role_id', 'user_id',
    ];
}

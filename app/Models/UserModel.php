<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_ormawa',
        'id_dosen',
        'username',
        'email',
        'no_telp',
        'password',
        'role',
        'foto',
        'reset_token',
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table      = 'visitor_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ip_address',
        'user_agent',
        'visited_at'
    ];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'chat_history';
    protected $primaryKey       = 'id_chat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user', 'session_id', 'role', 'message'];

    public function simpanPesan($session_id, $role, $message, $id_user = null)
    {
        return $this->insert([
            'id_user'    => $id_user,
            'session_id' => $session_id,
            'role'       => $role,
            'message'    => $message
        ]);
    }

    public function getHistory($session_id, $limit = 20)
    {
        return $this->where('session_id', $session_id)
                    ->orderBy('created_at', 'ASC')
                    ->limit($limit)->findAll();
    }

    public function hapusHistory($session_id)
    {
        return $this->where('session_id', $session_id)->delete();
    }
}
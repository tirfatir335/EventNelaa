<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'user_permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_user', 'module', 'can_view', 'can_create', 'can_edit', 'can_delete'];

    /**
     * Ambil semua permission untuk 1 user
     */
    public function getByUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

    /**
     * Ambil permission 1 user untuk modul tertentu
     */
    public function getByUserModule($id_user, $module)
    {
        return $this->where('id_user', $id_user)
                    ->where('module', $module)
                    ->first();
    }

    /**
     * Simpan permission (hapus lama, insert baru)
     */
    public function simpanPermissions($id_user, $permissions = [])
    {
        // Hapus semua permission lama user ini
        $this->where('id_user', $id_user)->delete();

        // Insert permission baru
        foreach ($permissions as $module => $actions) {
            // Skip jika semua aksi false
            if (empty($actions['view']) && empty($actions['create']) 
                && empty($actions['edit']) && empty($actions['delete'])) {
                continue;
            }

            $this->insert([
                'id_user'    => $id_user,
                'module'     => $module,
                'can_view'   => !empty($actions['view'])   ? 1 : 0,
                'can_create' => !empty($actions['create']) ? 1 : 0,
                'can_edit'   => !empty($actions['edit'])   ? 1 : 0,
                'can_delete' => !empty($actions['delete']) ? 1 : 0,
            ]);
        }

        return true;
    }

    /**
     * Cek apakah user punya akses ke modul + action tertentu
     */
    public function hasAccess($id_user, $module, $action = 'view')
    {
        $permission = $this->getByUserModule($id_user, $module);
        
        if (!$permission) {
            return false;
        }

        $column = 'can_' . $action;
        return !empty($permission[$column]);
    }

    /**
     * Ambil semua modul yang bisa diakses user (untuk sidebar)
     */
    public function getModules($id_user)
    {
        $permissions = $this->where('id_user', $id_user)
                            ->where('can_view', 1)
                            ->findAll();
        
        return array_column($permissions, 'module');
    }
}
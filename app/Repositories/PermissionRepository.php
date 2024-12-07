<?php

namespace App\Repositories;

use App\Interfaces\PermissionRepositoryInterface;
use App\Models\KACL\PermissionModel;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
    }

    public function findPermissionById(int $permissionId)
    {
        return $this->permissionModel->find($permissionId);
    }

    public function findPermissionByKey(string $permissionKey)
    {
        return $this->permissionModel->where('key', $permissionKey)->first();
    }

    public function createPermission(string $permissionKey, string $description): bool
    {
        $data = [
            'key' => $permissionKey,
            'description' => $description,
        ];

        return (bool)$this->permissionModel->insert($data);
    }

    public function updatePermission(int $permissionId, array $permissionData): bool
    {
        return (bool)$this->permissionModel->update($permissionId, $permissionData);
    }

    public function deletePermission(int $permissionId): bool
    {
        return (bool)$this->permissionModel->delete($permissionId);
    }

    // Implementa los demás métodos definidos en PermissionRepositoryInterface según las necesidades de tu aplicación.
}

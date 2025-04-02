<?php

namespace App\Models;

use App\Modules\Admins\Models\Admin;

class Role extends \Spatie\Permission\Models\Role
{
    protected $fillable = ['name', 'guard_name'];

    public function getTotalAdmins(): int
    {
        $total = 0;
        foreach (Admin::all() as $admin) {
            if ($admin->hasRole($this->name)) $total++;
        }

        return $total;
    }

    public function getAdmins(): array
    {
        $admins = [];
        foreach (Admin::all() as $admin) {
            if ($admin->hasRole($this->name)) $admins[] = $admin;
        }

        return $admins;
    }
}

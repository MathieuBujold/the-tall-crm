<?php

namespace App\Models\Concerns;

use App\Enum\AppPermission;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Cache;

trait HasFixedPermissions
{
    public function permissionsRelation() // nom non collision avec Enum
    {
        return $this->hasMany(\App\Models\UserPermission::class);
    }

    public function permissionNames(): array
    {
        $cacheMinute = 0;
        $key = "user:{$this->id}:permissions";
        return Cache::remember($key, now()->addMinutes($cacheMinute), function () {
            return $this->permissionsRelation()->pluck('permission')->all();
        });
    }

    public function hasPermission(AppPermission|string $permission): bool
    {
        $perm = $permission instanceof AppPermission ? $permission->value : $permission;
        return in_array($perm, $this->permissionNames(), true);
    }

    // Gestion
    public function givePermission(AppPermission|string $permission): void
    {
        $perm = $permission instanceof AppPermission ? $permission->value : $permission;
        $this->permissionsRelation()->firstOrCreate(['permission' => $perm]);
        Cache::forget("user:{$this->id}:permissions");
    }

    public function revokePermission(AppPermission|string $permission): void
    {
        $perm = $permission instanceof AppPermission ? $permission->value : $permission;
        $this->permissionsRelation()->where('permission', $perm)->delete();
        Cache::forget("user:{$this->id}:permissions");
    }

    public function syncPermissions(array $permissions): void
    {
        $names = array_map(fn($p) => $p instanceof AppPermission ? $p->value : (string) $p, $permissions);
        $this->permissionsRelation()->whereNotIn('permission', $names)->delete();
        foreach ($names as $n) {
            $this->permissionsRelation()->firstOrCreate(['permission' => $n]);
        }
        Cache::forget("user:{$this->id}:permissions");
    }
}

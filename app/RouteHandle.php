<?php

namespace App;

trait RouteHandle
{
    public function getRoutePrefix()
    {
        $user = auth()->user();

        if ($user) {
            $role = strtolower($user->getRoleNames()->first());
            // If the role has its own dedicated view directory, return it
            if (in_array($role, ['dealer', 'user', 'student'])) {
                return $role;
            }
            // For all other internal staff/admin roles (like accounts, hr), use the 'admin' views
            return 'admin';
        }

        return 'admin';
    }
}

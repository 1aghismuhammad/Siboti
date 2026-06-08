<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function authorizeRole(string $role): void
    {
        abort_unless(auth()->check() && auth()->user()->hasRole($role), 403);
    }

    protected function authorizeAnyRoles(array $roles): void
    {
        abort_unless(auth()->check() && auth()->user()->hasAnyRole($roles), 403);
    }
}

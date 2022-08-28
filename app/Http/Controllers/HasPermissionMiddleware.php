<?php

namespace App\Http\Controllers;

trait HasPermissionMiddleware
{
    public function __construct()
    {
        $this->setMiddleware();
    }

    protected function setMiddleware(): void
    {
        if ($permission = $this->getPermissionScope(self::PERMISSION_SCOPE)) {
            $this->middleware('has.permission:' . $permission);
        }
    }

    protected function getPermissionScope(string $permission_scope): ?string
    {
        $action = match (request()?->method()) {
            'GET' => 'get',
            'POST', 'PUT', 'PATCH' => 'publish',
            'DELETE' => 'delete',
            default => null,
        };

        return $action ? $permission_scope . '-' . $action : null;
    }
}

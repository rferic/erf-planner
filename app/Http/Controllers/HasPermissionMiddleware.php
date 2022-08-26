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
        $action = match (request()?->method()) {
            'GET' => 'get',
            'POST', 'PUT', 'PATCH' => 'publish',
            'DELETE' => 'delete',
            default => null,
        };

        if ($action) {
            $this->middleware('has.permission:' . self::PERMISSION_SCOPE . '-' . $action);
        }
    }
}

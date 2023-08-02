<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $routeName = $request->route()->getName();

        $slices = explode(".", $routeName);

        if ($slices[0] == 'student') {
            return $request->expectsJson() ? null : route('student.login', ['to' => $request->route()->getName()]);
        }

        elseif ($slices[0] == 'admin') {
            return $request->expectsJson() ? null : route('admin.login', ['to' => $request->route()->getName()]);
        }

        return null;
    }
}

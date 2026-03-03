<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isTeacher()) {
            abort(403, 'Chỉ giáo viên mới có quyền truy cập.');
        }

        return $next($request);
    }
}

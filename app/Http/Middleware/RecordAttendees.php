<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordAttendees
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->canRecordAttendees()) {
            abort(403);
        }

        return $next($request);
    }
}

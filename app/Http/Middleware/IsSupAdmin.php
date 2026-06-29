<?php
// app/Http/Middleware/IsSupAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSupAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        $role = Auth::guard('admin')->user()->role;

        if (! in_array($role, ['admin', 'supadmin'])) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
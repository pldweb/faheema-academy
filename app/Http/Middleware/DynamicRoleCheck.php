<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DynamicRoleCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. Cek Login
        if (! $user) {
            return redirect()->route('login'); // Atau abort(401);
        }

        // 2. Dewa (Super Admin) bebas lewat
        if ($user->hasRole('administrator')) {
            return $next($request);
        }

        // 3. Deteksi mau ke mana (Target Permission)
        $route = $request->route();
        $actionNameFull = $route->getActionName();

        if (! str_contains($actionNameFull, '@')) {
            return $next($request); // Bukan controller standard, loloskan
        }

        $controllerClass = class_basename($route->getController()); // ProductController
        $methodName = $route->getActionMethod(); // postCreate

        // Bersihkan nama (Sama logicnya dengan Robot Scanner tadi)
        $resource = Str::kebab(str_replace('Controller', '', $controllerClass)); // product

        // Hapus prefix verb (get, post, dll)
        $action = preg_replace('/^(get|post|put|delete|patch)/', '', $methodName); // Create
        $action = Str::kebab($action); // create

        if (empty($action) && str_contains(strtolower($methodName), 'index')) {
            $action = 'index';
        }

        $requiredPermission = $resource.'.'.$action; // product.create

        // 4. Cek Izin di Database
        if ($user->can($requiredPermission)) {
            return $next($request);
        }

        // 5. Tendang jika tak punya izin
        abort(403, "AKSES DITOLAK: Anda butuh izin '$requiredPermission'");
    }
}

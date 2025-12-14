<?php

namespace App\Providers;

use App\Http\Middleware\DynamicRoleCheck;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
// Import Middleware Satpam kita
use ReflectionMethod;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->map();
        Paginator::useBootstrapFive();
    }

    public function map()
    {
        $this->mapDynamicRoutes();
    }

    public function mapDynamicRoutes()
    {
        $controllerPath = app_path('Http/Controllers');
        $namespace = 'App\Http\Controllers';

        // Mulai scan dari folder Controllers
        $this->registerRoutesFromFolder($controllerPath, $namespace);

        // Fallback jika route tidak ditemukan
        Route::fallback(function () {
            // Pastikan view ini ada, atau ganti jadi abort(404)
            if (view()->exists('pages.error.404')) {
                return response()->view('pages.error.404', [], 404);
            }
            abort(404);
        });
    }

    public function registerRoutesFromFolder($folder, $namespace, $prefix = '')
    {
        // Scan setiap file di dalam folder controller
        foreach (scandir($folder) as $file) {

            // Skip . dan ..
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $folder.DIRECTORY_SEPARATOR.$file;
            $className = pathinfo($file, PATHINFO_FILENAME);

            if (is_dir($fullPath)) {
                $folderPrefix = Str::kebab($className).'/';
                $this->registerRoutesFromFolder(
                    $fullPath,
                    $namespace.'\\'.$className,
                    $prefix.$folderPrefix
                );

            } elseif (str_ends_with($file, 'Controller.php')) {
                $controllerClass = $namespace.'\\'.$className;

                if (class_exists($controllerClass)) {
                    $this->registerRoutesFromController($controllerClass, $prefix);
                }
            }
        }
    }

    protected function registerRoutesFromController($controllerClass, $prefix)
    {
        $reflection = new ReflectionClass($controllerClass);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $controllerName = $reflection->getShortName();
        $namespace = $reflection->getNamespaceName();

        // 1. Tentukan Prefix URL
        if ($controllerName === 'HomeController' || $controllerName === 'LandingController') {
            $prefix = '/';
        } else {
            $cName = str_replace('Controller', '', $controllerName);
            $cName = Str::kebab($cName);
            $prefix .= $cName.'/';
        }

        $isAuthController = str_contains($namespace, 'App\Http\Controllers\Auth');

        $isApiController = str_contains($namespace, 'App\Http\Controllers\Api');

        $isPublicController = ($controllerName === 'HomeController' || $controllerName === 'LandingController');

        $middlewareGroup = $isApiController ? ['api'] : ['web'];

        Route::middleware($middlewareGroup)->group(function () use ($methods, $controllerClass, $prefix, $isAuthController, $isPublicController, $isApiController) {

            foreach ($methods as $method) {
                if ($method->class !== $controllerClass || $method->isConstructor()) {
                    continue;
                }

                $methodName = $method->name;
                preg_match('/^(get|post|put|delete|patch)(.+)$/', $methodName, $matches);

                if (count($matches) === 3) {
                    [$fullMatch, $httpVerb, $name] = $matches;
                    $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));

                    if ($routeName === 'index') {
                        $routeName = '';
                    }

                    $fullRoute = rtrim($prefix, '/').($routeName ? '/'.$routeName : '');
                    $parameters = $method->getParameters();
                    $routeParameters = $this->buildRouteParameters($parameters);

                    if ($isAuthController || $isPublicController || $isApiController) {

                        $route = Route::match(
                            strtolower($httpVerb),
                            $fullRoute.$routeParameters['url'],
                            [$controllerClass, $methodName]
                        );

                        if (! empty($routeParameters['where'])) {
                            $route->where($routeParameters['where']);
                        }

                        if ($routeName === 'login' && strtolower($httpVerb) === 'get') {
                            $route->name('login');
                        }

                    } else {

                        Route::middleware(['auth', DynamicRoleCheck::class])->group(function () use ($httpVerb, $fullRoute, $controllerClass, $methodName, $routeParameters) {
                            $route = Route::match(
                                strtolower($httpVerb),
                                $fullRoute.$routeParameters['url'],
                                [$controllerClass, $methodName]
                            );

                            if (! empty($routeParameters['where'])) {
                                $route->where($routeParameters['where']);
                            }
                        });
                    }
                }
            }
        });
    }

    protected function buildRouteParameters($parameters)
    {
        if (empty($parameters)) {
            return [
                'url' => '',
                'where' => [],
            ];
        }

        $urlParts = [];
        $whereConstraints = [];

        foreach ($parameters as $param) {
            $paramName = $param->getName();
            $paramType = $param->getType();

            if ($paramType && ! $paramType->isBuiltin()) {
                continue;
            }

            $isOptional = $param->isOptional();
            $urlParts[] = '{'.$paramName.($isOptional ? '?' : '').'}';
            $whereConstraints[$paramName] = '[^/]+';
        }

        return [
            'url' => empty($urlParts) ? '' : '/'.implode('/', $urlParts),
            'where' => $whereConstraints,
        ];
    }
}

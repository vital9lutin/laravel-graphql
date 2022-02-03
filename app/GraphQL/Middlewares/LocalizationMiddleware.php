<?php

namespace App\GraphQL\Middlewares;

use App\GraphQL\Traits\Auth\AuthGuardsTrait;
use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
{
    use AuthGuardsTrait;

    public function handle(Request $request, Closure $next)
    {
        $lang = array_filter([/*Languages*/], static function ($val) use ($request) {
            return $val['code'] === $request->getPreferredLanguage();
        });

        $lang = empty($lang) ? /*Languages def*/ : key($lang);

        app()->setLocale($lang);

        return $next($request);
    }
}

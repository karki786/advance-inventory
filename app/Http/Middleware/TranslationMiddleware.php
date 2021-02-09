<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Company;

class TranslationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $language = Company::find(Auth::user()->companyId)->language;
            Session::put('stockawesome.language_locale', $language);
            app()->setLocale(Session::get('stockawesome.language_locale'));
        }
        return $next($request);
    }
}

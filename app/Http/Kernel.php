<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Local::class,
            \App\Http\Middleware\ShowMenu::class,
        ],

        'api' => [
            // 'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'telpProfile' => \App\Http\Middleware\confirmTelpProfile::class,
        'telpUbahPassword' => \App\Http\Middleware\confirmTelpUbahPassword::class,
        'telpDana' => \App\Http\Middleware\confirmTelpDana::class,
        'checkSingle' => \App\Http\Middleware\CheckUserSession::class,
        'checkInvestor' => \App\Http\Middleware\CheckInvestorSession::class,
        'userCheck' => \App\Http\Middleware\UserCheck::class,
        'brwCheck' => \App\Http\Middleware\brwCheck::class,
		'CheckUserSessionBorrower' => \App\Http\Middleware\CheckUserSessionBorrower::class,

        //page speed laravel
        \RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
        \RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class,
    ];
}

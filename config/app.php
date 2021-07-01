<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    // 'env' => env('APP_ENV','production'),
    'env' => env('APP_ENV'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    // 'url' => env('APP_URL','https://www.danasyariah.id'),
    'url' => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Jakarta',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    // 'locale' => 'en',
    'locale' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    // 'fallback_locale' => 'en',
    'fallback_locale' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        Riskihajar\Terbilang\TerbilangServiceProvider::class,
        Harimayco\Menu\MenuServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cart' => App\Facades\Cart::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Terbilang' => Riskihajar\Terbilang\Facades\Terbilang::class,
        'Menu' => Harimayco\Menu\Facades\Menu::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,

    ],

    'userid' => env('USERID'),
    'api_digisign' => env('API_DIGISIGN'),
    // 'content_type' => env('CONTENT_TYPE'),
    'boundary' => env('BOUNDARY'),
    'authorization' => env('AUTHORIZATION'),
    'token' => env('TOKEN'),
    'apilink' => env('APILINK'),
    'clientlink' => env('CLIENTLINK'),
    'link_digisign' => env('LINK_DIGISIGN'),

    'email_pak_taufiq' => env('EMAIL_PAK_TAUFIQ'),

    'pefindo_user' => env('PEFINDO_USER'),
    'pefindo_password' => env('PEFINDO_PASSWORD'),
    'pefindo_wsdl' => env('PEFINDO_WSDL'),
    'pefindo_location' => env('PEFINDO_LOCATION'),
    'pefindo_uri' => env('PEFINDO_URI'),

    'bni_id' => env('BNIS_VA_CLIENT'),
    'bni_key' => env('BNIS_VA_KEY'),
	'bni_expire_minutes' => env('BNIS_VA_EXPIRY_MINUTES'),
    'bni_url' => env('BNIS_VA_API_URL'),

    'DMS_URL_SVC' => env('DMS_URL_SVC'),
    'DMS_USER' => env('DMS_USER'),
    'DMS_PASSWORD' => env('DMS_PASSWORD'),
    'DMS_PATH_BORROWER_CORPORATE_LOCAL' => env('DMS_PATH_BORROWER_CORPORATE_LOCAL'),
    'DMS_PATH_BORROWER_CORPORATE_FOREIGN' => env('DMS_PATH_BORROWER_CORPORATE_FOREIGN'),
    'DMS_PATH_BORROWER_PERSONAL_WNI' => env('DMS_PATH_BORROWER_PERSONAL_WNI',"/okm:root/DEV_AREA/BORROWER/PERSONAL/WNI/"),
    'DMS_PATH_BORROWER_PERSONAL_WNA' => env('DMS_PATH_BORROWER_PERSONAL_WNA'),
    'DMS_PATH_LENDER_CORPORATE_LOCAL' => env('DMS_PATH_LENDER_CORPORATE_LOCAL'),
    'DMS_PATH_LENDER_CORPORATE_FOREIGN' => env('DMS_PATH_LENDER_CORPORATE_FOREIGN'),
    'DMS_PATH_LENDER_PERSONAL_WNI' => env('DMS_PATH_LENDER_PERSONAL_WNI'),
    'DMS_PATH_LENDER_PERSONAL_WNA' => env('DMS_PATH_LENDER_PERSONAL_WNA'),

	'bnik_id' => env('BNIK_VA_CLIENT'),
    'bnik_key' => env('BNIK_VA_KEY'),
	'bnik_expire_minutes' => env('BNIK_VA_EXPIRY_MINUTES'),
    'bnik_url' => env('BNIK_VA_API_URL'),
    'bnik_main_account' => env('BNIK_MAIN_ACCOUNT'),

	// RDL
	'url_rdl' => env('URL_RDL'),
	'port_rdl' => env('PORT_RDL'),
	'company_id_rdl' => env('COMPANY_ID_RDL'),
	'username_rdl' => env('USERNAME_RDL'),
	'password_rdl' => env('PASSWORD_RDL'),
	'api_key_id_rdl' => env('API_KEY_ID_RDL'),
	'api_key_secret_rdl' => env('API_KEY_SECRET_RDL'),
	'api_key_outh_id_rdl' => env('API_KEY_OUTH_ID_RDL'),
	'api_key_outh_secret_rdl' => env('API_KEY_OUTH_SECRET_RDL'),
	
	// SFTP
	
	'sftp_host' => env('SFTP_HOST'),
	'sftp_driver' => env('SFTP_DRIVER'),
    'sftp_username' => env('SFTP_USERNAME'),
	'sftp_password' => env('SFTP_PASSWORD'),
	'sftp_account_username' => env('SFTP_ACCOUNT_USERNAME'),
	'sftp_account_password' => env('SFTP_ACCOUNT_PASSWORD'),
    'sft_port' => env('SFTP_PORT'),
    'sft_id' => env('SFTP_ID')

];

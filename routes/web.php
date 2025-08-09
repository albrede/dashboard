<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Filament\Pages\Auth\UserLogin;
use App\Filament\Pages\Auth\SupplierLogin;
use Filament\Facades\Filament;

// Route::Filament('supplier')->auth(); 

Route::middleware([
    'web',
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
])->group(function () {

    // FIX: Use the correct guard ('filament') for authentication
    Route::get('/test-auth', function () {
        // Explicitly use the 'filament' guard
        if (Auth::guard('filament')->check()) {
            return response()->json([
                'user' => Auth::guard('filament')->user(),
                'token' => session('nestjs_token'),
                'payload' => session('user_payload')
            ]);
        }
        return response()->json(['error' => 'Not authenticated'], 401);
    });

    // ADD: Test connection to NestJS backend
    // Route::get('/test-connection', function () {
    //     try {
    //         $response = Http::get(config('services.nestjs.url') . '/health');
    //         return response()->json([
    //             'status' => 'connected',
    //             'response' => $response->json()
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage(),
    //             'url' => config('services.nestjs.url')
    //         ], 500);
    //     }
    // });


    Route::get('/user/signin', UserLogin::class)->name('filament.user.login');
    Route::get('/supplier/signin', SupplierLogin::class)->name('filament.supplier.login');
    Route::redirect('/login', '/user/signin')->name('login');
    Route::redirect('/supplier/login', '/supplier/signin')->name('supplierlogin');

    Route::get('/test-token', function () {
        return response()->json([
            'token' => session('nestjs_token'),
            'user' => auth('filament')->user(),
        ]);
    });
    Route::get('/debug-session', function () {
        return [
            'user' => auth()->guard('supplier')->user(),
            'token' => session('nestjs_token'),
            'session' => session()->all(),
        ];
    });
    Route::get('/debug-panel', function () {
        return filament()->getCurrentPanel()?->getId();
    });
    // Supplier panel scoped route
    Route::get('/supplier/check-filament', function () {
        return [
            'panel' => Filament::getCurrentPanel()?->getId(),
            'default_guard' => config('auth.defaults.guard'),

            'supplier_logged_in' => auth('supplier')->check(),
            'pharmacy_logged_in' => auth('pharmacy')->check(),

            'filament_supplier_user' => Filament::auth('supplier')->user(),
            'filament_admin_user' => Filament::auth('pharmacy')->user(),
            'filament_current_guard' => Filament::getCurrentPanel()?->getAuthGuard(),

            'session' => session()->all(),
        ];
    })->name('supplier.check-filament');




    Route::get('/debug-auth', function () {
        return [
            'auth_guard_supplier' => Auth::guard('supplier')->user(),
            // 'filament_user' => filament()->getUserName(),
            'panel' => filament()->getCurrentPanel()?->getId(),
        ];
    });
});

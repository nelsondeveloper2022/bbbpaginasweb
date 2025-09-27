<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LandingConfigController;
use App\Http\Controllers\PublicLandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\TestRecaptchaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * Rutas principales de la landing page BBB Páginas Web
 */

// Página principal
Route::get('/', [LandingController::class, 'index'])->name('home');

// Páginas individuales
Route::get('/nosotros', [LandingController::class, 'about'])->name('about');
Route::get('/servicios', [LandingController::class, 'services'])->name('services');
Route::get('/testimonios', [LandingController::class, 'testimonials'])->name('testimonials');
Route::get('/contacto', [LandingController::class, 'contact'])->name('contact');
Route::get('/planes', [LandingController::class, 'plans'])->name('plans');

// Ruta de prueba para reCAPTCHA Enterprise
Route::get('/test-recaptcha', [TestRecaptchaController::class, 'show'])->name('test-recaptcha');
Route::post('/test-recaptcha', [TestRecaptchaController::class, 'store']);

// Páginas legales
Route::get('/terminos', [LandingController::class, 'terms'])->name('terms');
Route::get('/privacidad', [LandingController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [LandingController::class, 'cookies'])->name('cookies');

// Ruta para seleccionar plan - redirige al registro con el plan seleccionado
Route::get('/adquirir/{planSlug}', function($planSlug) {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('register', ['plan' => $planSlug]);
})->name('acquire');


// Rutas de autenticación
Route::middleware('guest')->group(function() {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])
        ->middleware('recaptcha')
        ->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('recaptcha')
        ->name('login.post');
});

Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard (requiere autenticación)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes (con middleware de trial)
    Route::prefix('admin')->name('admin.')->middleware('check.trial')->group(function () {
        Route::prefix('plans')->name('plans.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PlanController::class, 'index'])->name('index');
            Route::get('/purchase/{planId}', [\App\Http\Controllers\Admin\PlanController::class, 'checkout'])->name('purchase');
            Route::get('/success', [\App\Http\Controllers\Admin\PlanController::class, 'success'])->name('success');
        });
    });
    
    // Subscription routes (mantener para compatibilidad)
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/plans', [\App\Http\Controllers\SubscriptionController::class, 'showPlans'])->name('plans');
        Route::post('/checkout', [\App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('checkout');
        Route::get('/success', [\App\Http\Controllers\SubscriptionController::class, 'success'])->name('success');
        Route::get('/check-status', [\App\Http\Controllers\SubscriptionController::class, 'checkStatus'])->name('check-status');
    });
    
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Verificación de email
    Route::post('/email/send-verification', [\App\Http\Controllers\EmailVerificationController::class, 'sendVerificationEmail'])->name('email.send-verification');
    Route::get('/email/verification-status', [\App\Http\Controllers\EmailVerificationController::class, 'getVerificationStatus'])->name('email.verification-status');
    
    // Descarga de recibos
    Route::get('/receipt/download/{renovacion}', [\App\Http\Controllers\ReceiptController::class, 'download'])->name('user.receipt.download');
    Route::get('/receipt/download-latest', [\App\Http\Controllers\ReceiptController::class, 'downloadLatest'])->name('user.receipt.download-latest');
    
    // Documentación y ayuda
    Route::prefix('documentacion')->name('documentation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\DocumentationController::class, 'index'])->name('index');
        Route::get('/inicio-rapido', [\App\Http\Controllers\DocumentationController::class, 'quickStart'])->name('quick-start');
        Route::get('/publicar-web', [\App\Http\Controllers\DocumentationController::class, 'publishGuide'])->name('publish-guide');
        Route::get('/configurar-perfil', [\App\Http\Controllers\DocumentationController::class, 'profileGuide'])->name('profile-guide');
        Route::get('/planes-suscripciones', [\App\Http\Controllers\DocumentationController::class, 'plansGuide'])->name('plans-guide');
        Route::get('/landing-pages', [\App\Http\Controllers\DocumentationController::class, 'landingGuide'])->name('landing-guide');
        Route::get('/recibos-pagos', [\App\Http\Controllers\DocumentationController::class, 'receiptsGuide'])->name('receipts-guide');
        Route::get('/preguntas-frecuentes', [\App\Http\Controllers\DocumentationController::class, 'faq'])->name('faq');
    });
    
    // Configuración de Landing Page (requiere trial activo o suscripción)
    Route::prefix('landing')->name('landing.')->middleware('check.trial')->group(function () {
        Route::get('/configurar', [LandingConfigController::class, 'index'])->name('configurar');
        Route::post('/guardar', [LandingConfigController::class, 'store'])->name('guardar');
        Route::put('/actualizar/{id}', [LandingConfigController::class, 'update'])->name('actualizar');
        Route::delete('/eliminar/{id}', [LandingConfigController::class, 'destroy'])->name('eliminar');
        Route::get('/preview', [LandingConfigController::class, 'preview'])->name('preview');
        Route::post('/publicar', [LandingConfigController::class, 'publish'])->name('publicar');
        
        // Gestión de medios
        Route::post('/media/subir', [LandingConfigController::class, 'mediaStore'])->name('media.subir');
        Route::delete('/media/eliminar/{id}', [LandingConfigController::class, 'mediaDestroy'])->name('media.eliminar');
        Route::get('/media/obtener', [LandingConfigController::class, 'getMedia'])->name('media.obtener');
    });
});

// Verificación de email (no requiere autenticación)
Route::get('/email/verify/{token}', [\App\Http\Controllers\EmailVerificationController::class, 'verifyEmail'])->name('email.verify');

// API Routes for Public Landing Pages
Route::prefix('api')->group(function () {
    Route::get('/company/{slug}', [PublicLandingController::class, 'getCompanyInfo'])->name('api.company.info');
    Route::get('/check-slug/{slug?}', [PublicLandingController::class, 'checkSlugAvailability'])->name('api.check-slug');
});

/**
 * Rutas de Administración (Ocultas)
 */
Route::prefix('login-admin')->name('admin.')->group(function () {
    // Login de administrador
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('login');
    Route::post('/', [\App\Http\Controllers\AdminController::class, 'login'])->name('login.post');
});

// Rutas protegidas de administración
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'userDetail'])->name('user-detail');
    Route::post('/users/{id}/publish-landing', [\App\Http\Controllers\AdminController::class, 'publishLanding'])->name('publish-landing');
    
    // Gestión de administradores
    Route::get('/admins', [\App\Http\Controllers\AdminController::class, 'admins'])->name('admins');
    Route::get('/admins/create', [\App\Http\Controllers\AdminController::class, 'createAdmin'])->name('create-admin');
    Route::post('/admins', [\App\Http\Controllers\AdminController::class, 'storeAdmin'])->name('store-admin');
    Route::delete('/admins/{id}', [\App\Http\Controllers\AdminController::class, 'deleteAdmin'])->name('delete-admin');
    
    // Logout
    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
});

// Public Landing Pages (MUST BE LAST - Catch-all route)
Route::get('/{slug}', [PublicLandingController::class, 'showLanding'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('public.landing');
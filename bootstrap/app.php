<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        // تشغيله على كل الموقع
        $middleware->append(\App\Http\Middleware\CountVisits::class);
        $middleware->append(\App\Http\Middleware\BlockBots::class); // ✅ حماية من البوتات
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return;
            }

            try {
                \App\Models\ErrorLog::create([
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'url' => request()->fullUrl(),
                    'method' => request()->method(),
                    'ip' => request()->ip(),
                    'user_id' => auth()->id() ?? null,
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $loggingException) {
                // If logging fails (e.g. DB error), do nothing to avoid infinite loop
            }
        });
    })->create();


    

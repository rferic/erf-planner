<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (\Throwable $e, $request) {
            $code = get_class($e) === NotFoundHttpException::class ? Response::HTTP_NOT_FOUND : Response::HTTP_INTERNAL_SERVER_ERROR;

            if (request()?->expectsJson()) {
                return ApiResponse::fail(
                    $e->getMessage(),
                    config('app.debug')
                        ? ['line' => $e->getFile(), 'trace' => $e->getTrace()]
                        : [],
                    array_key_exists($e->getCode(), Response::$statusTexts) ? $e->getCode() : $code
                );
            }
        });
    }
}

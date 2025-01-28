<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(
                $this->getJsonMessage($e, $request),
                $this->getExceptionHTTPStatusCode($e)
            );
        }

        return parent::render($request, $e);
    }

    protected function getJsonMessage($e, $request): array
    {
        $message = $e->getMessage();
        if (app()->environment('production')) {
            $message = 'Bir hata oluştu';
        }
        $data = [
            'success' => 'false',
            'message' => $message,
        ];
        if ($e instanceof ValidationException) {
            $data['errors'] = $e->errors();
            $data['message'] = 'Lütfen verileri kontrol edin.';
        }
        if ($e instanceof NotFoundHttpException) {
            $data['message'] = 'Endpoint bulunamadı';
            $data['errors'] = ['404' => 'Endpoint bulunamadı'];
        }

        return $data;
    }

    protected function getExceptionHTTPStatusCode($e)
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        } elseif (method_exists($e, 'getCode')) {
            $statusCode = $e->getCode();
        } elseif ($e instanceof AuthenticationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
        } elseif ($e instanceof AuthorizationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
        } elseif ($e instanceof ValidationException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }
        $statusCode = (int) $statusCode;
        if ($statusCode < 100 || $statusCode > 599) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (int) $statusCode;
    }
}

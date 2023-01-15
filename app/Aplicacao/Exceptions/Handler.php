<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        $errors = [];
        if ($e instanceof SistemaExeption) {
            $errors[0] = ['errors' => json_decode($e->getMessage())];
            $errors[1] = $e->getCode();
        }

        if ($e instanceof AuthenticationException) {
            $errors[0] = json_decode($e->getMessage());
            $errors[1] = $e->getCode();
        }

        if ($e instanceof UnauthorizedHttpException) {
            $errors[0] = [
                'error' => "Unauthorized",
                'invalidToken' => true
            ];
            $errors[1] = Response::HTTP_UNAUTHORIZED;
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $errors[0] = ['error' => "Método não encontrado"];
            $errors[1] = JsonResponse::HTTP_METHOD_NOT_ALLOWED;
        }

        if ($e instanceof NotFoundHttpException) {
            $errors[0] = ['error' => "Recurso não encontrado"];
            $errors[1] = JsonResponse::HTTP_NOT_FOUND;
        }

        if ($e instanceof QueryException) {
            $errors[0] = [
                'error' => "Erro interno de servidor.",
                'info' => $e->getMessage()
            ];
            $errors[1] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        Log::info($e->getMessage());
        if (empty($errors)) {
            return response(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($errors[0], $errors[1]);
    }
}

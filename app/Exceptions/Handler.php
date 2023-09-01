<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;
use Symfony\Component\HttpKernel\Exception\LockedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // NotFoundHttpException
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Not Found!",
                ], 404);
            }
        });

        // AccessDeniedHttpException
        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Access Denied!",
                ], 403);
            }
        });

        // BadRequestHttpException
        $this->renderable(function (BadRequestHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Bad Request!",
                ], 400);
            }
        });

        // ConflictHttpException
        $this->renderable(function (ConflictHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Conflict Http!",
                ], 409);
            }
        });

        // GoneHttpException
        $this->renderable(function (GoneHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Gone Http!",
                ], 410);
            }
        });

        // LengthRequiredHttpException
        $this->renderable(function (LengthRequiredHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Length Required!",
                ], 411);
            }
        });

        // LockedHttpException
        $this->renderable(function (LockedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Locked!",
                ], 423);
            }
        });

        // MethodNotAllowedHttpException
        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Method Not Allowed!",
                ], 405);
            }
        });

        // NotAcceptableHttpException
        $this->renderable(function (NotAcceptableHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Not Acceptable!",
                ], 406);
            }
        });

        // PreconditionFailedHttpException
        $this->renderable(function (PreconditionFailedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Precondition Failed!",
                ], 412);
            }
        });

        // PreconditionRequiredHttpException
        $this->renderable(function (PreconditionRequiredHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Precondition Required!",
                ], 428);
            }
        });

        // ServiceUnavailableHttpException
        $this->renderable(function (ServiceUnavailableHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Service Unavailable!",
                ], 503);
            }
        });

        // TooManyRequestsHttpException
        $this->renderable(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Too Many Requests!",
                ], 429);
            }
        });

        // UnauthorizedHttpException
        $this->renderable(function (UnauthorizedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Unauthorized!",
                ], 401);
            }
        });

        // UnprocessableEntityHttpException
        $this->renderable(function (UnprocessableEntityHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Unprocessable Entity!",
                ], 422);
            }
        });

        // UnsupportedMediaTypeHttpException
        $this->renderable(function (UnsupportedMediaTypeHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "status" => false,
                    "message" => "Unsupported Media Type!",
                ], 415);
            }
        });
    }
}

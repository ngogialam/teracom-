<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Throwable;
use App\Traits\ResponseTrait;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        switch (true) {
            case $exception instanceof ValidationException:
                return $this->responseError($exception->errors());

            case $exception instanceof ValidatorException:
                return $this->responseError($exception->getMessageBag()->messages());

            case $exception instanceof ModelNotFoundException:
                return $this->responseError([], Response::HTTP_NOT_FOUND, $exception->getMessage());

            case $exception instanceof DuplicateException:
                return $this->responseError([], Response::HTTP_BAD_REQUEST, $exception->getMessage());

            case $exception instanceof NotAcceptableException:
                return $this->responseError([], Response::HTTP_NOT_ACCEPTABLE, $exception->getMessage());

            case $exception instanceof TokenInvalidException:
                return $this->responseError(['msg' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);

            case $exception instanceof TokenExpiredException:
                return $this->responseError(['msg' => 'Token has Expired'], Response::HTTP_UNAUTHORIZED);

            case $exception instanceof JWTException:
                return $this->responseError(['msg' => 'Token is required'], Response::HTTP_UNAUTHORIZED);

            case $exception instanceof QueryException:
                return $this->responseError([], Response::HTTP_BAD_REQUEST, $exception->getMessage());

            case $exception instanceof UploadFileException:
                return $this->responseError([], Response::HTTP_BAD_REQUEST, $exception->getMessage());

            default:
                break;
        }

        return parent::render($request, $exception);
    }
}

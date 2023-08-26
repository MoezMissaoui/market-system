<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if (collect($request->route()->middleware())->contains('api')) {
            
            if ($exception instanceof ModelNotFoundException) {
                $modelName = strtolower(class_basename($exception->getModel()));
                $error = 'Does not exists any '.$modelName.' with the specific identificator.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_NOT_FOUND
                        );
            }

            if ($exception instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);
            }

            if ($exception instanceof AuthenticationException) {
                $error = 'Unauthenticated.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_UNAUTHORIZED
                        );
            }

            if ($exception instanceof AuthorizationException) {
                $error = 'Unauthorized.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_FORBIDDEN
                        );
            }


            if ($exception instanceof NotFoundHttpException) {
                $error = 'The specified URL cannot be found.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_NOT_FOUND
                        );
            }


            if ($exception instanceof MethodNotAllowedHttpException) {
                $error = 'The specified method for the request is invalid.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_METHOD_NOT_ALLOWED
                        );
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                $error = 'The specified method for the request is invalid.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_METHOD_NOT_ALLOWED
                        );
            }

            if ($exception instanceof HttpException) {
                return $this->errorResponse(
                            $exception->getMessage(), 
                            $exception->getStatusCode()
                        );
            }

            if ($exception instanceof QueryException) {
                $errorCode = $exception->errorInfo[0] ?? null;
                if ($errorCode == 23503) {
                    $error = 'Cannot remove this resource permanently. It is related with any other resource.';
                    return $this->errorResponse(
                                $error, 
                                Response::HTTP_CONFLICT
                            );
                }
            }


            if(!config('app.debug')){
                $error = 'Unexpected Exception. Try later.';
                return $this->errorResponse(
                            $error, 
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        ); 
            }

        }else{
            if ($exception instanceof TokenMismatchException) {
                return redirect()->back()->withInput($request->input());
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if ($this->isFrontend($request)) {
            return $request->ajax() 
                    ? $this->errorResponse(
                        $errors, 
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    )
                    : redirect()
                        ->back()
                        ->withInput($request->input())
                        ->withErrors($errors);
        }
        return $this->errorResponse(
                    $errors, 
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
    }

    private function isFrontend($request)
    {
        return  $request->acceptsHtml() && 
                collect($request->route()->middleware())->contains('web');
    }

}

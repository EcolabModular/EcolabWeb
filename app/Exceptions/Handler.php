<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Facade\Ignition\Exceptions\ViewException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ClientException) {
            return $this->handleClientException($exception, $request);
        }else if($exception instanceof ServerException){
            return $this->handleServerException($exception, $request);
        }else if($exception instanceof ConnectException){
            return response()->view('errors.FatalError', [], 500); // CUANDO NO HAY COMUNICACION CON EL GATEWAY API
        }else if($exception instanceof ValidationException){
            $code = $exception->status;
            $response = $exception->getMessage();
            $errorMessage = json_encode($response);

            $replace = arraY("[","]","\"","{","}");
            $onlyErrors = explode(",",str_replace($replace, "", $errorMessage));

            return redirect()->back()->withErrors([
                        'message' => 'The request was well-formed but was unable to be followed due to semantic errors.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
        }
        else if($exception instanceof ViewException){
            dd($request->has('email'));
            if($exception->getPrevious()->getCode() == 500){
                return response()->view('errors.FatalError', [], 500);
            }
        }else if($exception instanceof FatalError){
            return response()->view('errors.FatalError', [], 500);
        }
        /* SOLUCIONADO ERROR 404 CON ROUTE:FALLBACK EN web.php
        * LA SESION SE VOLVIA NULL CUANDO HABIA ERROR 404
        else if($exception instanceof NotFoundHttpException){
            //dd($request);
            //return redirect()->back()->withErrors(['message' => 'Error404',]);
            //return response()->view('errors.404', [], 404);
            //Route::fallback(function(){ return response()->view('errors.404', [], 404); });
        }*/
        return parent::render($request, $exception);
    }

    /**
     * Handle client exceptions from Guzzle
     *
     * @param  \Guzzle\Exception\ClientException  $exception
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function handleClientException(ClientException $exception, $request)
    {

        $code = $exception->getCode();

        if($request->has('email') && $request->has('password') && $request->getRequestUri() == "/login" && $code == 400){ //ERROR RETORNADO POR LARAVEL PASSPORT QUE DEBERIA CORRESPONDER A 401
            $request->session()->invalidate();
            return redirect()
                        ->route('login')
                        ->withErrors([
                            'message' => 'The authentication failed. Please login again.',
                            'code' => $code,
                            'email' => 'Check youyr email.',
                            'password' => 'Check your credentials.',
                            'Not allowed' => 'Contact support if it doesn\'t work.'
                        ]);
        }

        $response = json_decode($exception->getResponse()->getBody()->getContents(),true);

        $errorMessage = json_encode($response['error']);

        $replace = arraY("[","]","\"","{","}");
        $onlyErrors = explode(",",str_replace($replace, "", $errorMessage));

        if($errorMessage == null){
            $errorMessage = $exception->getMessage();
            $replace = arraY("[","]","\"","{","}");
            $errorMessage = str_replace($replace, "", $errorMessage);
        }

        switch ($code) {
            case Response::HTTP_UNAUTHORIZED:
                $request->session()->invalidate();
                if ($request->user()) {
                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([
                                'message' => 'The authentication failed. Please login again.',
                                'code' => $code,
                                'messageResponse' => $onlyErrors
                            ]);
                }
                abort(500, 'Error authenticating request. Try again.');
            break;

            case Response::HTTP_BAD_REQUEST:
                return redirect()->back()->withErrors([
                        'message' => 'The server could not interpret the given request. Try again.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;

            case Response::HTTP_REQUEST_TIMEOUT:
                return redirect()->back()->withErrors([
                        'message' => 'The request has timed out. Try again.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;

            case Response::HTTP_FORBIDDEN:
                return redirect()->back()->withErrors([
                        'message' => 'The client does not have access rights to the content.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;

            case Response::HTTP_LENGTH_REQUIRED:
                return redirect()->back()->withErrors([
                        'message' => 'The Content-Length header field is not defined and the server requires it.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;

            case Response::HTTP_NOT_FOUND:
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => 'The server can not find the requested resource.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;

            case Response::HTTP_UNPROCESSABLE_ENTITY:
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => 'The request was well-formed but was unable to be followed due to semantic errors.',
                        'code' => $code,
                        'messageResponse' => $onlyErrors
                    ]);
            break;


            default:
                return redirect()->back()->withErrors(['message' => json_encode($errorMessage)]);
        }
    }
    /**
     * Handle Server exceptions from Guzzle
     *
     * @param  \Guzzle\Exception\ServerException  $exception
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function handleServerException($exception, $request)
    {
        $code = $exception->getCode();
        $errorMessage = $exception->getMessage();

        switch ($code) {
            case Response::HTTP_INTERNAL_SERVER_ERROR:

                return redirect()
                    ->route('welcome')
                    ->withErrors([
                        'message' => 'An internal server error has occurred. Please try again.',
                        'code' => $code,
                        'messageResponse' => $errorMessage
                    ]);
            default:
                return redirect()->route('welcome')->withErrors(['message' => 'Error: ' . $code . ', An internal server error has occurred . Please try again.']);
        }
    }
}

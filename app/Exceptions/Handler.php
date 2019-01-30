<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Base\Exception\ExclusiveLockException;

class Handler extends ExceptionHandler
{
    /**
     * A general of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A general of the inputs that are never flashed for validation exceptions.
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // DBロールバック
        \DB::rollback();

        // 楽観的排他エラーの補足
        if($exception instanceof ExclusiveLockException) {
            if(\Request::ajax()) {
                // Ajaxの場合の排他エラー処理を記述
//                // 返却用のデータをセット
//                $meta = ['code' => 'exclusion_error', 'message' => '',];
//                $modal["title"] = '排他エラー';
//                $ret = ['meta' => $meta, 'data' => $modal,];
//                // jsonで返却する
//                return \Response::json($ret)->setCallback(\Input::get('callback'));

            } else {
                // 排他エラーに関する処理を記述
                // return redirect()->back();
            }
        }

        return parent::render($request, $exception);
    }
}

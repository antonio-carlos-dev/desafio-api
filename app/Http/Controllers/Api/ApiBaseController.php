<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ApiBaseController extends Controller
{

    protected $model;

    public function __construct( Model $model )
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $models = $this->model->all();
            return $this->sendSuccess($models,'Success', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try{
            $model = $this->model->find($id);
            return $this->sendSuccess($model,'Success', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  $id)
    {
        try{
            $res = $this->model->destroy($id);
            return $this->sendSuccess( $res ? 'Deleted' : [] ,'Success', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    public function sendSuccess($result, $message, $code = 200)
    {
        return Response::json(self::makeResponse(true, $message, $result),  $result ? $code : 204 );
    }

    public function sendError(Request $request, Exception $e , $data = [])
    {
        $code = $e->getCode();
        $message = $e->getMessage();
        Log::error( $request->fullUrl() , [
            'url' => $request->fullUrl(),
            'querystring' => $request->query(),
            'method' => $request->method(),
            'request' => $request->all(),
            'error' => $e,
        ]);
        if(!is_numeric( $code ) ){
            $code = 400;
            $message = 'Error ' . $e->getCode();
        }else if ( $code > 500 ) {
            $code = 500;
            $message = 'Error ' . $e->getCode();
        }
        return Response::json(self::makeResponse(false ,  $message, $data), $code );
    }

    private static function makeResponse($success, $message, $data = [] ) : array
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $response;
    }

}

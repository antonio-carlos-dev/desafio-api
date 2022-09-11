<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Card;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends ApiBaseController
{

    protected $model;

    public function __construct( Card $model )
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
            $models = $this->model->orderBy('order')
            ->whereHas('column' , function( $query){
                $query->orderBy('order');
            })->get();
            $models = $models->groupBy('column_id');
            return $this->sendSuccess($models,'Success', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),
            [
                'column_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'estimated_date' => 'required',
                'tag' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $data = $validator->validated();
            $data['order'] = $this->order($data);
            $model = $this->model->create($data);
            return $this->sendSuccess($model,'Column Created Successfully', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try{
            $validator = Validator::make($request->all(),
            [
                'column_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'estimated_date' => 'required',
                'tag' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $data = $validator->validated();
            $model = $this->model->find($id);
            $model->update($data);
            return $this->sendSuccess($model->fresh(),'Column Updated Successfully', $code = 200);
        } catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    private function order($data)
    {
        $max = Card::whereColumnId($data['column_id'])->max('order') ;
        return  $max  + 1;
    }
}

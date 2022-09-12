<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use App\Models\Column;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColumnController extends ApiBaseController
{

    protected $model;

    public function __construct( Column $model )
    {
        $this->model = $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCards(Request $request, $id)
    {
        try{
            $models = Card::whereColumnId($id)->get();
            return $this->sendSuccess($models,'Success', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $models = $this->model->orderBy('order')->get();
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
                'project_id' => 'required',
                'name' => 'required',
                'time' => 'required',
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
                'name' => 'nullable|string',
                'time' => 'nullable|string',
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
        $max = Column::whereProjectId($data['project_id'])->max('order') ;
        return  $max  + 1;
    }
}

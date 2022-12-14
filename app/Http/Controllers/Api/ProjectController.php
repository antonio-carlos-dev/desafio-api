<?php

namespace App\Http\Controllers\Api;

use App\Models\Column;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends ApiBaseController
{

    protected $model;

    public function __construct( Project $model )
    {
        $this->model = $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showColumns(Request $request, $id)
    {
        try{
            $models = Column::whereProjectId($id)->get();
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
                'name' => 'required',
                'team_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $data = $validator->validated();
            $data['user_id'] = auth()->user()->id;
            $model = $this->model->create($data);
            return $this->sendSuccess($model,'Project Created Successfully', $code = 200);
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
                'name' => 'required',
                'team_id' => 'required',
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
            return $this->sendSuccess($model->fresh(),'Project Updated Successfully', $code = 200);
        } catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }
}

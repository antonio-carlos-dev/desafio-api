<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Project;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends ApiBaseController
{

    protected $model;

    public function __construct( Team $model )
    {
        $this->model = $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProjects(Request $request, $id)
    {
        try{
            $models = Project::whereTeamId($id)->get();
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
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $team = $this->model->create($validator->validated());
            return $this->sendSuccess($team,'Team Created Successfully', $code = 200);
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

            $validator = Validator::make(
                $request->all(),
                [ 'name' => 'required']
            );
            $model = $this->model->find($id);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $model->update($validator->validated());
            return $this->sendSuccess($model->fresh(),'Team Updated Successfully', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }
}

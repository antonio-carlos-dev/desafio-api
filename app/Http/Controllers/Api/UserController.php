<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends ApiBaseController
{
    protected $model;

    public function __construct( User $model )
    {
        $this->model = $model;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $users = $this->model->all();
            return $this->sendSuccess($users,'success', $code = 200);
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

            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::min(8)->letters()->symbols()->mixedCase() ]
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validateUser->errors()
                ], 401);
            }
            $user = $this->model->create($this->passwordHash($validateUser->validated()));
            $user->token = $user->createToken("DESAFIO KEY")->plainTextToken;
            return $this->sendSuccess($user,'User Created Successfully', $code = 200);
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
            $user = $this->model->find($id);
            return $this->sendSuccess($user,'success' );
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
    public function update(Request $request, $id)
    {
        try{

            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => ['required' , 'email' ,  Rule::unique('users')->where(fn ($query) => $query->where('id', Auth::id()))],
                'password' => ['required', Password::min(8)->letters()->symbols()->mixedCase() ]
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validateUser->errors()
                ], 401);
            }

            $user = $this->model->find($id);
            $user->update($this->passwordHash($validateUser->validated()));
            return $this->sendSuccess($user->fresh(),'User Updated Successfully', $code = 200);
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
    public function destroy(Request $request , $id)
    {
        try{
            User::destroy($id);
            return $this->sendSuccess(['deleted_at' => now()],'User Deleted Successfully', $code = 200);
        }catch(Exception $e ) {
            return $this->sendError($request,  $e );
        }
    }

    private function passwordHash($data)
    {
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}

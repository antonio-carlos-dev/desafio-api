<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoveController extends ApiBaseController
{

    protected $model;

    public function __construct( Card $model )
    {
        $this->model = $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $quantity
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(),
            [
                'direction' => 'required|in:LEFT,RIGHT,UP,DOWN',
                'quantity' => 'required|numeric|min:1',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'data' => $validator->errors()
                ], 401);
            }
            $data = $validator->validated();
            $model  = $this->model->find($id);

            switch ($data['direction']) {
                case "RIGHT":
                case "LEFT":
                    $this->moveColumn($model , $data, $data['direction']);
                    break;
                case "UP":
                case "DOWN":
                        $this->moveOrder($model , $data, $data['direction']);
                        break;
            }

            return $this->sendSuccess($model->fresh(),'Card Moved Successfully', $code = 200);
        }catch(Exception $e ) {
            dd($e->getLine());
            return $this->sendError($request,  $e );
        }

    }

    private function moveColumn(Card $card, $data, $direction)
    {
        $column = $card->column;
        $project = $card->column->project;
        $new = $direction == 'RIGHT' ? $column->order + $data['quantity'] : $column->order - $data['quantity'] ;
        $new_column = $project->columns()->where('order', '=', $new )->first();
        if(is_null($new_column)) {
            throw new Exception("Column Not Found", 204);
        }
        $card->column_id = $new_column->id;
        $card->save();
    }

    private function moveOrder(Card $card, $data, $direction)
    {
        $pos = $card->order;
        $npos = $direction == 'UP' ? $card->order - $data['quantity'] : $card->order + $data['quantity'] ;
        $max = $pos;
        $min = $pos;
        $nCard = Card::whereColumnId($card->column_id)->whereOrder( $npos)->first();

        if ( $direction == 'DOWN' ) {
            $max = Card::whereColumnId($card->column_id)->max('order') + 1;
        }else{
            $min = Card::whereColumnId($card->column_id)->min('order') - 1;
        }
        if($npos < 1 ) {
            throw new Exception("Position Not Found", 204);
        }

        if( is_null($nCard) &&  $direction == 'UP' && $npos < $min) {
            throw new Exception("Position Not Found", 204);
        }

        if( is_null($nCard) &&  $direction == 'DOWN' && $npos > $max) {
            throw new Exception("Position Not Found", 204);
        }

        if ( !is_null($nCard)) {
            if ( $direction == 'UP') {
                foreach(Card::where('order' , '<', $pos)->orderBy('order')->get() as $downCard){
                    $downCard->update(['order' => $downCard->order +1]);
                }
            }
            if ( $direction == 'DOWN') {
                foreach(Card::where('order' , '<=', $npos)->orderBy('order')->get() as $upCard){
                    $upCard->update(['order' => $upCard->order -1 ]);
                }
            }
        }
        $card->update(['order' => $npos]);
    }
}

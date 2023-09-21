<?php

namespace App\Http\Controllers;

use App\Models\States;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStatesRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateStatesRequest;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allStates()
    {

        $states = States::all();
        
        if($states->count() > 0 ) {

            return response()->json([
                'status' => 200,
                'states' => $states
            ], 200);

        } else {

            return response()->json([
                'status' => 400,
                'message' => 'no records found'
            ], 200);

        }
    }


    public function addStates(Request $request) {

        $validator = Validator::make($request->all(), [
            'state_id' => 'required|max:2000',
            'state' => 'required|max:200|string',
            'cities' => 'required|max:5000'
        ]);

        if($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);

        } else {

            $state = States::create([
                'state_id' => $request->state_id,
                'state' => json_encode($request->state),
                'cities' => $request->cities
            ]);

            if($state) {

                return response()->json([
                    'status' => 200,
                    'message' => "state save successfully"
                ],200);

            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong"
                ],500);
            }

        }

    }

    
}

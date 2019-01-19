<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\GarageUserRequest;

use App\Garages\Garage;
use App\Garages\GarageUser;
use App\Garages\Rate;

class GarageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Garage $garage, GarageUserRequest $request)
    {
        // were we passed a valid rate?
        if (!Rate::where('id', $request->get('rate_id'))->count()) {
            return response()->json([
                'message' => 'Invalid rate given',
            ], 403);
        }

        // check if user can enter garage
        if ($garage->availableSpots()) {
            $user = new GarageUser();
            $user->garage_id = $garage->id;
            $user->fill($request->all());
            $user->save();

            return response()->json([
                'message' => 'success',
                'user' => $user->load('rate'),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not enough space in garage.',
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GarageUser  $garageUser
     * @return \Illuminate\Http\Response
     */
    public function show(GarageUser $garageUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GarageUser  $garageUser
     * @return \Illuminate\Http\Response
     */
    public function edit(GarageUser $garageUser)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GarageUser  $garageUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garage $garage, GarageUser $user)
    {
        $user->is_valid = true;
        $user->save();

        return response()->json([
            'message' => 'success',
            'user' => $user->load('rate'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GarageUser  $garageUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Garage $garage, GarageUser $user)
    {
        if ($user->is_valid) {

            $user->delete();

            return response()->json([
                'message' => 'success',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Please pay for ticket before leaving.',
            ], 200);
        }
    }
}

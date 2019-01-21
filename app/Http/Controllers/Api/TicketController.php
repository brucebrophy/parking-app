<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\TicketRequest;

use App\Garages\Garage;
use App\Garages\Ticket;
use App\Garages\Rate;

class TicketController extends Controller
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
    public function store(Garage $garage, Request $request)
    {
        // were we passed a valid rate?
        if (!Rate::where('id', $request->get('rate_id'))->exists()) {
            return response()->json([
                'message' => 'Invalid rate given',
            ], 403);
        }

        // is licence plate unique?
        if (Ticket::where('licence_number', $request->get('licence_number'))->first()) {
            return response()->json([
                'message' => 'This licence is already taken',
            ], 403);
        }

        // check if they can enter garage
        if ($garage->availableSpots()) {
            $ticket = new Ticket();
            $ticket->garage_id = $garage->id;
            $ticket->fill($request->all());
            $ticket->save();

            return response()->json([
                'message' => 'success',
                'ticket' => $ticket->load('rate'),
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
     * @param  \App\Garages\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Garage $garage, $license)
    {
        $ticket = Ticket::where('licence_number', $license)->with('rate')->get();

        if (count($ticket)) {
            return response()->json([
                'message' => 'success',
                'ticket' => $ticket->first(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Ticket cannot be found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Garages\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Garages\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garage $garage, Ticket $ticket)
    {
        $ticket->is_valid = true;
        $ticket->save();

        return response()->json([
            'message' => 'success',
            'ticket' => $ticket->load('rate'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Garages\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Garage $garage, $license)
    {
        $ticket = Ticket::where('licence_number', $license)->with('rate')->get()->first();

        if (!$ticket) {
            return response()->json([
                'message' => 'Ticket cannot be found',
            ], 404);
        }

        if ($ticket->is_valid) {

            $ticket->delete();

            return response()->json([
                'message' => 'success',
            ], 204);
        } else {
            return response()->json([
                'message' => 'Please pay for ticket before leaving.',
            ], 403);
        }
    }
}

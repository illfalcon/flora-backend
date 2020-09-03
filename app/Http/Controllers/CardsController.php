<?php

namespace App\Http\Controllers;

use App\Card;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return response(['cards' => $user->cards], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only(['flower_id', 'message', 'destination']),
        [
            'flower_id' => 'required|exists:flowers,id',
            'message' => 'required',
            'destination' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first()], 400);
        }
        $card = new Card($request->all(['flower_id', 'message', 'destination']));
        $card->user_id = Auth::user()->id;
        $card->save();
        return response(['card' => $card], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        if (Auth::user()->id != $card->author()->id) {
            return response(['message' => 'Unauthorized access'], 401);
        }
        return response(['card' => $card]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $validator = Validator::make($request->only(['message', 'destination', 'flower_id']),
        [
            'message' => 'required',
            'destination' => 'required',
            'flower_id' => 'required|exists:flowers,id'
        ]);
        if ($validator->fails())
        {
            return response(['message' => $validator->errors()->first()], 400);
        }
        if (Auth::user()->id != $card->author()->id) {
            return response(['message' => 'Unauthorized access'], 401);
        }
        $card->update($validator->validated());
        return response(['card' => $card], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        if (Auth::user()->id != $card->author()->id) {
            return response(['message' => 'Unauthorized access'], 401);
        }
        if ($card->delete())
        {
            return response(['success' => true], 200);
        }
        return response(['success' => false], 500);
    }
}

<?php

namespace App\Http\Controllers;

use App\Card;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = \App\User::find($user_id);
        return ['cards' => $user->cards];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $data = json_decode($request, true);
//        dd($request->all());
        $card = new Card($request->all(['flower_id', 'message', 'destination']));
//        dd($card);
        $card->user_id = 1;
        $card->save();
        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        return ['card' => $card];
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
        $validatedProperties = $request->validate(
            [
                'user_id' => 'required|exists:users,id',
                'message' => 'required',
                'flower_id' => 'required|exists:users,id',
                'destination' => 'required'
            ]
        );

        $card->update($validatedProperties);
        return 200;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}

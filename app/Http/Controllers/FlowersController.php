<?php

namespace App\Http\Controllers;

use App\Flower;
use Illuminate\Http\Request;

class FlowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Flower::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = $request->validate(
            [
                'name' => 'required',
                'info' => 'required'
            ]
        );
        Flower::create($validatedAttributes);
    }

    /**
     * Display the specified resource.
     *
     * @param Flower $flower
     * @return \Illuminate\Http\Response
     */
    public function show(Flower $flower)
    {
        return $flower;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Flower $flower
     * @return void
     */
    public function update(Request $request, Flower $flower)
    {
        $validatedAttributes = $request->validate(
            [
                'name' => 'required',
                'info' => 'required'
            ]
        );
        $flower->update($validatedAttributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

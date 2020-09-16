<?php

namespace App\Http\Controllers;

use App\Flower;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FlowersController extends Controller
{
    use UploadFileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['flowers' => Flower::all()]);
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
        $request->validate([
            'image' => 'required|file|image',
            'name' => 'required',
            'info' => 'required',
        ]);
        $image = $request->file('image');
        $name = $request->get('name');
        $folder = 'images';
//        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        $file = $this->uploadOne($image, $folder, 'public', $name);
        $url = Storage::url($file);
        $validatedAttributes = [
            'name' => $request->get('name'),
            'info' => $request->get('info'),
            'image' => $url
        ];
        Flower::create($validatedAttributes);
        return response(['success' => true], 200);
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

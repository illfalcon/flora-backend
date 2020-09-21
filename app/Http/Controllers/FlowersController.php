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
        if (auth()->user()->name != 'admin') {
            return response(['error' => 'forbidden'], 403);
        }
        $request->validate([
            'image' => 'required|file|image',
            'name' => 'required',
            'info' => 'required',
            'name_color' => 'required',
            'description_color' => 'required',
            'light_color' => 'required',
            'main_color' => 'required'
        ]);
        $image = $request->file('image');
        $name = $request->get('name');
        $folder = 'images';
//        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        $file = $this->uploadOne($image, $folder, 'gcs', $name);
        $url = Storage::disk('gcs')->url($file);
        $validatedAttributes = [
            'name' => $request->get('name'),
            'info' => $request->get('info'),
            'image' => $url,
            'name_color' => $request->get('name_color'),
            'description_color' => $request->get('description_color'),
            'light_color' => $request->get('light_color'),
            'main_color' => $request->get('main_color')
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
        return response(['flower' => $flower]);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flower $flower)
    {
        if (auth()->user()->name != 'admin') {
            return response(['error' => 'forbidden'], 403);
        }
        $validatedAttributes = $request->validate(
            [
                'name' => 'required',
                'info' => 'required'
            ]
        );
        $flower->update($validatedAttributes);
        return response(['success' => true], 200);
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

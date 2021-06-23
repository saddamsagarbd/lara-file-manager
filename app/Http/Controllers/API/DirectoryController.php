<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Directory;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Directory::where('parent_directory', NULL)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'directory_name' => 'required|min:3|max:191',
        ]);
        Storage::makeDirectory('public/'.$request['directory_name']);
        return Directory::create([
            'directory_name' => $request['directory_name'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ['message' => "I ahve your data"];
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
        $directory = Directory::findOrFail($id);
        $this->validate($request, [
            'directory_name' => 'required|min:3|max:191',
        ]);
        $directory->update($request->all());
        
        return ['message' => 'rename directory'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directory = Directory::findOrFail($id);
        if(isset($directory["id"])){
            $directory->delete();
            Storage::deleteDirectory($directory["directory_name"]);
            return ['status'=> 'success', 'message' => "Directory successfully removed."];
        }
        return ['status'=> 'error', 'message' => "Directory could not removed."];
    }
}

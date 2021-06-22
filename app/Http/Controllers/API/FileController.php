<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Directory;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($folder_id)
    {
        return File::where("folder_id", $folder_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(count($request->file('file')) > 0){
            $directoryDtl = Directory::findOrFail($request["directory_id"]);
            if(isset($directoryDtl["directory_name"])){
                foreach($request->file('file') as $key => $file){
                    $path = $file->store($directoryDtl["directory_name"]);           
                    if($path){
                        File::create([
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'folder_id' => $directoryDtl["id"],
                        ]);
                    }
                }
                return ['status'=>"success", 'msg' => "File successfully uploaded"];
            }else{
                return ['status'=>"error", 'msg' => "File not upload"];
            }
        }else{
            return ['status'=>"error", 'msg' => "File not upload"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

    /**
     * Download the specified file from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($file_id)
    {
        $fileDtl = File::findOrFail($file_id);
        return Storage::download($fileDtl->file_path);

    }
}

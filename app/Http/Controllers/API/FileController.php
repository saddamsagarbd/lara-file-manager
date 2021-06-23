<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\Directory;
use App\Models\FileManage;
use Auth;

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
        $getFilesettings = FileManage::where('user_id', NULL)->get();
        $allowFormat = explode(',', $getFilesettings[0]["allowFormat"]);

        $fileUpload = false;

        if(count($request->file('file')) > 0){
            $directoryDtl = Directory::findOrFail($request["directory_id"]);
            if(isset($directoryDtl["directory_name"])){
                foreach($request->file('file') as $key => $file){
                    if(in_array($file->extension(), $allowFormat)){
                        $fileUpload = true;
                        $path = $file->store($directoryDtl["directory_name"]);           
                        if($path){
                            File::create([
                                'file_name' => $file->getClientOriginalName(),
                                'file_path' => $path,
                                'folder_id' => $directoryDtl["id"],
                            ]);
                        }
                    }else{
                        $fileUpload = false;
                    }
                }

                if($fileUpload == true){
                    return ['status'=>"success", 'msg' => "File successfully uploaded"];
                }else{
                    return ['status'=>"error", 'msg' => "File format is not allow to upload."];
                }
                
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
        $path = storage_path().'/'.$fileDtl->file_path;
        if (file_exists($path)) {
            return Storage::download($path);
        }

    }
    public function fileSettings(Request $request)
    {
        $this->validate($request, [
            'allowFormat' => 'required|max:191',
            'maxFileSize' => 'required',
        ]);

        $getFilesettings = FileManage::where('user_id', NULL)->get();
        if(!is_null($getFilesettings)){
            FileManage::where('user_id', NULL)
                    ->update([
                        'allowFormat' => $request['allowFormat'],
                        'maxFileSize' => $request['maxFileSize'],
                    ]);
            return ['status'=> 'success', 'message' => "File settings updated."];
        }else{
            FileManage::create([
                'allowFormat' => $request['allowFormat'],
                'maxFileSize' => $request['maxFileSize'],
            ]);
            return ['status'=>'success', 'message' => "File settings created"];
        }

    }

    public function getFileSettings()
    {
        return FileManage::where('user_id', NULL)->get();
    }
}

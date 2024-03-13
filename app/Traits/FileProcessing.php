<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileProcessing
{

    /**
     * Maintain the store process of the given file and the return the name of the newly file stored
     * @param Request $request
     * @param array $files
     * @param string $path
     * @return array
     */
    public function fileUploadHandling(Request $request, array $files, string $path)
    {
        $names = [];
        for ($i=0; $i<count($files); $i++) {
            
            if ($request->hasFile($files[$i])) {

                $file = $request->file($files[$i]);
                $name = time().'_'.$file->getClientOriginalName();
                $names[$files[$i]] = $name;
                $file->storeAs($path,$name);
            }
            
        }
        return $names;
    }

    /**
     * Maintain the file delete process of the given url or path 
     * @param string $path
     * @return bool
     */
    public function deleteFile($profile_pic){
        if(Storage::exists($profile_pic)){
           return Storage::delete($profile_pic);
        }else{
            return true;
        }
    }
}

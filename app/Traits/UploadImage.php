<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadImage
{
    public function uploadphoto(Request $request,string $path):string
    {
        $file     = $request->file('photo');
        $fileName = time() . '-' . $file-> getClientOriginalName();
        
        $file->move($path , $fileName);
        return $fileName;
    }
}

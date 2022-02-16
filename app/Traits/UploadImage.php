<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadImage
{
    public function uploadphoto($file,string $path):string
    {
        $fileName = $file-> hashName();
        
        $file->move($path , $fileName);
        return $fileName;
    }
}

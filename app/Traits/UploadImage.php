<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait UploadImage
{
    public function uploadPhoto(object $file,string $path,int $width=null,int $height=null):string
    {
        $img = Image::make($file)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        $fileName = $file->hashName();
        $img->save(public_path($path.$fileName));

        return $fileName;
    }
}

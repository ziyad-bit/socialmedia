<?php

namespace App\Traits;

trait UploadFile
{
    public function uploadFile(object $file,string $path):string
    {
        $fileName = $file->hashName();
        $file->move($path,$fileName);

        return $fileName;
    }
}

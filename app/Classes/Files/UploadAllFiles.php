<?php

namespace App\Classes\Files;

use App\Models\Posts;
use App\Traits\UploadFile;
use App\Traits\UploadImage;
use Illuminate\Http\Request;

class UploadAllFiles 
{
    use UploadFile,UploadImage;

    public function uploadAll(Request $request,Posts $post=null):array
    {
        if ($post) {
            $photo = $post->photo;
            $file  = $post->file;
            $video = $post->video;
        }

        $photo=$request->file('photo');
        if ($photo) {
            $photo=$this->uploadPhoto($photo,'images/posts/',560);
        }

        $file=$request->file('file');
        if ($file) {
            $file=$this->uploadFile($file,'images/files');
        }

        $video=$request->file('video');
        if ($video) {
            $video=$this->uploadFile($video,'images/videos');
        }

        return ['photo'=>$photo,'file'=>$file,'video'=>$video];
    }
}

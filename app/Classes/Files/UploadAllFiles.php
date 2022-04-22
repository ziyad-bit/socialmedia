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
        $photo=$request->file('photo');
        if ($photo) {
            $photo=$this->uploadPhoto($photo,'images/posts/',560);
        }else{
            if ($post) {
                $photo=$post->photo;
            }
        }

        $file=$request->file('file');
        if ($file) {
            $file=$this->uploadFile($file,'images/files');
        }else{
            if ($post) {
                $file=$post->file;
            }
        }

        $video=$request->file('video');
        if ($video) {
            $video=$this->uploadFile($video,'images/videos');
        }else{
            if ($post) {
                $video=$post->video;
            }
        }

        return ['photo'=>$photo,'file'=>$file,'video'=>$video];
    }
}

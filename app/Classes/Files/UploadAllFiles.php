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

        $photo_file=$request->file('photo');
        if ($photo_file) {
            $photo=$this->uploadPhoto($photo_file,'images/posts/',560);
        }

        $file_req=$request->file('file');
        if ($file_req) {
            $file=$this->uploadFile($file_req,'images/files');
        }

        $video_file=$request->file('video');
        if ($video_file) {
            $video=$this->uploadFile($video_file,'images/videos');
        }

        return ['photo'=>$photo,'file'=>$file,'video'=>$video];
    }
}

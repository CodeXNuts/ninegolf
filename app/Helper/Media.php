<?php

namespace App\Helper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Media {

    public function uploads($file, $path)
    {
        if($file) {

            $fileName   = time(). '_' . rand(100,100000) .'_'. Str::uuid(). $file->getClientOriginalName();
            Storage::disk('public')->put('images/'.$path . $fileName, File::get($file));
            $file_name  = $file->getClientOriginalName();
            $file_type  = $file->getClientOriginalExtension();
            $filePath   = 'storage/images/'.$path . $fileName;
            
            return $file = [
                'fileName' => $file_name,
                'fileType' => $file_type,
                'filePath' => $filePath,
                'fileSize' => $this->fileSize($file)
            ];
        }
    }

    public function fileSize($file, $precision = 2)
    {   
        $size = $file->getSize();

        if ( $size > 0 ) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}
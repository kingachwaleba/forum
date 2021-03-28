<?php


namespace App\Traits;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadTrait
{
    // This function will handle the file uploading by taking the uploaded image, folder, disk, and filename parameters.
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        // Checking if a filename has been passed, if not then creating a random string name.
        $name = !is_null($filename) ? $filename : Str::random(25);

        // Uploading the file using UploadedFile‘s storeAs method and returning the file we just stored.
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}

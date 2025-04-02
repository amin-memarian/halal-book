<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadImage($image, $folder, $sizes, $thumbSize, $squareThumb = false){
        $imageName = Str::random(15);

        // path to upload
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $path = "/".$folder."/{$year}/{$month}/";
        $thumb_path = "/".$folder."/{$year}/{$month}/thumb/";

        $this->checkPath($path);
        $this->checkPath($thumb_path);

        // create images
        $img = Image::make($image);

        $images = [];
        $img->backup();

        foreach ($sizes as $key => $size) {
            $url = $path . $imageName . "_{$size}.jpg";
            $uploadTo = 'public/' . $url;
            $img->reset();

            $resized = $img->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();

            Storage::put($uploadTo, $resized, 'public');
            $images[$key] = $url;
        }

        // upload original
        $url = $path . $imageName . "_original.jpg";
        $uploadTo = 'public/' . $url;
        $img->reset();
        $original = $img->stream();
        Storage::put($uploadTo, $original, 'public');
        $images['original'] = $url;

        // make thumb
        $url = $thumb_path . $imageName . "_" . $thumbSize . ".jpg";
        $uploadTo = 'public/' . $url;
        $img->reset();
        $thumb = $img->fit($thumbSize, $thumbSize)->stream();
        Storage::put($uploadTo, $thumb, 'public');
        $images['thumb'] = $url;

        // large thumb
        if ($squareThumb){
            $url = $thumb_path . $imageName . "_" . 150 . ".jpg";
            $uploadTo = 'public/' . $url;
            $img->reset();
            $thumb = $img->fit(150, 150)->stream();
            Storage::put($uploadTo, $thumb, 'public');
            $images['square_thumb'] = $url;
        }

        header('Content-Type: application/json');

        return $images;
    }

    public function uploadRealFile($file, $folderName) {
        $fileName   = Str::random(15) . '.' . $file->getClientOriginalExtension();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $path = "/".$folderName."/{$year}/{$month}/";
        $this->checkPath($path);

        $file->storeAs("/public".$path,$fileName);
        return $path . $fileName;
    }

    public function removeStorageFile($fileUrl){
        try {
            unlink(storage_path('app/public'.$fileUrl));
        } catch (\Exception $e){
            // show some error
        }
    }

    public function convertPersianNumToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persian, $english, $string);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function checkPath($path)
    {
        if (!File::exists('storage'.$path)) {
            File::makeDirectory('storage'.$path, 0755, true);
        }
    }

    public static function sendSms($phone, $token , $template, $token2 = '', $token3 = '')
    {
        $url = "https://api.kavenegar.com/v1/" . env('KAVENEGAR_TOKEN') . "/verify/lookup.json?receptor=$phone&token=$token&token2=$token2&token3=$token3&template=$template";
        return (new Client())->get($url);
    }
}

<?php

namespace App\Http\Controllers;
use App\ImageUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImageuploadController extends Controller
{
    public function store(Request $request)
    {
          $file = $request->file('fileupload');
        //   dd($file);
        $ext = $file->extension();
        //  $name = $request->file('fileupload');

          
          $name = Carbon::now()->format('d-m-Y') . '-' . Str::random(10). '.' . $ext;
          // dd($name);
          //   $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          list($width, $height) = getimagesize($file);
          $path = Storage::disk('public')->putFileAs(
            'uploadImages',
            $file,
            $name
        );
        
        $user = Auth::User();
         // dd($user);

        $photo = ImageUpload::create([
            'user_id' =>$user->id,
            // 'fileupload'=>$request->fileupload,
            'fileupload' => $path,
            // 'public' => false,
            // 'width' => $width,
            // 'height' => $height
        ]);
        // dd($photo);
        return response()->json(['success' => $photo], 201);

    }
}

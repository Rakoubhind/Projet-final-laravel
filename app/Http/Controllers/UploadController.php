<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $file = $request->file('file');
        // dd($file);
        $ext = $file->extension();
        $name = $request->file('file');
        // $mytime = Carbon::now()->format('d-m-Y');
        // $random = Str::random(10);
        $name = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;

        list($width, $height) = getimagesize($file);

        $path = Storage::disk('public')->putFileAs(
            'uploadImages',
            $file,
            $name
        );
        // $user = User::find(1);
        $user = Auth::User();

        // dd($user);
        $photo = $user->photos()->create([
            'uri' => $path,
            'public' => false,api
            'width' => $width,
            'height' => $height
        ]);

        return response()->json(['upload' => 'success'], 200);
    }
    public function getPhoto()
    {

        $user = Auth::User();


        $photos = $user->photos()->get();

        return response()->json($photos, 200);
    }
}

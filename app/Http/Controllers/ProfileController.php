<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request){
        $user = Auth::User();
        // dd($user);
        $profiles = Profile::create([
            'user_id' =>$user->id,
            'phone'=>$request->get('phone'),
            'mobile'=>$request->get('mobile'),
            'location'=>$request->get('location'),
            'image'=>$request->get('image'),
           ]);

              return response()->json($profiles , 201);
    }
}

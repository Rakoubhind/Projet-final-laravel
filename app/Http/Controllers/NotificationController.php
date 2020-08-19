<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::User();
       
        $notifications = Notification::create([
            'user_id' => $user->id,
            'product_id' => $request->get('product_id'),
            'description' => $request->get('description'),



        ]);

        return response()->json($notifications, 201);
    }
    public function getMessage()
    {
        $user = Auth::User();
        $notifications = Notification::where('user_id', $user->id)->get();
        return response()->JSON(['user' => $user->name, 'notification' => $notifications], 200);
    }
}

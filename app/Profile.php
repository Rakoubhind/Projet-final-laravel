<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable =['user_id' , 'location' , 'image' ,'phone' , 'mobile'];
    public function user()
    {
        return $this->hasOne('App\User');
    }
}

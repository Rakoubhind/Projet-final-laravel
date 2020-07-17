<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends \TCG\Voyager\Models\User
{
  use HasApiTokens, Notifiable;
/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = ['name','email','password','phone','mobile','avatar','adress'];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];
public function products()
{
    return $this->hasMany('App\Product');
}
public function photos()
{
    return $this->hasMany('App\ImageUpload');
}
    
public function profile()
{
    return $this->hasOne('App\Profile');
}
}
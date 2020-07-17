<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $fillable = ['fileupload' , 'user_id' ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

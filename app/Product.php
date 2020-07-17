<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{
    //  protected $guarded =[];
    protected $fillable = ['description' ,'titre' , 'chambre' , 'prix', 'surface' , 'adresse' , 'disponibilite','image1','image2','image3','category_id','user_id'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

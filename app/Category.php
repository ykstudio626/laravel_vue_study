<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public function posts(){
    	return $this->hasMany(Post::class);
    }

    public static function options(){
    	return DB::table('categories')->get()->pluck('name' , 'id');
    }
}

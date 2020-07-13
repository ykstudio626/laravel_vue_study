<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = "books";//テーブル名

    protected $guarded = ['id'];//主キー

    public $timestamps = true;//日付自動挿入

    protected $fillable = ['book_name' , 'price' , 'author' , 'stocks' , 'release_dt'];//Fakerで精製を許可するカラム




}

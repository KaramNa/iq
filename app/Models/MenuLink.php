<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use Translatable;

    public $guarded=['id','created_at','updated_at'];

    public array $translatedAttributes = ['title'];
}

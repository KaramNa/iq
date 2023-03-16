<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use  Translatable;

    public $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = ['name', 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

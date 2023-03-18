<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use Translatable;

    public $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = ['question', 'answer'];

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
}

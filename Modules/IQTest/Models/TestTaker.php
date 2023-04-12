<?php

namespace Modules\IQTest\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestTaker extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\IQTest\Database\factories\TestTakerFactory::new();
    }
}

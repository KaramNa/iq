<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
   protected $guarded = ['id', 'created_id', 'updated_at'];

   public function test(): BelongsTo
   {
       return $this->belongsTo(Test::class);
   }
}

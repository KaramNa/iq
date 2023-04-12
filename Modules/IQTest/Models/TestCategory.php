<?php

namespace Modules\IQTest\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestCategory extends Model implements TranslatableContract
{
    use Translatable;
    public $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = ['name', 'slug', 'description', 'meta_description'];


    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}

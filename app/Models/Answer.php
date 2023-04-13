<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MainHelper;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Answer extends Model implements HasMedia, TranslatableContract
{
    use InteractsWithMedia, Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = ['content'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function image($type = 'thumb')
    {
        if ($this->image == null) {
            return env('DEFAULT_IMAGE');
        } else {
            return env("STORAGE_URL") . '/' . MainHelper::get_conversion($this->image, $type);
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 350, 1000)
            ->width(350)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();
    }
}

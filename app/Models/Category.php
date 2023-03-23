<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;

    use InteractsWithMedia, Translatable;

    public $guarded = ['id', 'created_at', 'updated_at'];
    public $appends = ['url'];

    public array $translatedAttributes = ['name', 'slug', 'description', 'meta_description'];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getUrlAttribute()
    {
        return route('category.show', $this);
    }

    public function articles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'article_categories');
    }

    public function image($type = 'thumb')
    {
        if ($this->image == null) {
            return env('DEFAULT_IMAGE');
        } else {
            return env("STORAGE_URL") . '/' . \MainHelper::get_conversion($this->image, $type);
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('tiny')
            ->fit(Manipulations::FIT_MAX, 120, 120)
            ->width(120)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 350, 1000)
            ->width(350)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('original')
            ->fit(Manipulations::FIT_MAX, 1200, 10000)
            ->width(1200)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();
    }

}

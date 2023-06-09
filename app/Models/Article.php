<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

use MainHelper;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class Article extends Model implements HasMedia, TranslatableContract
{
    use InteractsWithMedia, Translatable;

    public $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = ['title', 'slug', 'description', 'meta_description'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function item_seens()
    {
        return $this->hasMany(ItemSeen::class, 'type_id', 'id')->where('type', "ARTICLE");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class, 'article_id');
    }

    public function image($type = 'thumb')
    {
        if ($this->image == null) {
            return env('DEFAULT_IMAGE');
        } else {
            return env("STORAGE_URL") . '/' . MainHelper::get_conversion($this->image, $type);
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
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

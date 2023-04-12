<?php

namespace Modules\IQTest\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MainHelper;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Test extends Model implements HasMedia, TranslatableContract
{
    use Translatable, InteractsWithMedia;

    public $guarded = ['id', 'created_at', 'update_at'];

    public array $translatedAttributes = ['title', 'slug', 'description', 'meta_description'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testCategory(): BelongsTo
    {
        return $this->belongsTo(TestCategory::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
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

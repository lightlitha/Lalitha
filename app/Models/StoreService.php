<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;

class StoreService extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = ['sku', 'name', 'price', 'cost', 'duration', 'delay_time', 'tag'];

    /**
     * Retrieve last created media file
     * Spatie
     */
    public static function last()
    {
        return static::all()->last();
    }

    /**
     * Media Collection
     * Spatie
     */
    public function registerMediaCollections() : void
    {
        // Avatar image ['image/jpeg', 'image/png', 'image/webp']
        $this->addMediaCollection('service')->singleFile();
        // ->acceptsFile(function (File $file) {
        //     return $file->mimeType === ['image/jpeg', 'image/png', 'image/webp'];
        // })
    }

    /**
     * Media Conversions
     * Spatie
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(60)
              ->height(60)
              ->sharpen(10);
    }

    /**
     * Date Format 
     */
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
    }
    /**
     * Date Format 
     */
    public function getUpdatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}

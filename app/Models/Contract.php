<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;

class Contract extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $timestamps = false;
    protected $fillable = [
        'begin', 'end', 'is_signed', 'is_permanent', 'is_active', 'note', 'employee_id'
    ];

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
        $this->addMediaCollection('contract')->singleFile();
    }

    /**
     * Date Format 
     */
    public function getBeginAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
    /**
     * Date Format 
     */
    public function getEndAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * Get the employee that owns.
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}

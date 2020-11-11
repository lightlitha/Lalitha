<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;

class Employee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'first_name', 'last_name', 'date_of_birth', 'id_number', 'passport_number', 'is_available', 'is_active', 'nationality', 'user_id'
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
        // Avatar image ['image/jpeg', 'image/png', 'image/webp']
        $this->addMediaCollection('avatar')->singleFile();
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
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
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

    /**
     * Get the user record associated with the employee.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
    * @return Address|null
    */
    public function getAddress()
    {
        if ( ! $this->getAttribute('employee_id')) {
            return null;
        }
        return $this->getAttribute('address');
    }

    /**
     * Get the address record associated with the employee.
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Get the contact record associated with the employee.
     */
    public function contact()
    {
        return $this->hasOne('App\Models\Contact');
    }

    /**
     * Get the Next Of Kin record associated with the employee.
     */
    public function next_of_kin()
    {
        return $this->hasOne('App\Models\NextOfKin');
    }

    /**
     * Get the Contract record associated with the employee.
     */
    public function contract()
    {
        return $this->hasOne('App\Models\Contract');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'cellphone', 'home', 'telephone', 'work', 'other', 'employee_id'
    ];

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
     * Get the employee that owns.
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }
}

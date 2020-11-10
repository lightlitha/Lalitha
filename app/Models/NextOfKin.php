<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'first_name', 'last_name', 'cellphone', 'other_phone', 'employee_id'
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

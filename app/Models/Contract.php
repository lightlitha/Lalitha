<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'begin', 'end', 'is_signed', 'is_permanent', 'is_active', 'note', 'employee_id'
    ];
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

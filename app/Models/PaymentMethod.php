<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'percentage_charge', 'amount_charge', 'is_active', 'description'];

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

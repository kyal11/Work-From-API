<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'user_id',
        'booking_date',
        'start_date',
        'end_date',
        'status',
    ];
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_id', 'id');
    }

    public function properties(): BelongsToMany {
        return $this->belongsToMany(Property::class, 'property_id', 'id');
    }
}

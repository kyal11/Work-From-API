<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'price',
        'capacity',
        'description',
        'status',
    ];
    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function facilities(): HasMany {
        return $this->hasMany(Facility::class, 'property_id', 'id');
    }
    public function orders(): HasMany {
        return $this->hasMany(Order::class, 'property_id', 'id');
    }
}

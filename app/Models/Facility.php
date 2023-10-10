<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'description',
    ];
    public function properties(): BelongsTo {
        return $this->belongsTo(Property::class, 'propertie_id', 'id');
    }
}

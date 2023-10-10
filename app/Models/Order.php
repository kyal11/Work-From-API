<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'user_id',
        'tanggal_pesan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_id', 'id');
    }

    public function properties(): BelongsToMany {
        return $this->belongsToMany(User::class, 'property_id', 'id');
    }
}

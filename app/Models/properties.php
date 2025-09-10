<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class properties extends Model
{
    public $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'type',
        'address',
        'city',
        'latitude',
        'longitude',
        'category_id',
    ];
    public function owners():BelongsTo{
        return $this->belongsTo(User::class,"user_id");
    }
    public function category():BelongsTo{
        return $this->belongsTo(categories::class,"category_id");
    }
    public function images():HasMany{
        return $this->hasMany(property_images::class,"property_id");
    }
}

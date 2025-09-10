<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class property_images extends Model
{
    protected $fillable =[
        'property_id',
        'image_url',
    ];
    public function property():BelongsTo{
        return $this->belongsTo(properties::class,"property_id");
    }
}

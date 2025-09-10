<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class call_requests extends Model
{
    protected $fillable=[
        'property_id',
        'requester_id',
        'owner_id',
        'status',
        'call_duration'
    ];
    /**
     * A call request is related to a property.
     */
    public function property():BelongsTo
    {
        return $this->belongsTo(properties::class);
    }

    /**
     * The user who made the call request (requester).
     */
    public function requester():BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * The owner who receives the call request.
     */
    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}

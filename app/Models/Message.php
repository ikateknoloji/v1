<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'customer_id',
    ];

    /**
     * Get the customer that owns the message.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

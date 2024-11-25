<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_receiver_id',
        'title',
        'text',
        'status',
    ];

    public function receiver()
    {
        return $this->belongsTo(EmailReceiver::class, 'email_receiver_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmailReceiver extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email_address',
        'email_verified_at',
        'status'
    ];

    public function histories()
    {
        return $this->hasMany(EmailHistory::class);
    }

    public function routeNotificationForMail()
    {
        return $this->email_address;
    }

}

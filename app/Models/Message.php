<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    ////////// Relations
    ///
    public function conversation()
    {
        return $this->belongsTo(Converstion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
}

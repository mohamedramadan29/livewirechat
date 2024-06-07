<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Converstion extends Model
{
    use HasFactory;
    protected $guarded = [];
    //////////// methods
    ///
    public function messages()
    {
        return $this->hasMany(Message::class,'conversation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

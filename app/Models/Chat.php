<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'user_id', 'channel_id'];

    public function channel()
    {
        $this->belongsTo(Channel::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}

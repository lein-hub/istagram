<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'channel_user');
    }
}

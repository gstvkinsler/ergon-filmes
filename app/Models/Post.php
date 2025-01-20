<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followers()
    {
        return $this->hasMany(PostFollower::class);
    }

    public function usersFollowing()
    {
        return $this->belongsToMany(User::class, 'post_followers');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'concluido');
    }
}

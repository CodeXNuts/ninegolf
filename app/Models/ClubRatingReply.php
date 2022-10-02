<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubRatingReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'club_rating_id',
        'user_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

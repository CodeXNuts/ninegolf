<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubRating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','club_id','rating','comment'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function clubRatingReplies()
    {
        return $this->hasMany(ClubRatingReply::class);
    }
}

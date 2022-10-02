<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['club_list_id','image_path'];
    
}

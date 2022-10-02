<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jorenvh\Share\ShareFacade;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'set_name',
        'slug',
        'type',
        'gender',
        'dexterity',
        'set_price',
        'set_price_unit',
        'user_id',
        'adv_time',
        'is_active'
    ];
    protected $with = 'clubLists';

    protected $appends = ['share_btn'];

    public function getShareBtnAttribute()
        {
            return ShareFacade::page(
                route('product.view',['club'=>$this->slug]),
                'Share It',
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp();
        }


    public function clubLists()
    {
        return $this->hasMany(ClubList::class);
    }

    public function clubImages()
    {
        return $this->hasManyThrough(ClubImage::class, ClubList::class);
    }

    public function clubAddresses()
    {
        return $this->hasMany(ClubAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clubRatings()
    {
        return $this->hasMany(ClubRating::class);
    }
}

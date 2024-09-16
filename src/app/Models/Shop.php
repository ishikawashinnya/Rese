<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genre_id',
        'area_id',
        'description',
        'address',
        'image_url'
    ];

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function representative(){
        return $this->hasOne(Representative::class);
    }
}

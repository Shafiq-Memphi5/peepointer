<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toilet extends Model
{
    protected $table = "toilets";
    protected $fillable = [
        'name',
        'address',
        'pricing',
        'latitude',
        'longitude',
        'description',
        'user_id',
        'status',
        'images'
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'toilet_id');
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\Report::class, 'toilet_id');
    }
}

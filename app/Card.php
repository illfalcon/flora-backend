<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['flower_id', 'message', 'destination'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function flower()
    {
        return $this->hasOne(Flower::class);
    }
}

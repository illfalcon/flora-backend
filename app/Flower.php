<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    protected $fillable = ['name', 'info', 'image', 'name_color', 'description_color', 'light_color', 'main_color'];
}

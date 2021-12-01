<?php

namespace Petrik\Rajzfilmek;

use Illuminate\Database\Eloquent\Model;

class Rajzfilm extends Model {
    protected $table = 'komment';
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
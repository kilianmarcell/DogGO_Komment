<?php

namespace Doggo\Komment;

use Illuminate\Database\Eloquent\Model;

class Komment extends Model {
    protected $table = 'komment';
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
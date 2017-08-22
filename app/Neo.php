<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neo extends Model {

    protected $fillable = ['name', 'reference_id', 'speed', 'is_hazardous', 'date'];

}

<?php

namespace MP\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{


    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'bases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}

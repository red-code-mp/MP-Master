<?php


namespace MP\Base\Traits;


use Carbon\Carbon;

trait AbstractMutator
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d h:m');
    }
}

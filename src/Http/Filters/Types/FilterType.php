<?php


namespace MP\Base\Http\Filters\Types;

abstract class FilterType
{
    /**
     * base filter type
     *
     * @param $builder
     * @param $filter
     * @return mixed
     * @author Amr
     */
    public function filter($builder, $filter)
    {
        return $builder;
    }
}

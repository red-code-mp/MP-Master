<?php


namespace MP\Base\Http\Filters\Types;


class ParentFilter
{
    /**
     * @param $builder
     * @param $filter
     * @return mixed
     * filter by column inside same table
     * @author khalid
     */
    public function filter($builder, $filter)
    {
        if ($filter == 'false')
            return $builder->whereNotNull('parent_id');
        return $builder->whereNull('parent_id');
    }
}

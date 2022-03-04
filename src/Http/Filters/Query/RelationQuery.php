<?php


namespace MP\Base\Http\Filters\Query;


class RelationQuery
{
    /**
     * @author khalid
     * @param $builder
     * @param $filter
     * @return mixed
     * filter by relation
     */
    public function filter($builder, $filter)
    {
        return $builder->whereHas($filter['on'], function ($query) use ($filter) {
            return $query->{$filter['method']}($filter['column'], $filter['operand'], $filter['value']);
        });
    }
}

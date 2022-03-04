<?php


namespace MP\Base\Http\Filters\Query;

use Illuminate\Support\Facades\DB;

class SelfQuery
{
    /**
     * @author khalid
     * @param $builder
     * @param $filter
     * @return mixed
     * filter by column inside same table
     */
    public function filter($builder, $filter)
    {
        switch ($filter['operand']){
            case 'like':
                $type = DB::connection()->getDoctrineColumn($builder->getModel()->getTable(), $filter['column'])->getType()->getName();
                if (strcmp($type,'text') == 0)
                    return $builder->{$filter['method']}("{$filter['column']}->en", $filter['operand'], $filter['value']);
                return $builder->{$filter['method']}($filter['column'], $filter['operand'], $filter['value']);
            default:
                return $builder->{$filter['method']}($filter['column'], $filter['operand'], $filter['value']);
        }
    }
}

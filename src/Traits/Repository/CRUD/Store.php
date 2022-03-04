<?php


namespace MP\Base\Traits\Repository\CRUD;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait Store
{
    /**
     * store new resource
     *
     * @param Request $request
     * @return mixed
     *
     * @author Amr
     */
    function store(Request $request)
    {
        return db_transaction(function () use ($request) {
            $model = $this->getModel()->create($this->getRequestAttributes($request));
            $__hasRelation = $this->hasRelation();
            if ($__hasRelation)
                $this->storeRelation($request, $model);
            return $this->collection($model);
        });
    }


    /**
     * store model's relations
     *
     * @param $request
     * @param $model
     * @return mixed
     * @author Amr
     */
    function storeRelation($request, $model)
    {
        collect($this->getRelation())->each(function ($value, $key) use ($request, $model) {
            if (!array_key_exists($key,$request->all()))
                return true;
            $model->{$value}()->delete();
            $model->refresh();
            $data = $this->getRelationRequestAttributes($request, $request->input($key), $value);
            $model->{$value}()->createMany($data);
        });
    }
}

<?php


namespace MP\Base\Traits\Repository\CRUD;


trait Delete
{
    /**
     * delete resource
     * @param $id
     * @return mixed
     * @author Amr
     */
    function delete($id)
    {
        return db_transaction(function () {
            $model = $this->findModel(request()->route('id'));
            $model->delete();
            $__hasRelation = $this->hasRelation();
            if ($__hasRelation)
                $this->deleteRelations(request(), $model);
            return $this->collection($model);
        });
    }

    /**
     * delete model's relations
     *
     * @param $request
     * @param $model
     * @return mixed
     * @author Amr
     */
    function deleteRelations($request, $model)
    {
        collect($this->getRelation())->each(function ($value, $key) use ($request, $model) {
            $model->{$value}()->delete();
        });
    }
}

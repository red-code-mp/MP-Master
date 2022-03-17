<?php


namespace MP\Base\Traits\Repository\CRUD;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait Update
{

    /**
     * update resource according to the given
     * id
     *
     * @param Request $request
     * @param $id
     * @return mixed
     *
     * @author Amr
     */
    public function update(Request $request, $id)
    {
       return db_transaction(function()use($request){
           $model = $this->findModel(request()->route('id'));
           $model->fill($this->getRequestAttributes($request));
           $model->update();
           $__hasRelation = $this->hasRelation();
           if ($__hasRelation)
               $this->updateRelation($request, $model);
           return $this->collection($model->refresh());
       });
    }

    /**
     * update resource according to the given
     * id
     *
     * @param Request $request
     * @param $id
     * @return mixed
     *
     * @author Amr
     */
    public function changeActive(Request $request, $id)
    {
        $model = $this->findModel($id);
        $model->is_active = $request->input('is_active');
        $model->update();
        return $this->collection($model->refresh());
    }

    /**
     * store model's relations
     *
     * @param $request
     * @param $model
     * @return mixed
     * @author Amr
     */
    function updateRelation($request, $model)
    {
        return $this->storeRelation($request, $model , true);
    }
}

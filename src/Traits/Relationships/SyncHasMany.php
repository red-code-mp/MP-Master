<?php


namespace MP\Base\Traits\Relationships;


use Illuminate\Support\Facades\DB;

trait SyncHasMany
{
    /**
     * @author khalid
     * @param $model
     * @param $associated
     * @param $relatedModel
     * @return mixed
     * @throws \Exception
     * sync one to many relationship
     */
    public function syncMany($model, $associated, $relatedModel)
    {
        DB::beginTransaction();
        try {
            if ($associated) {
                $relatedModelClass = $this->modelRelationship($model,$relatedModel); // return class of related model

                $fill = (new $relatedModelClass)->getFillable(); // return fillable of related model

                $itemsIds = $model->{$relatedModel}()->get(['id'])->pluck('id'); // get ids of model items

//                $preparedAttrs = $this->prepareRequestAttributes($associated); //prepare request attributes

                $collectItems = collect($associated);

                $rowsIds = array_filter($collectItems->pluck('id')->toArray(),
                    function ($value) {
                        return !is_null($value) && $value !== '';
                    });// filter array to remove null or empty values
                /**
                 * update all records that there ids matching with ids of request items
                 */
                foreach ($rowsIds as $item) {
                    $i = $collectItems->where('id', $item)->first();
                    $relatedModelClass::findOrFail($item)->update(collect($this->prepareRequestAttributes($i))->only($fill)->toArray());
                }
                /**
                 * create new record that doesn't include id
                 */
                foreach ($collectItems->whereNotIn('id', $rowsIds)->all() as $item) {
                    $model->{$relatedModel}()->create(collect($this->prepareRequestAttributes($item))->only($fill)->toArray());
                }
                /**
                 * drop records that are ids not in the request
                 */
                foreach (array_diff($itemsIds->toArray(), $rowsIds) as $dif) {
                    $relatedModelClass::findOrFail($dif)->delete();
                }
            }
            DB::commit();
            return $model;
        } catch (\Exception $ex) {
            DB::rollback();
            throw new \Exception($ex);
        }
    }

    /**
     * @author khalid
     * @param $arr
     * @return mixed
     * prepare request attributes, extract id from value that have array type
     */
    public function prepareRequestAttributes($arr)
    {
        foreach ($arr as $key => $item) {
            if (gettype($item) == 'array' && array_key_exists('id',$item)){
                $arr[$key] = $arr[$key]['id'];
            }
        }
        return $arr;
    }

    /**
     * @author khalid
     * @param $model
     * @param $relatedModel
     * @return string
     * @throws \ReflectionException
     * return related model class
     */
    public function modelRelationship($model, $relatedModel)
    {
        $reflection = new \ReflectionClass($model);
        $method = $reflection->getMethod($relatedModel);
        return (new \ReflectionClass($method->invoke(new $model)->getRelated()))->getName();
    }
}

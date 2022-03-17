<?php


namespace MP\Base\Traits\Repository;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Request
{
    /**
     * file container
     * @author Amr
     * @var null
     */
    public $filePath = null;
    /**
     * storage's disk
     * @author Amr
     * @var null
     */
    public $disk = 'public';

    /**
     * get request params then change their structure
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @author Amr
     */
    protected function getRequestAttributes(\Illuminate\Http\Request $request, $model = null)
    {
        return $this->parseRequestAttributes($request->only(($this->getModel() ?? $model)->getFillable()));
    }

    /**
     * get single relations' request params then change their structure
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @author Amr
     */
    protected function getSingleRelationAttributes(\Illuminate\Http\Request $request, $relationData, $relationName)
    {
        return collect($relationData)->map(function ($data) {
            if (is_array($data) && collect($data)->has('id'))
                return collect($data)->get('id');
            return $data;
        })->toArray();

    }

    /**
     * get relations' request params then change their structure
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @author Amr
     */
    protected function getRelationRequestAttributes(\Illuminate\Http\Request $request, $relationData, $relationName)
    {
        try {
            return  $this->{'get'.ucfirst($relationName) . "RelationAttributes"}($request, $relationData);
        } catch (\Exception $exception) {
            $request->route()->forgetParameter('id');
            if(array_is_list($relationData))
                return collect($relationData)->map(function($data) use($request){
                    return $this->mergeRouteParameterWithRelation($request , $data);
                })->toArray();
            else
                return $this->mergeRouteParameterWithRelation($request , $relationData);
        }

    }

    /**
     * merge route's parameter with the data of relation
     *
     * @param $request
     * @param $data
     * @return array
     */
    protected function mergeRouteParameterWithRelation($request , $data){
        return array_merge($data , $request->route()->parameters() );
    }

    /**
     * check if the passed params have an array value and that array
     * has id attribute, just get id's value and drop the other attributes
     *
     * @param $request
     * @return array
     * @author Amr
     */
    protected function parseRequestAttributes($request)
    {

        return collect($request)->map(function ($field, $index) use ($request) {
            if (is_array($field) && collect($field)->has('id'))
                return collect($field)->get('id');
            if ($field instanceof UploadedFile) {
                $field = $this->uploadFile($field, $index, $request);
            }
            return $field;
        })->toArray();
    }

    /**
     * get fil path according which relates to the storage's path
     * @return string
     * @author Amr
     */
    function getFilePath()
    {
        $modelName = $this->getModelName();
        return $this->filePath ? "/{$this->filePath}" : "/{$modelName}";
    }

    /**
     * upload files
     *
     * @param $file
     * @return mixed
     * !@author Amr
     */
    private function uploadFile($file, $index, $fullRequest)
    {
        $this->removeOldImage($index);
        return str_replace('public/', '', $file->store($this->disk . $this->getFilePath()));
    }

    /**
     * remove old Image from the given container
     * @param $index
     * @author Amr
     */
    private function removeOldImage($index)
    {

        $hasUpdate = $this->checkIfUpdateResource();
        if (!$hasUpdate)
            return;
        $id = request()->route()->parameter('id');
        $model = $this->findModel($id);
        $isExisted = Storage::disk($this->disk)->exists($model->{$index});
        if ($isExisted)
            Storage::disk($this->disk)->delete($model->{$index});
    }

    /**
     * check if the resource is an update resource
     * @return bool
     * @author Amr
     */
    private function checkIfUpdateResource()
    {
        return Str::contains(Str::lower($this->getActionMethod()), 'update');
    }

}

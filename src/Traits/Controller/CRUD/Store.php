<?php


namespace MP\Base\Traits\Controller\CRUD;


trait Store
{
    /**
     * create new resource
     *
     * @param \MP\Base\Http\Requests\Request $request
     * @return mixed
     * @author Amr
     */
    public function store(\MP\Base\Http\Requests\Request $request)
    {
        $result = $this->getRepository()->store($request);
        return response()->vue(SUCCESS_RESPONSE, trans('MP::lang.messages.created_successfully', ['attribute' => $this->getTranslatedName()]), $result);
    }
}

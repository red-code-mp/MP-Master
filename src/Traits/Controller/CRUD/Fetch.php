<?php


namespace MP\Base\Traits\Controller\CRUD;


trait Fetch
{
    /**
     * show resource using the passed id
     *
     * @param \MP\Base\Http\Requests\Request $request
     * @return mixed
     * @author Amr
     */
    public function show($id)
    {
        $result = $this->getRepository()->show($id);
        return response()->vue(SUCCESS_RESPONSE, trans('MP::lang.messages.fetched_successfully', ['attribute' => $this->getTranslatedName()]), $result);
    }

    /**
     * show all records of resource
     *
     * @param \MP\Base\Http\Requests\Request $request
     * @return mixed
     * @author Amr
     */
    public function index()
    {
        $result = $this->getRepository()->index();
        return response()->vue(SUCCESS_RESPONSE, trans('MP::lang.messages.fetched_successfully', ['attribute' => $this->getTranslatedName()]), $result);
    }
}

<?php


namespace MP\Base\Traits\Controller\CRUD;


trait Update
{
    /**
     * update resource using the passed id
     *
     * @param \MP\Base\Http\Requests\Request $request
     * @return mixed
     * @author Amr
     */
    public function update(\MP\Base\Http\Requests\Request $request, $id)
    {
        $result = $this->getRepository()->update($request, $id);
        return response()->vue(SUCCESS_RESPONSE, trans('MP::lang.messages.updated_successfully', ['attribute' => $this->getTranslatedName()]), $result);
    }
}

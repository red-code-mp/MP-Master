<?php


namespace MP\Base\Traits\Controller\CRUD;


trait Delete
{
    /**
     * delete resource using the passed id
     *
     * @param \MP\Base\Http\Requests\Request $request
     * @return mixed
     * @author Amr
     */
    public function delete($id)
    {
        $result = $this->getRepository()->delete($id);
        return response()->vue(SUCCESS_RESPONSE, trans('MP::lang.messages.deleted_successfully', ['attribute' => $this->getTranslatedName()]), $result);
    }
}

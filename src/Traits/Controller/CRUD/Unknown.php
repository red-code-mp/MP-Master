<?php


namespace MP\Base\Traits\Controller\CRUD;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait Unknown
{
    /**
     * redirect the unknown method directly to
     * the repository to handel it
     *
     * @param $method
     * @param $parameters
     * @return mixed
     * @author Amr
     */
    public function __call($method, $parameters)
    {
        $result = $this->getRepository()->{$method}(request(), ...$parameters);
        $trans = '';
        $method = strtolower(preg_replace('/(?<!\ )[A-Z]/', '_$0', $method));
        if (!strcmp($method, 'updateActive'))
            $trans = trans('MP::lang.messages.updateActive',
                ['attribute' => $this->getTranslatedName()]);
        else
            $trans = trans("{$this->__getModelFromModuleName()}::lang.{$method}");
        return response()->vue(SUCCESS_RESPONSE, trans($trans), $result ?? []);
    }
}

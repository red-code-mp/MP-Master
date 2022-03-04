<?php

namespace MP\Base\Http\Requests;

use MP\Base\Traits\Request\Fileable;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * id of model
     * @author Amr
     */
    public function id()
    {
        return $this->route()->hasParameter('id') ? ",{$this->route('id')}" : '';
    }


}

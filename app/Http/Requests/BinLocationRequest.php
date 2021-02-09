<?php

namespace App\Http\Requests;

use Input;
use Illuminate\Http\Request as x;
class BinLocationRequest extends Request
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
    public function rules(x $d)
    {
        return [
            'binCode' => 'required|unique:storage_locations,binCode,NULL,id,whsId,' . $d->whsId
        ];
    }
}

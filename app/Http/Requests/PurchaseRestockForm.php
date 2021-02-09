<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PurchaseRestockForm extends Request
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
            'orders.*.received'=>'numeric'
        ];
    }

    protected function getValidatorInstance()
    {
        $empty = [];
        $orders = json_decode($this->orders);
        foreach ($orders as $item) {
            array_push($empty, (array)$item);
        }
        $this->merge(array('orders' => $empty));
        return parent::getValidatorInstance();
    }
}

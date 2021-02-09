<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SalesOrderRequest extends Request
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
            'sales' => 'required',
            'sales.*.prod_id' => 'required|numeric',
            'sales.*.productDescription' => 'required',
            'sales.*.quantity' => 'required',
            'sales.*.convertedPrice' => 'required|numeric',
            'customerId' => 'required',
            'contactId' => 'required',
            'paymentMethod' => 'required',
            'paymentTerms' => 'required'

        ];
    }

    protected function getValidatorInstance()
    {
        if ($this->sales != null) {
            $empty = [];
            $sales = json_decode($this->sales);
            foreach ($sales as $item) {
                array_push($empty, (array)$item);
            }
            $this->merge(array('sales' => $empty));
        }
        return parent::getValidatorInstance();
    }
}

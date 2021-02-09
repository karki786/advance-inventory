<?php

namespace App\Http\Requests;

class PurchaseOrderFormRequest extends Request
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
            'orders.*.productDescription' => 'required',
            'orders.*.amount' => 'numeric|required',
            'orders.*.unitCost' => 'required|numeric',
            'orders.*.taxable' => 'required|boolean',
            'supplierId' => 'required',
            'lpoDate' => 'required',
            'deliverBy' => 'required'

        ];
    }


    protected function getValidatorInstance()
    {
        if ($this->orders != null) {
            $empty = [];
            $orders = json_decode($this->orders);
            foreach ($orders as $item) {
                array_push($empty, (array)$item);
            }
            $this->merge(array('orders' => $empty));
        }
        return parent::getValidatorInstance();
    }
}

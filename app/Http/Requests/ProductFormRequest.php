<?php namespace App\Http\Requests;

class ProductFormRequest extends Request
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
            'productName' => 'required',
            'location' => 'required_if:usesMultipleStorage,0',
            'locations.*.amount' => 'required_if:usesMultipleStorage,1|min:0|numeric',
            'locations.*.unitCost' => 'required_if:usesMultipleStorage,1|min:0|numeric',
            'amount' => 'numeric',
            'expiratyDate' => 'date',
            'reorderAmount' => 'numeric',
            'productTaxRate' => 'numeric|required',
            'sellingPrice' => 'numeric|required_if:usesMultipleStorage,0',
            // 'productImage' => 'string'
        ];
    }

    protected function getValidatorInstance()
    {

        if ($this->locations != null) {
            $empty = [];
            $items = json_decode($this->locations);
            foreach ($items as $item) {
                array_push($empty, (array)$item);
            }
            $this->merge(array('locations' => $empty));
        }
        return parent::getValidatorInstance();
    }


}

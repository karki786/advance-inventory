<?php namespace App\Http\Requests;

use App\Product;
use Illuminate\Http\Request as x;

class RestockFormRequest extends Request
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

        $product = Product::withoutGlobalScopes()->find($d->productID);
        if (count($product) < 1) {
            $string = "required";
        } elseif ($product->usesMultipleStorage == 1) {
            $string = "required";
        } else {
            $string = "";
        }
        return [
            'productID' => 'required',
            'amount' => 'numeric|required',
            'supplierID' => 'required',
            'unitCost' => 'required',
            'itemCost' => 'required',
            'productLocationId' => $string,
            'warehouseId' => $string,
        ];
    }

}

<?php namespace App\Http\Requests;

use App\ProductLocation;
use CodedCell\Repository\Product\ProductInterface;
use DB;
use Input;
use Validator;
use Illuminate\Http\Request as x;
class DispatchFormRequest extends Request
{

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

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
            'amount' => 'required',
            'dispatchedTo' => 'required',
            'productLocationHash' => 'required'
        ];
    }

}

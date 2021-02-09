<?php

namespace App\Http\Requests;

class CustomerFormRequest extends Request
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
            'companyName' => 'required',
            'active' => 'required',
            'companyEmail' => 'required|email',
            'companyCurrency' => 'required',
            'contacts.*.customerName' => 'required',
            'contacts.*.email' => 'required',
            'contacts.*.mobileNumber' => 'required'
        ];
    }

    protected function getValidatorInstance()
    {
        if ($this->contacts != null) {
            $empty = [];
            $contacts = json_decode($this->contacts);
            foreach ($contacts as $item) {
                array_push($empty, (array)$item);
            }
            $this->merge(array('contacts' => $empty));
        }
        return parent::getValidatorInstance();
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Validator;

class FileUploadRequest extends Request
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
        Validator::extend('img_min_size', function ($attribute, $value, $parameters) {
            $file = Request::file($attribute);
            $image_info = getimagesize($file);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            if ((isset($parameters[0]) && $parameters[0] != 0) && $image_width < $parameters[0]) return false;
            if ((isset($parameters[1]) && $parameters[1] != 0) && $image_height < $parameters[1]) return false;
            return true;
        });
        Validator::replacer('img_min_size', function ($message, $attribute, $rule, $parameters) {
            return "Your image must be larger than " . $parameters[0] . "px by " . $parameters[1] . "px Please Upload an image with a higher resolution, File has been removed";
        });

        return [
            'file' => 'image|between:0,300|img_min_size:500,500'
        ];
    }
}

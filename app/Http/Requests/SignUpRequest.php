<?php

namespace App\Http\Requests;

use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Responses\ResponseService;
class SignUpRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'name'=>'required',
            'phone'=>'required',
            'password'=>'required',
            'role'=>'required'
        ];
    }

    public function failedValidation(Validator $validator)
{
    
    // throw new ValidationException($validator, ResponseService::validation([],$validator->errors()));
}

}

<?php

namespace App\Http\Requests;

use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Responses\ResponseService;
class PhoneNumberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        return [
            'phone'=>'unique',        
        ];
    }

    public function failedValidation(Validator $validator)
{
    
    // throw new ValidationException($validator, ResponseService::validation([],$validator->errors()));
}

}

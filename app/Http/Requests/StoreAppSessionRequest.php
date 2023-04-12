<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;

class StoreAppSessionRequest extends FormRequest
{
    protected $errorBag = 'appform';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => 'required|string|min:3|max:30',
            'author_id' => 'nullable',
            'author_name' => 'nullable',
            'description' => 'required|string|min:3|max:200',
            'type' => 'required|in:1,2,3',
            'place' => 'nullable|string|min:3|max:50',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson())
        {
            $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $validator->errors()
            ]);            
        }else{
            Log::info($validator->getMessageBag());

            $response = redirect()
                ->route('dashboard')
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator);
               
        }
        
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}

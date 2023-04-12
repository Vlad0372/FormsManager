<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return ($this->input('action') == 'sendData' ? $this->store() : $this->update()); 
    }

    protected function store()
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
    protected function update()
    {
        return [
            'app_name' => 'nullable',
            'author_id' => 'nullable',
            'author_name' => 'nullable',
            'description' => 'nullable',
            'type' => 'nullable',
            'place' => 'nullable',
        ];
    }
}

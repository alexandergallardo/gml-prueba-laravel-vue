<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|alpha|max:100|min:5',
            'lastname' => 'required|alpha|max:100',
            'dni' => 'required|max:30|unique:users,dni',
            'email' => 'required|max:150|email|unique:users,email',
            'cellphone' => 'required|min:10|max:10',
            'direction' => 'max:180',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            '*.required' => 'The :attribute field is required.',
            '*.string' => 'The :attribute field must be a string.',
            '*.numeric' => 'The :attribute field must be a numeric.',
            '*.alpha' => 'The :attribute field must be a alphabetic characters.',
            '*.email' => 'The :attribute field must be a email address.',
            '*.unique' => 'The :attribute field already exists.',
            '*.exists' => 'The :attribute not exists.',
            'name.min' => 'The name must have at least 5 alphabetic characters.',
            'name.max' => 'The name must have a máximum of 100 alphabetic characters.',
            'lastname.max' => 'The lastname must have a máximum of 100 alphabetic characters.',
            'dni.max' => 'The DNI must have a máximum of 30 characters.',
            'email.max' => 'The email must have a máximum of 150 characters.',
            'cellphone.min' => 'The cellphone must 10 numeric characters.',
            'cellphone.max' => 'The cellphone must 10 numeric characters.',
            'direction.max' => 'The direction must 180 characters.',
        ];
    }
}

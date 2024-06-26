<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKriteriaRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug'=> 'required|exists:kriterias,id',
            'namakriteria'=> 'required|string|max:50',
            'bobot'=> 'required|numeric|max:10',
            "namasubkriteria"=> 'required|array',
            "namasubkriteria.*"=> 'required|string|max:50',
            'bobotsubkriteria'=> 'required|array',
            'bobotsubkriteria.*'=> 'required|numeric',
        ];
    }
}

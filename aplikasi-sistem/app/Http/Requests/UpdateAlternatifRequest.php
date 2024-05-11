<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlternatifRequest extends FormRequest
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
            'slug'=> 'required|exists:alternatifs,id',
            'nama'=> 'required|string|max:50',
            'penilaian'=> 'required|array',
            'penilaian.*.kriteria'=> 'required|exists:kriterias,id',
            'penilaian.*.nilai'=> 'required|numeric',
        ];
    }
}

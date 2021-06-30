<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnuncioStoreRequest extends FormRequest
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
        return ['titulo' => 'required|max:255',
        'descripcion' => 'required|max:255',
        'precio' => 'required|numeric|min:0',
        'imagen' => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048'];;
    }
}

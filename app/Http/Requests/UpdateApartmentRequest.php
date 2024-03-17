<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rooms' => 'required|integer|min:1|max:255',
            'beds' => 'required|integer|min:1|max:255',
            'bathrooms' => 'required|integer|min:1|max:255',
            'square_meters' => 'required|integer|min:1|max:50000',
            'address' => 'required|string|max:255',
            // 'latitude' => 'required|numeric',
            // 'longitude' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:1024',
            'services' => 'required|exists:services,id',
            'is_visible' => 'required|boolean',
            'sponsor' => 'nullable|string'
        ];
    }
}

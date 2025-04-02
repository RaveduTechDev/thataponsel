<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImeiRequest extends FormRequest
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
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tipe' => 'required|string|max:255',
            'imei' => 'required|string|max:255',
            'biaya' => 'required|numeric',
            'modal' => 'required|numeric',
            'profit' => 'required|numeric',
            'status' => 'required|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'agent_id' => 'nullable|exists:agents,id',
        ];
    }
}

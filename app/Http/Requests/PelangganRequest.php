<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->hasRole('super_admin|admin|agen')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pelanggan' => 'required|string',
            'nomor_wa' => 'required|phone',
        ];
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan harus diisi.',
            'nomor_wa.required' => 'Nomor WhatsApp harus diisi.',
            'nomor_wa.phone' => 'Nomor WhatsApp tidak valid.',
        ];
    }
}

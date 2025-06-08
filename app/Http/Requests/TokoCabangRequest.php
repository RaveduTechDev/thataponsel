<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TokoCabangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->hasRole(['super_admin', 'owner'])) {
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
            'nama_toko_cabang' => 'required|string',
            'penanggung_jawab_toko' => 'nullable|string',
            'alamat_toko' => 'required|string',
        ];
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'nama_toko_cabang.required' => 'Nama toko cabang harus diisi.',
            'alamat_toko.required' => 'Alamat toko cabang harus diisi.',
            'penanggung_jawab_toko.string' => 'Penanggung jawab toko harus berupa teks.',
        ];
    }
}

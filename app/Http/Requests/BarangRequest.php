<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
        $validate = [
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'memori' => 'required|string|max:50',
            'warna' => 'required|string|max:50',
            'satuan' => 'required|string|max:50|in:unit,fullset',
            'kategori' => 'required|string|max:100',
            'grade' => 'required|string|max:50',
            'keterangan' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($this->isMethod('post')) {
            $validate['kode_barang'] = 'required|string|max:50|unique:barangs,kode_barang';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['kode_barang'] = 'sometimes|required|string|max:50|unique:barangs,kode_barang,' . $this->route('barang');
        }

        return $validate;
    }
}

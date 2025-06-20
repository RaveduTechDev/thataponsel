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
        if ($this->user()->hasRole(['super_admin', 'admin', 'agen'])) {
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
        $validate = [
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'memori' => 'required|string|max:50',
            'warna' => 'required|string|max:50',
            'satuan' => 'required|string|max:50|in:unit,fullset',
            'kategori' => 'required|string|max:50|in:android,iphone,smartwatch,smartband,ipad,tablet,earbuds',
            'grade' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $validate['kode_barang'] = 'required|string|max:50|unique:barangs,kode_barang';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['kode_barang'] = 'sometimes|required|string|max:50|unique:barangs,kode_barang,' . $this->route('barang');
        }

        return $validate;
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang harus diisi.',
            'merk.required' => 'Merk barang harus diisi.',
            'tipe.required' => 'Tipe barang harus diisi.',
            'memori.required' => 'Memori barang harus diisi.',
            'warna.required' => 'Warna barang harus diisi.',
            'satuan.required' => 'Satuan barang harus dipilih.',
            'kategori.required' => 'Kategori barang harus dipilih.',
            'grade.required' => 'Grade barang harus dipilih.',
            'kode_barang.required' => 'Kode barang harus diisi.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'nama_barang'         => 'required|string|max:255',
            'satuan'              => 'required|string|max:50|in:unit,fullset',
            'kategori'            => 'required|string|max:100|in:android,apple',
            'grade'               => 'required|string|max:50',
            'imei_1'              => 'required|string|max:100',
            'imei_2'              => 'required|string|max:100',
            'jumlah_stok'         => 'required|integer|min:1',
            'modal'               => 'required|numeric|digits_between:1,25',
            'harga_jual'          => 'required|numeric|digits_between:1,25',
            'invoice'             => 'required|string|max:100',
            'keterangan'          => 'required|string',
            'foto'                => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($this->isMethod('post')) {
            $validate['kode_barang'] = 'required|string|max:50|unique:stocks,kode_barang';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['kode_barang'] = 'sometimes|required|string|max:50|unique:stocks,kode_barang,' . $this->route('stock');
        }

        return $validate;
    }
}

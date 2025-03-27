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
            'barang_id'           => 'required|integer|exists:barangs,id',
            'imei_1'              => 'nullable|string|max:100',
            'imei_2'              => 'nullable|string|max:100',
            'jumlah_stok'         => 'required|integer|min:1',
            'modal'               => 'required|numeric|digits_between:1,25',
            'harga_jual'          => 'required|numeric|digits_between:1,25',
            'invoice'             => 'required|string|max:100',
            'supplier'            => 'required|string',
            'no_kontak_supplier'  => 'nullable|phone',
            'tanggal'             => 'required|date',
        ];

        return $validate;
    }
}

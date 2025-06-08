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
        if ($this->user()->hasRole(['super_admin', 'admin', 'owner', 'agen'])) {
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
            'barang_id'           => 'required|integer|exists:barangs,id',
            'imei_1'              => 'nullable|string|max:100',
            'imei_2'              => 'nullable|string|max:100',
            'jumlah_stok'         => 'required|integer|min:1',
            'modal'               => 'required|numeric|digits_between:1,25|min:10000',
            'harga_jual'          => 'required|numeric|digits_between:1,25|min:10000',
            'invoice'             => 'nullable|string|max:100',
            'supplier'            => 'required|string',
            'no_kontak_supplier'  => 'nullable|phone',
            'tanggal'             => 'required|date',
            'keterangan'          => 'nullable|string|max:255',
        ];

        return $validate;
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'barang_id.required' => 'Barang harus dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'jumlah_stok.required' => 'Jumlah stok harus diisi.',
            'jumlah_stok.integer' => 'Jumlah stok harus berupa angka bulat.',
            'jumlah_stok.min' => 'Jumlah stok minimal 1.',
            'modal.required' => 'Modal harus diisi.',
            'modal.numeric' => 'Modal harus berupa angka.',
            'modal.digits_between' => 'Modal harus antara 1 hingga 25 digit.',
            'modal.min' => 'Modal minimal Rp10.000.',
            'harga_jual.required' => 'Harga jual harus diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.digits_between' => 'Harga jual harus antara 1 hingga 25 digit.',
            'harga_jual.min' => 'Harga jual minimal Rp10.000.',
            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'tanggal.date' => 'Tanggal transaksi tidak valid.',
        ];
    }
}

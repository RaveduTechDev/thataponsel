<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
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
            'invoice' => 'required|string|unique:penjualans,invoice',
            'barang_id' => 'required|exists:barangs,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'toko_cabang_id' => 'required|exists:toko_cabangs,id',
            'agent_id' => 'required|exists:agents,id',
            'subtotal' => 'required|numeric|digits_between:1,25',
            'diskon' => 'numeric',
            'total_bayar' => 'required|numeric|digits_between:1,25',
            'status' => 'required|in:proses,selesai,batal',
        ];
    }
}

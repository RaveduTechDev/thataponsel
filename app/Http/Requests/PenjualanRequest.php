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
        if ($this->isMethod('post') && $this->user()->hasRole(['super_admin', 'admin', 'agen'])) {
            return true;
        }
        if (($this->isMethod('put') || $this->isMethod('patch')) && $this->user()->hasRole(['super_admin', 'admin'])) {
            $penjualan = $this->route('penjualan');
            if (is_string($penjualan)) {
                $penjualan = \App\Models\Penjualan::find($penjualan);
            }
            if ($penjualan && $penjualan->status === 'selesai') {
                return false;
            }
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
            'stock_id' => 'required|exists:stocks,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'toko_cabang_id' => 'required|exists:toko_cabangs,id',
            'user_id' => 'sometimes|exists:users,id',
            'qty' => 'required|numeric|digits_between:1,25',
            'subtotal' => 'required|numeric|digits_between:1,25',
            'diskon' => 'numeric',
            'tanggal_transaksi' => 'required|date',
            'total_bayar' => 'required|numeric|digits_between:1,25',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris,e-wallet',
            'keterangan' => 'nullable|string',
            'status' => 'sometimes|in:proses,selesai',
        ];

        if ($this->isMethod('post')) {
            $validate['invoice'] = 'required|string|max:50|unique:penjualans,invoice';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['invoice'] = 'sometimes|required|string|max:50|unique:penjualans,invoice,' . $this->route('penjualan');
        }

        return $validate;
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'stock_id.required' => 'Barang harus dipilih.',
            'stock_id.exists' => 'Barang yang dipilih tidak valid.',
            'pelanggan_id.required' => 'Pelanggan harus dipilih.',
            'pelanggan_id.exists' => 'Pelanggan yang dipilih tidak valid.',
            'toko_cabang_id.required' => 'Toko cabang harus dipilih.',
            'toko_cabang_id.exists' => 'Toko cabang yang dipilih tidak valid.',
            'user_id.exists' => 'User yang dipilih tidak valid.',
            'qty.required' => 'Jumlah harus diisi.',
            'qty.numeric' => 'Jumlah harus berupa angka.',
            'subtotal.required' => 'Subtotal harus diisi.',
            'subtotal.numeric' => 'Subtotal harus berupa angka.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'tanggal_transaksi.required' => 'Tanggal transaksi harus diisi.',
            'tanggal_transaksi.date' => 'Tanggal transaksi tidak valid.',
            'total_bayar.required' => 'Total bayar harus diisi.',
            'total_bayar.numeric' => 'Total bayar harus berupa angka.',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'status.in' => 'Status tidak valid, pilih antara proses atau selesai.',
        ];
    }
}

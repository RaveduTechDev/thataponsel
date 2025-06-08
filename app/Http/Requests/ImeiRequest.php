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
        if ($this->isMethod('post') && $this->user()->hasAnyRole(['super_admin', 'admin', 'agen'])) {
            return true;
        }

        if (($this->isMethod('put') || $this->isMethod('patch')) && $this->user()->hasAnyRole(['super_admin', 'admin'])) {
            $jasaImei = $this->route('jasa_imei');
            if (is_string($jasaImei)) {
                $jasaImei = \App\Models\JasaImei::find($jasaImei);
            }
            if ($jasaImei && $jasaImei->status === 'selesai') {
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
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tipe' => 'required|string|in:slow,fast',
            'imei' => 'required|string|max:255|unique:jasa_imeis,imei',
            'biaya' => 'required|numeric|min:1',
            'dp_server' => 'required|numeric|min:0',
            'modal' => 'required|numeric|min:1',
            'sisa_server' => 'required|numeric|min:0',
            'profit' => 'required|numeric',
            'metode_pembayaran' => 'required|string|max:255|in:tunai,transfer,qris,e-wallet',
            'status' => 'required|string|max:255|in:proses,belum_lunas,selesai',
            'supplier' => 'sometimes|string|max:255',
            'no_kontak_supplier' => 'nullable|phone|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $validate['imei'] = 'required|string|max:255|unique:jasa_imeis,imei';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['imei'] = 'sometimes|required|string|max:255|unique:jasa_imeis,imei,' . $this->route('jasa_imei');
        }

        return $validate;
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'pelanggan_id.required' => 'Pelanggan harus dipilih.',
            'pelanggan_id.exists' => 'Pelanggan yang dipilih tidak valid.',
            'tipe.required' => 'Tipe jasa harus diisi.',
            'imei.required' => 'IMEI harus diisi.',
            'imei.unique' => 'IMEI sudah terdaftar.',
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'dp_server.required' => 'DP server harus diisi.',
            'dp_server.numeric' => 'DP server harus berupa angka.',
            'modal.required' => 'Modal harus diisi.',
            'modal.numeric' => 'Modal harus berupa angka.',
            'sisa_server.required' => 'Sisa server harus diisi.',
            'sisa_server.numeric' => 'Sisa server harus berupa angka.',
            'profit.required' => 'Profit harus diisi.',
            'profit.numeric' => 'Profit harus berupa angka.',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih.',
            'status.required' => 'Status harus dipilih.',
            'supplier.string' => 'Supplier harus berupa teks.',
            'no_kontak_supplier.phone' => 'Nomor kontak supplier tidak valid.',
            'user_id.exists' => 'User yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
        ];
    }
}

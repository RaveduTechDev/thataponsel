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
            'subtotal' => 'required|numeric|digits_between:1,25',
            'diskon' => 'numeric',
            'total_bayar' => 'required|numeric|digits_between:1,25',
            'status' => 'required|in:proses,selesai,batal',
        ];

        if ($this->isMethod('post')) {
            $validate['invoice'] = 'required|string|max:50|unique:penjualans,invoice';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['invoice'] = 'sometimes|required|string|max:50|unique:penjualans,invoice,' . $this->route('penjualan');
        }

        return $validate;
    }
}

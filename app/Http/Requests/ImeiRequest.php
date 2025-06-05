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
            'tipe' => 'required|string|max:255',
            'imei' => 'required|string|max:255|unique:jasa_imeis,imei',
            'biaya' => 'required|numeric|min:10000',
            'modal' => 'required|numeric|min:10000',
            'profit' => 'required|numeric',
            'metode_pembayaran' => 'required|string|max:255|in:tunai,transfer,qris,e-wallet',
            'status' => 'required|string|max:255|in:proses,selesai',
            'supplier' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'tanggal' => 'required|date',
        ];

        if ($this->isMethod('post')) {
            $validate['imei'] = 'required|string|max:255|unique:jasa_imeis,imei';
        } else if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validate['imei'] = 'sometimes|required|string|max:255|unique:jasa_imeis,imei,' . $this->route('jasa_imei');
        }

        return $validate;
    }
}

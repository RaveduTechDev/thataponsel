<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
            'nama_agen' => 'required|string',
            'nomor_wa' => 'required|phone:ID',
            'toko_cabang_id' => 'required|exists:toko_cabangs,id',
            'jumlah_transaksi' => 'required|integer',
        ];
    }
}

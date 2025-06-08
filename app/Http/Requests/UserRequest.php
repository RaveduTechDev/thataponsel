<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;


class UserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->hasRole(['super_admin', 'admin', 'owner'])) {
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
        $level = [];

        if ($this->user()->hasRole('super_admin')) {
            $level = ['required', 'string', 'in:owner,admin,agen'];
        } elseif ($this->user()->hasRole('owner')) {
            $level = ['required', 'string', 'in:admin,agen'];
        } else {
            $level = ['nullable', 'string', 'in:agen'];
        }

        $validated = [
            'name' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:255',
            'toko_cabang_id' => 'nullable|exists:toko_cabangs,id',
            'password' => $this->passwordRules(),
            'level' => $level,
        ];

        if ($this->isMethod('post')) {
            $validated['email'] = ['nullable', 'string', 'email', 'max:255', Rule::unique(User::class)];
            $validated['username'] = ['required', 'string', 'max:255', Rule::unique(User::class)];
            $validated['password'] = ['required', 'string', Password::default(), 'confirmed'];
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validated['email'] = ['nullable', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('agent'))];
            $validated['username'] = ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->route('agent'))];
            $validated['current_password'] = ['nullable', 'string', 'min:8', 'max:255'];
            $validated['password'] = ['nullable', 'string', Password::default(), 'confirmed'];
        }

        return $validated;
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pengguna harus diisi.',
            'nomor_wa.required' => 'Nomor WhatsApp harus diisi.',
            'toko_cabang_id.exists' => 'Toko cabang yang dipilih tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'level.required' => 'Level pengguna harus dipilih.',
        ];
    }
}

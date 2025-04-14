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
            $level = ['required', 'string', 'in:admin,agent'];
        } elseif ($this->user()->hasRole('admin')) {
            $level = ['nullable', 'string', 'in:agent', 'default:agent'];
        } elseif ($this->user()->hasRole('owner')) {
            $level = ['required', 'string', 'in:admin,agent'];
        }

        $validated = [
            'name' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:255',
            'toko_cabang_id' => 'required|exists:toko_cabangs,id',
            'password' => $this->passwordRules(),
            'level' => $level,
        ];

        if ($this->isMethod('post')) {
            $validated['email'] = [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ];

            $validated['username'] = [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ];

            $validated['password'] = ['required', 'string', Password::default(), 'confirmed'];
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $validated['email'] = [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->route('agent')),
            ];

            $validated['username'] = [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->route('agent')),
            ];

            $validated['current_password'] = ['nullable', 'string', 'min:8', 'max:255'];
            $validated['password'] = ['nullable', 'string', Password::default(), 'confirmed'];
        }

        return $validated;
    }
}

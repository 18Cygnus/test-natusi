<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransaksiRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'nama_pembeli' => ['nullable', 'string', 'max:150'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.obat_id' => ['required', 'integer', Rule::exists('obat', 'id_obat')],
            'items.*.qty' => ['required', 'regex:/^\d+$/', 'integer', 'min:1'],
        ];
    }
}

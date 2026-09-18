<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ObatRequest extends FormRequest
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
        $obat = $this->route('obat');

        return [
            'kode_obat' => [
                'required', 'string', 'max:45',
                Rule::unique('obat', 'kode_obat')->ignore($obat?->id_obat, 'id_obat'),
            ],
            'nama_obat' => ['required', 'string', 'max:255'],
            'satuan_obat' => ['required', 'string', 'max:45'],
            'harga_obat' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'numeric', 'min:0'],
            'stok_obat' => ['required', 'regex:/^\d+$/', 'integer', 'min:0'],
        ];
    }
}

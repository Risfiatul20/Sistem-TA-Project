<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProposalStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul' => 'required|max:255|min:10',
            'deskripsi' => 'nullable|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => 'Judul proposal harus diisi',
            'judul.min' => 'Judul minimal 10 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ];
    }
}
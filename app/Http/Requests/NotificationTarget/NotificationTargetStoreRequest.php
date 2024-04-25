<?php

namespace App\Http\Requests\NotificationTarget;

use Illuminate\Foundation\Http\FormRequest;

class NotificationTargetStoreRequest extends FormRequest
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
            'phone' => 'required|string',
            'destination' => 'required|string|in:TU,Walikelas,Guru,Bendahara,Kurikulum,Hubin,Kesiswaan,Kepala Sekolah,Meeting,Lainnya',
        ];
    }
}

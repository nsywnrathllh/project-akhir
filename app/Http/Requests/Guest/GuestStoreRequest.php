<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class GuestStoreRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|string',
            'destination' => 'required|in:TU,Walikelas,Guru,Bendahara,Kurikulum,Kesiswaan,Kepala Sekolah,Meeting,Lainnya',
            'purpose' => 'required',
            'has_vehicle' => 'required|in:Yes,No',
            'checkin' => 'required',
            'checkout' => 'nullable',
            'image_path' => 'nullable',
            'status' => 'required|in:Check Out,Still Inside',
        ];
    }
}

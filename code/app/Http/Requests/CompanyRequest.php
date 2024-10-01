<?php

namespace App\Http\Requests;

use App\Rules\Abn;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'trading_name' => 'string|max:255',
            'abn' => new Abn(),
            'acn' => 'string|regex:/^\d{3} ?\d{3} ?\d{3}$/',
            'invoice_email' => 'string|email',
            'phone' => 'string|max:45',
            'fax' => 'string|max:45',
            'company_id' => 'exists:companies,id',
        ];
    }
}
